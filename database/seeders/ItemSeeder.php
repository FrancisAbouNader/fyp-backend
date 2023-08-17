<?php

namespace Database\Seeders;

use App\Models\Item;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $items = DB::table('seeders')->where('name', 'ItemSeeder')->get();
            if ($items->isEmpty()) {
                $this->command->info("Brand Seeder Started");

                $json = file_get_contents('database/data/seeds/items.json');
                $role = json_decode($json);
                $total = count($role);
                $counter = 0;

                foreach ($role as $value) {
                    $counter++;
                    Item::create([
                        "name" => $value->name,
                        "imei" => $value->imei,
                        "product_id" => $value->product_id,
                        "ownerable_type" => Company::class,
                        "ownerable_id" => $value->company_id
                    ]);

                    $this->command->info(($counter * 100) / $total);
                }

                DB::insert('insert into seeders (name) values (?)', ["ItemtSeeder"]);
                $this->command->info("Item Seeder Ended");
            } else {
                $this->command->info("Item Seeder already exist.");
            }
        } catch (Exception $ex) {
            $this->command->info($ex->getMessage());
        }
    }
}
