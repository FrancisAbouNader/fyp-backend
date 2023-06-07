<?php

namespace Database\Seeders;

use Exception;
use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      try {
            $brands = DB::table('seeders')->where('name', 'BrandSeeder')->get();
            if ($brands->isEmpty()) {
                $this->command->info("Brand Seeder Started");

                $json = file_get_contents('database/data/seeds/brands.json');
                $role = json_decode($json);
                $total = count($role);
                $counter = 0;

                foreach ($role as $value) {
                    $counter++;
                    Brand::create([
                        "name" => $value->name,
                    ]);

                    $this->command->info(($counter * 100) / $total);
                }

                DB::insert('insert into seeders (name) values (?)', ["BrandSeeder"]);
                $this->command->info("Brand Seeder Ended");
            } else {
                $this->command->info("Brand Seeder already exist.");
            }
        } catch (Exception $ex) {
            $this->command->info($ex->getMessage());
        }
    }
}
