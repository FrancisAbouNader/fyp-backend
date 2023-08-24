<?php

namespace Database\Seeders;

use App\Models\Company;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        try {
            $companies = DB::table('seeders')->where('name', 'CompanieSeeder')->get();
            if ($companies->isEmpty()) {
                $this->command->info("Companie Seeder Started");

                $json = file_get_contents('database/data/seeds/companies.json');
                $role = json_decode($json);
                $total = count($role);
                $counter = 0;

                foreach ($role as $value) {
                    $counter++;
                    Company::create([
                        "name" => $value->name,
                        "location" => $value->location,
                        "user_id" => $value->user_id
                    ]);

                    $this->command->info(($counter * 100) / $total);
                }

                DB::insert('insert into seeders (name) values (?)', ["CompanieSeeder"]);
                $this->command->info("Companie Seeder Ended");
            } else {
                $this->command->info("Companie Seeder already exist.");
            }
        } catch (Exception $ex) {
            $this->command->info($ex->getMessage());
        }
    }
}
