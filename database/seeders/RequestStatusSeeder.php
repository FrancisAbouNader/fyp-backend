<?php

namespace Database\Seeders;

use App\Models\RequestStatus;
use Exception;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $name = DB::table('seeders')->where('name', 'RequestStatusSeeder')->get();
            if ($name->isEmpty()) {
                $this->command->info("RequestStatusSeeder Started");

                $json = file_get_contents('database/data/seeds/requestStatus.json');
                $role = json_decode($json);
                $total = count($role);
                $counter = 0;

                foreach ($role as $value) {
                    $counter++;
                    RequestStatus::create([
                        "name" => $value->name
                    ]);

                    $this->command->info(($counter * 100) / $total);
                }

                DB::insert('insert into seeders (name) values (?)', ["RequestStatusSeeder"]);
                $this->command->info("RequestStatusSeeder Ended");
            } else {
                $this->command->info("RequestStatusSeeder already exist.");
            }
        } catch (Exception $ex) {
            $this->command->info($ex->getMessage());
        }
    }
}
