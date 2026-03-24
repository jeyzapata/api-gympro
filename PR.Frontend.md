# GymPro API — Guia para Frontend

## Base URL

```
http://api-gympro.test/api/v1
```

Documentacion interactiva (Swagger/OpenAPI): `http://api-gympro.test/docs/api`

---

## Arquitectura: Dos aplicaciones en una

GymPro tiene **dos interfaces** que comparten el mismo backend:

| App | Proposito | Auth | Header |
|-----|-----------|------|--------|
| **Panel Gym** | Gestion del gimnasio (socios, pagos, clases) | Bearer token | `X-Tenant: {slug}` |
| **Panel Admin** | Administracion de la plataforma SaaS (tenants, billing) | Bearer token (guard:admin) | Sin X-Tenant |

---

## Autenticacion

### Flujo de login — Panel Gym (tenant)

```
POST /v1/auth/login
Headers:
  Content-Type: application/json
  Accept: application/json
  X-Tenant: demo              <-- OBLIGATORIO

Body:
{
  "email": "admin@gymdemo.com",
  "password": "password"
}

Response 200:
{
  "success": true,
  "message": "Login exitoso.",
  "data": {
    "token": "1|abc123...",
    "user": {
      "id": 1,
      "email": "admin@gymdemo.com",
      "userable_type": "App\\Models\\Empleado",
      "userable_id": 1,
      "email_verified_at": null,
      "ultimo_login": null,
      "activo": true
    }
  }
}
```

### Flujo de login — Panel Admin (plataforma)

```
POST /v1/admin/auth/login
Headers:
  Content-Type: application/json
  Accept: application/json
  (SIN X-Tenant)

Body:
{
  "email": "admin@gympro.com",
  "password": "password"
}

Response 200:
{
  "success": true,
  "message": "Login exitoso.",
  "data": {
    "token": "1|xyz789...",
    "user": {
      "id": 1,
      "nombre": "Super",
      "apellido": "Admin",
      "email": "admin@gympro.com",
      "activo": true,
      "ultimo_login": "2026-03-24T23:31:12.000000Z",
      "created_at": "2026-03-24T23:30:23.000000Z"
    }
  }
}
```

### Despues del login

Guardar el token y enviarlo en TODOS los requests posteriores:

```
Headers:
  Authorization: Bearer 1|abc123...
  Accept: application/json
  X-Tenant: demo               <-- solo para Panel Gym
```

### Obtener usuario autenticado

```
GET /v1/auth/me          (Panel Gym — requiere X-Tenant + Bearer)
GET /v1/admin/auth/me    (Panel Admin — solo Bearer)
```

### Logout

```
POST /v1/auth/logout          (Panel Gym)
POST /v1/admin/auth/logout    (Panel Admin)
```

Revoca el token actual. Response: `204 No Content`.

---

## Header X-Tenant

**Todas las rutas del Panel Gym requieren el header `X-Tenant`** con el slug del gimnasio.

```
X-Tenant: demo
```

- Se obtiene en la pantalla de login (el usuario selecciona o escribe su gimnasio)
- Si falta: `400 {"success": false, "message": "Header X-Tenant es requerido."}`
- Si es invalido: `404 {"success": false, "message": "Tenant no encontrado o suscripcion inactiva."}`

Las rutas del **Panel Admin** (`/v1/admin/*`) NO usan X-Tenant.

---

## Formato de respuestas

### Exito (objeto unico)

```json
{
  "success": true,
  "message": "Creado exitosamente.",
  "data": {
    "id": 1,
    "nombre": "Sede Central",
    "created_at": "2026-03-24T20:00:00.000000Z"
  }
}
```

### Exito (lista paginada)

```json
{
  "data": [
    { "id": 1, "nombre": "Sede Central" },
    { "id": 2, "nombre": "Sede Norte" }
  ],
  "links": {
    "first": "http://api-gympro.test/api/v1/sedes?page=1",
    "last": "http://api-gympro.test/api/v1/sedes?page=3",
    "prev": null,
    "next": "http://api-gympro.test/api/v1/sedes?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 3,
    "per_page": 15,
    "to": 15,
    "total": 42
  }
}
```

### Paginacion

Todos los endpoints `index` aceptan:
- `?per_page=25` (maximo 100, default 15)
- `?page=2`

### Error — Validacion (422)

```json
{
  "success": false,
  "message": "Datos invalidos.",
  "errors": {
    "email": ["El campo email es obligatorio."],
    "nombre": ["El campo nombre debe tener al menos 2 caracteres."]
  }
}
```

### Error — No autenticado (401)

```json
{
  "success": false,
  "message": "No autenticado."
}
```

### Error — Sin permisos (403)

```json
{
  "success": false,
  "message": "Sin permisos."
}
```

### Error — No encontrado (404)

```json
{
  "success": false,
  "message": "Recurso no encontrado."
}
```

### Error — Rate limit (429)

```json
{
  "success": false,
  "message": "Demasiados intentos de login. Intenta de nuevo en un minuto."
}
```

Login: 5 intentos por minuto (por IP + email).
API general: 60 requests por minuto (por usuario).

### Error — Servidor (500)

```json
{
  "success": false,
  "message": "Error interno del servidor."
}
```

---

## HTTP Status Codes

| Codigo | Significado | Cuando |
|--------|-------------|--------|
| `200` | OK | GET, PUT/PATCH exitoso |
| `201` | Created | POST que crea un recurso |
| `204` | No Content | DELETE exitoso (sin body) |
| `400` | Bad Request | Falta X-Tenant u otro input invalido |
| `401` | Unauthorized | Token faltante o invalido |
| `403` | Forbidden | Autenticado pero sin permiso |
| `404` | Not Found | Recurso o tenant no existe |
| `422` | Validation | Datos del formulario invalidos |
| `429` | Too Many Requests | Rate limit excedido |
| `500` | Server Error | Error inesperado |

---

## Endpoints — Panel Gym (requieren X-Tenant + Bearer)

### Auth
| Metodo | Endpoint | Auth | Descripcion |
|--------|----------|------|-------------|
| POST | `/v1/auth/login` | No (solo X-Tenant) | Login, devuelve token |
| GET | `/v1/auth/me` | Bearer | Usuario autenticado + perfil |
| POST | `/v1/auth/logout` | Bearer | Revoca token actual |

### Core
| Recurso | Endpoint | Operaciones |
|---------|----------|-------------|
| Sedes | `/v1/sedes` | index, store, show, update, destroy |
| Empleados | `/v1/empleados` | index, store, show, update, destroy |

### Planes y Pricing
| Recurso | Endpoint | Operaciones |
|---------|----------|-------------|
| Planes | `/v1/planes` | index, store, show, update, destroy |
| Precios de Plan | `/v1/plan-precios` | index, store, show, update, destroy |
| Beneficios de Plan | `/v1/plan-beneficios` | index, store, show, update, destroy |
| Promociones | `/v1/promociones` | index, store, show, update, destroy |

### Socios y Membresias
| Recurso | Endpoint | Operaciones |
|---------|----------|-------------|
| Socios | `/v1/socios` | index, store, show, update, destroy |
| Membresias | `/v1/membresias` | index, store, show, update, destroy |

### Pagos y Caja
| Recurso | Endpoint | Operaciones |
|---------|----------|-------------|
| Pagos | `/v1/pagos` | index, store, show, update, destroy |
| Deudas | `/v1/deudas` | index, store, show, update, destroy |
| Cajas | `/v1/cajas` | index, store, show, update, destroy |

### Clases y Turnos
| Recurso | Endpoint | Operaciones |
|---------|----------|-------------|
| Clases | `/v1/clases` | index, store, show, update, destroy |
| Turnos de Clase | `/v1/turno-clases` | index, store, show, update, destroy |
| Reservas | `/v1/reservas` | index, store, show, update, destroy |
| Asistencias | `/v1/asistencias` | index, store, show, update, destroy |

### Equipamiento
| Recurso | Endpoint | Operaciones |
|---------|----------|-------------|
| Equipos | `/v1/equipos` | index, store, show, update, destroy |
| Mantenimientos | `/v1/mantenimientos` | index, store, show, update, destroy |

### Nutricion
| Recurso | Endpoint | Operaciones |
|---------|----------|-------------|
| Planes Nutricionales | `/v1/plan-nutricionales` | index, store, show, update, destroy |
| Mediciones | `/v1/medicion-socios` | index, store, show, update, destroy |

### Notificaciones
| Recurso | Endpoint | Operaciones |
|---------|----------|-------------|
| Notificaciones | `/v1/notificaciones` | index, store, show, update, destroy |

---

## Endpoints — Panel Admin (requieren Bearer con guard admin, SIN X-Tenant)

### Auth Admin
| Metodo | Endpoint | Auth | Descripcion |
|--------|----------|------|-------------|
| POST | `/v1/admin/auth/login` | No | Login admin |
| GET | `/v1/admin/auth/me` | Bearer (admin) | Admin autenticado |
| POST | `/v1/admin/auth/logout` | Bearer (admin) | Revoca token |

### Gestion de Plataforma
| Recurso | Endpoint | Operaciones |
|---------|----------|-------------|
| Tenants (Gimnasios) | `/v1/admin/tenants` | index, store, show, update, destroy |
| Planes Plataforma | `/v1/admin/planes-plataforma` | index, store, show, update, destroy |
| Facturas | `/v1/admin/facturas` | index, store, show, update, destroy |
| Pagos Plataforma | `/v1/admin/pagos-plataforma` | index, store, show, update, destroy |

---

## Valores Enum (campos con opciones fijas)

Estos campos solo aceptan los valores listados:

| Campo | Modelo | Valores |
|-------|--------|---------|
| `tipo` | Plan | `fijo`, `pase_dia`, `clases_sueltas` |
| `estado` | Membresia | `activa`, `vencida`, `congelada`, `cancelada`, `pendiente_pago` |
| `estado` | Pago | `pendiente`, `pagado`, `anulado`, `reembolsado` |
| `estado` | Caja | `abierta`, `cerrada` |
| `estado` | TurnoClase | `programado`, `en_curso`, `finalizado`, `cancelado` |
| `estado` | Equipo | `operativo`, `en_mantenimiento`, `fuera_de_servicio`, `dado_de_baja` |
| `tipo` | Mantenimiento | `preventivo`, `correctivo`, `revision` |
| `estado` | Mantenimiento | `programado`, `en_progreso`, `completado`, `cancelado` |
| `tipo_descuento` | Promocion | `porcentaje`, `monto_fijo`, `meses_gratis` |
| `aplica_a` | Promocion | `todos`, `plan_especifico`, `primera_membresia` |
| `tipo` | Asistencia | `clase`, `acceso_libre` |
| `estado` | Reserva | `reservada`, `confirmada`, `asistio`, `ausente`, `cancelada` |
| `sexo` | Socio | `masculino`, `femenino`, `otro` |
| `tipo` | MetodoPago | `efectivo`, `digital`, `tarjeta`, `otro` |
| `objetivo` | PlanNutricional | `perdida_peso`, `ganancia_muscular`, `mantenimiento`, `rendimiento`, `otro` |
| `tipo_comida` | ComidaDiaria | `desayuno`, `almuerzo`, `merienda`, `cena`, `colacion` |
| `tipo` | Notificacion | `membresia`, `pago`, `clase`, `mantenimiento`, `promocion`, `general` |
| `plan_suscripcion` | Tenant | `trial`, `basico`, `pro`, `enterprise` |
| `estado` | FacturaTenant | `pendiente`, `pagada`, `vencida`, `anulada` |
| `estado` | PagoPlataforma | `pendiente`, `aprobado`, `rechazado`, `reembolsado` |
| `estado` | Deuda | `pendiente`, `pagada`, `anulada` |

---

## Ejemplo completo — CRUD de Socios

### Listar socios (paginado)
```
GET /v1/socios?per_page=10&page=1
Headers:
  Authorization: Bearer {token}
  X-Tenant: demo
  Accept: application/json
```

### Crear socio
```
POST /v1/socios
Headers:
  Authorization: Bearer {token}
  X-Tenant: demo
  Content-Type: application/json
  Accept: application/json

Body:
{
  "sede_id": 1,
  "nombre": "Juan",
  "apellido": "Perez",
  "dni": "40123456",
  "email": "juan@email.com",
  "numero_socio": "SOC-001",
  "telefono": "+54 11 5555-1234",
  "fecha_nacimiento": "1990-05-15",
  "sexo": "masculino",
  "activo": true
}

Response 201:
{
  "success": true,
  "message": "Creado exitosamente.",
  "data": { "id": 1, "nombre": "Juan", ... }
}
```

### Ver socio
```
GET /v1/socios/1
```

### Actualizar socio (parcial)
```
PUT /v1/socios/1
Body: { "telefono": "+54 11 9999-8888" }
```

Solo enviar los campos que cambian. No es necesario enviar todo el objeto.

### Eliminar socio (soft delete)
```
DELETE /v1/socios/1
Response: 204 No Content
```

---

## Credenciales de desarrollo

| Rol | Email | Password | Header |
|-----|-------|----------|--------|
| Super Admin (plataforma) | `admin@gympro.com` | `password` | Sin X-Tenant |
| Admin Gym (tenant demo) | `admin@gymdemo.com` | `password` | `X-Tenant: demo` |

---

## Configuracion del HTTP client (Axios ejemplo)

```javascript
// api.js — Panel Gym
const api = axios.create({
  baseURL: 'http://api-gympro.test/api/v1',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
});

// Interceptor para agregar token y tenant
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('token');
  const tenant = localStorage.getItem('tenant_slug');

  if (token) config.headers.Authorization = `Bearer ${token}`;
  if (tenant) config.headers['X-Tenant'] = tenant;

  return config;
});

// Interceptor para manejar errores globales
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('token');
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);
```

```javascript
// adminApi.js — Panel Admin (sin X-Tenant)
const adminApi = axios.create({
  baseURL: 'http://api-gympro.test/api/v1/admin',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
});

adminApi.interceptors.request.use((config) => {
  const token = localStorage.getItem('admin_token');
  if (token) config.headers.Authorization = `Bearer ${token}`;
  return config;
});
```

---

## Notas importantes para el frontend

1. **Siempre enviar `Accept: application/json`** — sin esto, errores de Laravel devuelven HTML en vez de JSON
2. **X-Tenant va en login tambien** — el backend necesita el tenant para buscar el usuario en el schema correcto
3. **Updates son parciales** — en PUT/PATCH solo enviar los campos que cambiaron
4. **Tokens no expiran solos** — considerar implementar auto-logout por inactividad en el frontend
5. **Moneda default es ARS** — si no se envia moneda, el backend asume pesos argentinos
6. **Fechas ISO 8601** — el backend devuelve timestamps en formato `2026-03-24T20:00:00.000000Z` y dates en `2026-03-24`
7. **Documentacion viva** — `/docs/api` tiene Swagger interactivo con "Try It" para probar endpoints
