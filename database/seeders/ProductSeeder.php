<?php

namespace Database\Seeders;

use App\Models\Product;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $products = DB::table('seeders')->where('name', 'ProductSeeder')->get();
            if ($products->isEmpty()) {
                $this->command->info("Brand Seeder Started");

                $json = file_get_contents('database/data/seeds/products.json');
                $role = json_decode($json);
                $total = count($role);
                $counter = 0;

                foreach ($role as $value) {
                    $counter++;
                    Product::create([
                        "name" => $value->name,
                        "model_number"=> $value->model_number,
                        "package_height"=> $value->package_height,
                        "package_width"=> $value->package_width,
                        "package_length"=> $value->package_length,
                        "package_weight"=> $value->package_weight,
                        "product_height"=> $value->product_height,
                        "product_width"=> $value->product_width,
                        "product_length"=> $value->product_length,
                        "product_weight"=> $value->product_weight,
                        "description"=> $value->description,
                        "brand_id"=> $value->brand_id,
                        "product_type_id"=> $value->product_type_id ,                 ]);

                    $this->command->info(($counter * 100) / $total);
                }

                DB::insert('insert into seeders (name) values (?)', ["ProductSeeder"]);
                $this->command->info("Product Seeder Ended");
            } else {
                $this->command->info("Product Seeder already exist.");
            }
        } catch (Exception $ex) {
            $this->command->info($ex->getMessage());
        }
    }
}
