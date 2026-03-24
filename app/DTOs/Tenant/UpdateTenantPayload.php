<?php

declare(strict_types=1);

namespace App\DTOs\Tenant;

final readonly class UpdateTenantPayload
{
    public function __construct(
        public ?string $slug = null,
        public ?string $nombre = null,
        public ?string $emailAdmin = null,
        public ?string $telefono = null,
        public ?string $logo = null,
        public ?string $planSuscripcion = null,
        public ?bool   $suscripcionActiva = null,
        public ?int    $maxSedes = null,
        public ?int    $maxEmpleados = null,
        public ?int    $maxSocios = null,
        public ?array  $datosFiscales = null,
        public ?string $trialEndsAt = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'slug'               => $this->slug,
            'nombre'             => $this->nombre,
            'email_admin'        => $this->emailAdmin,
            'telefono'           => $this->telefono,
            'logo'               => $this->logo,
            'plan_suscripcion'   => $this->planSuscripcion,
            'suscripcion_activa' => $this->suscripcionActiva,
            'max_sedes'          => $this->maxSedes,
            'max_empleados'      => $this->maxEmpleados,
            'max_socios'         => $this->maxSocios,
            'datos_fiscales'     => $this->datosFiscales,
            'trial_ends_at'      => $this->trialEndsAt,
        ], fn ($value) => $value !== null);
    }
}
