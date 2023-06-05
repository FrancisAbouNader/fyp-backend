<?php

namespace Database\Seeders;

use Exception;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $name = DB::table('seeders')->where('name', 'RolesSeeder')->get();
            if ($name->isEmpty()) {
                $this->command->info("Roles Seeder Started");

                $json = file_get_contents('database/data/seeds/roles.json');
                $role = json_decode($json);
                $total = count($role);
                $counter = 0;

                foreach ($role as $value) {
                    $counter++;
                    Role::create([
                        "name" => $value->name,
                        "portal_id" => $value->portal_id,
                        "guard_name" => "api"
                    ]);

                    $this->command->info(($counter * 100) / $total);
                }

                DB::insert('insert into seeders (name) values (?)', ["RolesSeeder"]);
                $this->command->info("Roles Seeder Ended");
            } else {
                $this->command->info("Roles Seeder already exist.");
            }
        } catch (Exception $ex) {
            $this->command->info($ex->getMessage());
        }
    }
}
