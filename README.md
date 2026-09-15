# GymPro API

API REST multi-tenant para administración de gimnasios. Cada gimnasio corre aislado en su propio schema de PostgreSQL.

![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-4169E1?style=flat-square&logo=postgresql&logoColor=white)

---

## El problema

Un SaaS para gimnasios tiene que garantizar que el gimnasio A jamás vea los datos del gimnasio B. En un sistema con socios, pagos, deudas y mediciones corporales, una fuga de datos entre clientes no es un bug: es el fin del producto.

La pregunta de arquitectura, entonces, es **dónde vive esa garantía**.

## La decisión: un schema de Postgres por tenant

GymPro usa **shared database / schema por tenant**, gestionado con [`stancl/tenancy`](https://tenancyforlaravel.com/).

Cada gimnasio tiene un `schema_name` en la tabla `tenants` (schema `public`), por ejemplo `gym_elgriego`. En cada request HTTP y en cada job de cola se ejecuta, antes de cualquier query:

```sql
SET search_path TO gym_elgriego, public;
```

### Por qué no una columna `tenant_id`

Es la opción más común, y es la que se cae en producción.

Con `tenant_id`, el aislamiento depende de que **toda** query lleve el scope correcto. Un Global Scope que se olvida, un `DB::raw()` apurado, un join mal escrito — y un cliente ve los datos de otro. La garantía vive en la disciplina del equipo, que es el peor lugar donde ponerla.

Con schemas separados, **Postgres garantiza el aislamiento a nivel de motor**. Una query mal escrita no puede alcanzar datos de otro tenant, porque esos datos no están en el `search_path`.

### Por qué no subdominios

`stancl/tenancy` identifica tenants por dominio por defecto. GymPro no lo usa.

Los subdominios traen certificados SSL wildcard, configuración de DNS por cliente y complejidad en el router. El aislamiento real que aportan sobre esta estrategia es **cero**: el schema ya lo resuelve.

En su lugar, el tenant se identifica por **login** y por el header `X-Tenant`. Todos entran por la misma URL.

## Capas de protección

El schema es la garantía principal, pero no la única:

1. **Middleware `tenant`** — setea el `search_path` antes de cualquier query. Corre **antes** de `auth:sanctum`, porque la tabla `users` vive dentro del schema del tenant.
2. **Trait `BelongsToTenant`** — lanza excepción si se intenta escribir sin tenant seteado.
3. **Jobs con tenant explícito** — los jobs de cola y comandos Artisan reciben el tenant como parámetro, nunca lo heredan del contexto.
4. **Test de aislamiento** — dos tenants, insertar en uno, verificar que el otro no ve nada.

## Flujo de un request

```
POST /api/v1/socios
  │
  ├─ Header: X-Tenant: gym-elgriego
  │
  ├─ middleware 'tenant'
  │    └─ SET search_path TO gym_elgriego, public
  │
  ├─ middleware 'auth:sanctum'
  │    └─ busca el user DENTRO del schema del tenant
  │
  └─ SocioController → StoreRequest → Service → Model
```

El orden de los middleware no es un detalle: invertirlo rompe el login, porque Sanctum buscaría el usuario en el schema equivocado.

---

## Estructura

El proyecto separa responsabilidades por capa:

```
app/
├── Http/Controllers/Api/V1/   HTTP: recibe y responde
│   └── Admin/                 gestión de la plataforma (schema public)
├── Http/Requests/             validación de entrada
├── Http/Resources/            forma de la respuesta
├── Services/                  lógica de negocio
├── Repositories/              acceso a datos
├── DTOs/                      payloads tipados entre capas
├── Models/
└── Enums/                     estados del dominio, tipados
```

Los controllers no tienen lógica de negocio: reciben un Request validado, lo pasan a un Service y devuelven un Resource.

## Superficie de la API

**Central** (schema `public`, sin tenant)
```
GET  /api/v1/tenants
```

**Admin de plataforma** (`auth:admin`) — gestión del SaaS: tenants, planes de plataforma, facturas y pagos de suscripción.

**Tenant** (header `X-Tenant` + `auth:sanctum`) — el dominio del gimnasio:

| Módulo | Recursos |
|---|---|
| Socios | `socios`, `membresias`, `medicion-socios`, `asistencias` |
| Pricing | `planes`, `plan-precios`, `plan-beneficios`, `promociones` |
| Cobranza | `pagos`, `deudas`, `cajas` |
| Operación | `sedes`, `empleados`, `equipos`, `mantenimientos` |
| Clases | `clases`, `turno-clases`, `reservas` |
| Nutrición | `plan-nutricionales` |

### Decisiones del dominio que vale la pena mirar

- **`PlanPrecio`** — los precios nunca se sobreescriben. Se cierra el vigente con `vigente_hasta` y se crea uno nuevo. Así se sabe el precio exacto al que se firmó cada membresía, aunque la lista haya cambiado cinco veces.
- **`Pago`** — separa `monto_bruto`, `monto_descuento`, `monto_matricula` y `monto_final`. Un total sin desglose no se puede auditar.
- **`Caja`** — `monto_cierre_real` (lo que hay físicamente) contra `monto_cierre_sistema`. La diferencia es justamente el dato que importa.

## Documentación de la API

La documentación OpenAPI se genera sola desde el código con [Scramble](https://scramble.dedoc.co/), a partir de los Form Requests y los Resources.

```
/docs/api
```

No hay un archivo OpenAPI mantenido a mano, así que no se desactualiza.

---

## Stack

| | |
|---|---|
| PHP | 8.3 |
| Laravel | 13 |
| Base de datos | PostgreSQL (schema por tenant) |
| Multi-tenancy | `stancl/tenancy` 3.10 |
| Autenticación | Laravel Sanctum 4 |
| Docs | `dedoc/scramble` |
| Scaffolding | `laravel-shift/blueprint` |

## Instalación

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Configurar la conexión a PostgreSQL en `.env` y después:

```bash
php artisan migrate        # schema public: tenants, suscripciones
php artisan tenants:migrate # schema de cada tenant
php artisan serve
```

Tests:

```bash
composer test
```

Los tests corren sobre **PostgreSQL**, no SQLite: el aislamiento entre tenants depende de los schemas y del `search_path`, que SQLite no tiene. Correrlos sobre SQLite daría verde sin probar nada.

---

## Estado del proyecto

Proyecto personal, en desarrollo. El schema de datos y la arquitectura multi-tenant están definidos y funcionando; el resto avanza por módulos.

Lo que falta, dicho de frente:

- La cobertura es chica a propósito: `TenantIsolationTest` verifica la garantía central — que un gimnasio no pueda leer los datos de otro. Los stubs que había generado Blueprint se eliminaron: apuntaban a un namespace viejo y sus aserciones (`assertJsonStructure([])`) no verificaban comportamiento.
- El módulo de pagos no tiene integración con pasarela todavía. `referencia_externa` está previsto para IDs de MercadoPago.
- Falta definir si `Promocion` necesita restricción por método de pago.


## Licencia

[MIT](LICENSE)
