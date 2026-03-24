<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Safety trait for tenant-scoped models.
 *
 * Prevents accidental writes when no tenant schema is initialized.
 * Use this on every model that lives inside a tenant schema (Sede, Socio, etc.).
 */
trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::creating(function (Model $model): void {
            if (! tenancy()->initialized) {
                throw new \RuntimeException(
                    'Intentando crear ' . class_basename($model) . ' sin tenant inicializado.'
                );
            }
        });
    }
}
