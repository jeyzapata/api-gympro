<?php

declare(strict_types=1);

namespace App\DTOs\Tenant;

final readonly class StoreTenantPayload
{
    public function __construct(
        public string  $slug,
        public string  $nombre,
        public string  $emailAdmin,
        public string  $schemaName,
        public ?string $telefono = null,
        public ?string $logo = null,
        public string  $planSuscripcion = 'basico',
        public bool    $suscripcionActiva = true,
        public int     $maxSedes = 1,
        public int     $maxEmpleados = 10,
        public int     $maxSocios = 200,
        public ?array  $datosFiscales = null,
        public ?string $trialEndsAt = null,
    ) {}

    public function toArray(): array
    {
        return [
            'slug'               => $this->slug,
            'nombre'             => $this->nombre,
            'email_admin'        => $this->emailAdmin,
            'schema_name'        => $this->schemaName,
            'telefono'           => $this->telefono,
            'logo'               => $this->logo,
            'plan_suscripcion'   => $this->planSuscripcion,
            'suscripcion_activa' => $this->suscripcionActiva,
            'max_sedes'          => $this->maxSedes,
            'max_empleados'      => $this->maxEmpleados,
            'max_socios'         => $this->maxSocios,
            'datos_fiscales'     => $this->datosFiscales,
            'trial_ends_at'      => $this->trialEndsAt,
        ];
    }
}
