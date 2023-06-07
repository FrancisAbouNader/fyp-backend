<?php

namespace Database\Seeders;

use Exception;
use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        try {
            $productsType = DB::table('seeders')->where('name', 'ProductTypeSeeder')->get();
            if ($productsType->isEmpty()) {
                $this->command->info("Companie Seeder Started");

                $json = file_get_contents('database/data/seeds/product_Types.json');
                $role = json_decode($json);
                $total = count($role);
                $counter = 0;

                foreach ($role as $value) {
                    $counter++;
                    ProductType::create([
                        "name" => $value->name,
                    ]);

                    $this->command->info(($counter * 100) / $total);
                }

                DB::insert('insert into seeders (name) values (?)', ["ProductTypeSeeder"]);
                $this->command->info("Companie Seeder Ended");
            } else {
                $this->command->info("Product t Seeder already exist.");
            }
        } catch (Exception $ex) {
            $this->command->info($ex->getMessage());
        }
    }
}
