# feat: database schema completo — GymPro (multi-tenant + pagos + pricing)

## Resumen

Agrega el archivo `blueprint.yaml` con el schema completo de la aplicación de administración de gimnasios. Incluye soporte multi-tenant con schema de Postgres por tenant (sin subdominios), módulo de pagos expandido, sistema de pricing con historial de precios y promociones.

---

## Contexto y decisiones de arquitectura

### Estrategia multi-tenant

Se adopta **shared database / schema por tenant** usando el `search_path` de Postgres, gestionado por `stancl/tenancy`.

- El tenant se identifica por **login**, no por subdominio. El usuario entra siempre a `gympro.com/login`.
- El `schema_name` en la tabla `tenants` (schema `public`) define el schema de Postgres asignado al gimnasio, por ejemplo `gym_elgriego`.
- En cada request HTTP y en cada job de cola, `stancl/tenancy` ejecuta `SET search_path TO gym_elgriego, public` antes de cualquier query.

**Por qué no subdominios:** mayor costo operativo (certificados SSL wildcard, configuración DNS por cliente, complejidad en el router). Esta estrategia da el mismo aislamiento real de datos sin ese overhead.

**Por qué no `tenant_id` en cada tabla:** el aislamiento depende completamente de que cada query lleve el scope correcto. Un Global Scope olvidado expone datos de otro cliente. Con schemas separados, Postgres garantiza el aislamiento a nivel de motor.

---

## Modelos nuevos o modificados

### Schema `public` (central)

| Modelo | Descripción |
|---|---|
| `Tenant` | Gimnasio cliente. Tiene `slug`, `schema_name`, `plan_suscripcion` y límites operativos (`max_sedes`, `max_socios`). |
| `TenantSuscripcion` | Historial de cambios de plan del tenant. Permite auditoría de billing. |

### Schema `gym_{slug}` (por tenant)

#### Planes y pricing

| Modelo | Descripción |
|---|---|
| `Plan` | Catálogo de planes. Tipos: `fijo`, `pase_dia`, `clases_sueltas`. Agrega `permite_acceso_multisede`, `orden_display` y `color_ui`. |
| `PlanPrecio` | **Nuevo.** Historial de precios por plan y sede. Nunca se sobreescribe el precio anterior — se cierra con `vigente_hasta` y se crea uno nuevo. Permite saber el precio exacto al que se firmó cada membresía. |
| `PlanBeneficio` | **Nuevo.** Lista de features/beneficios asociados a un plan. Para renderizar pricing cards en la UI con `incluido: true/false`. |
| `Promocion` | **Nuevo.** Descuentos por código o automáticos. Soporta `porcentaje`, `monto_fijo` y `meses_gratis`. Tiene control de usos totales y un uso por socio. |

#### Pagos

| Modelo | Descripción |
|---|---|
| `Pago` | Expandido. Separa `monto_bruto`, `monto_descuento`, `monto_matricula` y `monto_final`. Agrega soporte de cuotas (`cuota_numero` / `cuota_total`), `referencia_externa` para IDs de MercadoPago o transferencias, y campos de anulación auditados. |
| `PagoItem` | **Nuevo.** Líneas de detalle de un pago. Permite registrar pagos con múltiples conceptos en un solo comprobante. |
| `Deuda` | **Nuevo.** Saldos pendientes generados automáticamente (por ejemplo, al renovar sin pago inmediato). Se marca `pagada` cuando se registra el `Pago` correspondiente. |
| `Caja` | Separa `monto_cierre_real` (físico) de `monto_cierre_sistema` para detectar diferencias. |
| `MovimientoCaja` | Agrega tipo `ajuste` además de `ingreso`/`egreso`. Agrega `empleado_id` para auditar quién registró cada movimiento. |

#### Membresías

| Modelo | Descripción |
|---|---|
| `Membresia` | Agrega `plan_precio_id` para guardar el precio exacto al que se contrató. Agrega `veces_congelado` para respetar el límite del plan. Agrega `auto_renovar` y estado `pendiente_pago`. |
| `Socio` | Agrega `referido_por_id` (self-referencia) para trackear referidos. |

---

## Diagrama de relaciones — módulo pagos y pricing

```
Plan
 ├── PlanPrecio  (historial de precios, uno vigente por sede)
 ├── PlanBeneficio  (features para la UI)
 └── Promocion  (descuentos aplicables)

Socio
 └── Membresia  ──► Plan
                └──► PlanPrecio  (precio al que se contrató)

Pago  ──► Membresia
     ──► MetodoPago
     ──► Promocion (nullable)
     └── PagoItem[]  (líneas de detalle)

Deuda ──► Socio
      └──► Pago  (cuando se salda)

Caja ──► MovimientoCaja[]
              └──► Pago (nullable)
```

---

## Cómo usar el archivo

```bash
# Instalar Blueprint
composer require --dev laravel-shift/blueprint

# Generar migraciones, modelos, factories y controllers
php artisan blueprint:build

# Si querés solo ver qué va a generar sin ejecutar
php artisan blueprint:build --dry-run
```

> **Importante:** las tablas `tenants` y `tenant_suscripciones` deben estar en una migración separada con `$connection = 'pgsql'` (schema `public`). El resto de migraciones corren dentro del schema del tenant mediante `stancl/tenancy`.

---

## Capas de protección multi-tenant incluidas en el diseño

1. **Middleware `SetTenantSchema`** — obligatorio en todo el grupo `auth`. Setea el `search_path` antes de cualquier query.
2. **Trait `BelongsToTenant`** — lanza excepción si se intenta escribir sin tenant seteado.
3. **Jobs con `tenancy()->initialize($tenant)`** — jobs de cola y comandos Artisan reciben el tenant como parámetro explícito.
4. **Test de aislamiento en CI** — crea dos tenants, inserta en uno, verifica que el otro no ve los datos.

---

## Checklist antes de mergear

- [ ] Revisar que los enums de `Pago.estado` cubren todos los flujos del negocio
- [ ] Confirmar monedas soportadas en `PlanPrecio.moneda` y `Pago.moneda` (ARS por defecto)
- [ ] Definir si `Promocion` necesita restricción por método de pago
- [ ] Confirmar si `Deuda` se genera desde un Observer o desde el Service de membresías
- [ ] Agregar índices en `plan_precios.vigente_hasta` y `deudas.estado` (alto volumen de consulta)
- [ ] Separar migration de schema `public` de las migraciones de tenant

---

## Archivos modificados

- `blueprint.yaml` — schema completo actualizado
