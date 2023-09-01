<?php

namespace Database\Seeders;

use Exception;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $products = DB::table('seeders')->where('name', 'SectionSeeder')->get();
            if ($products->isEmpty()) {
                $this->command->info("Section Seeder Started");

                $json = file_get_contents('database/data/seeds/sections.json');
                $role = json_decode($json);
                $total = count($role);
                $counter = 0;

                foreach ($role as $value) {
                    $counter++;
                    Section::create([
                        "name" => $value->name,
                        "product_id"=> $value->product_id,
                        "company_id"=> $value->company_id,
                        "order"=> $value->order               
                    ]);

                    $this->command->info(($counter * 100) / $total);
                }

                DB::insert('insert into seeders (name) values (?)', ["SectionSeeder"]);
                $this->command->info("Section Seeder Ended");
            } else {
                $this->command->info("Section Seeder already exist.");
            }
        } catch (Exception $ex) {
            $this->command->info($ex->getMessage());
        }
    }
}
