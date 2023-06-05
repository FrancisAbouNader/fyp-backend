<?php

namespace Database\Seeders;

use Exception;
use App\Models\Portal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $name = DB::table('seeders')->where('name', 'PortalSeeder')->get();
            if ($name->isEmpty()) {
                $this->command->info("Portal Seeder Started");

                $json = file_get_contents('database/data/seeds/portals.json');
                $portals = json_decode($json);
                $total = count($portals);
                $counter = 0;

                foreach ($portals as $portal) {
                    $counter++;
                    Portal::create([
                        "name" => $portal->name
                    ]);

                    $this->command->info(($counter * 100) / $total);
                }

                DB::insert('insert into seeders (name) values (?)', ["PortalSeeder"]);
                $this->command->info("Portal Seeder Ended");
            } else {
                $this->command->info("Portal Seeder already exist.");
            }
        } catch (Exception $ex) {
            $this->command->info($ex->getMessage());
        }
    }
}
