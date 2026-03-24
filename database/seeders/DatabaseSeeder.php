<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Note: WithoutModelEvents is intentionally NOT used here because
     * TenantSeeder depends on Eloquent model events to trigger the
     * stancl/tenancy pipeline (CreateDatabase, MigrateDatabase).
     */
    public function run(): void
    {
        $this->call([
            TenantSeeder::class,
        ]);
    }
}
