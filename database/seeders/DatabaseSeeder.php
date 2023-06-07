<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ItemSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\PortalSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CompanieSeeder;
use Database\Seeders\ProductTypeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PortalSeeder::class,
            RolesSeeder::class,
            CompanieSeeder::class,
            BrandSeeder::class,
            ProductTypeSeeder::class,
            ProductSeeder::class,
            ItemSeeder::class,
            UsersSeeder::class
        ]);
    }
}
