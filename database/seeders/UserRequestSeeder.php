<?php

namespace Database\Seeders;

use App\Models\RequestStatus;
use Exception;
use App\Models\Role;
use App\Models\UserRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $name = DB::table('seeders')->where('name', 'UserRequestSeeder')->get();
            if ($name->isEmpty()) {
                $this->command->info("UserRequestSeeder Started");

                $json = file_get_contents('database/data/seeds/userRequest.json');
                $role = json_decode($json);
                $total = count($role);
                $counter = 0;

                foreach ($role as $value) {
                    $counter++;
                    $user_request = UserRequest::create([
                        "user_id" => $value->user_id,
                        "request_status_id" => 1
                    ]);

                    $user_request->products()->attach($value->product_ids, ["quantity" => 1]);

                    $this->command->info(($counter * 100) / $total);
                }

                DB::insert('insert into seeders (name) values (?)', ["UserRequestSeeder"]);
                $this->command->info("UserRequestSeeder Ended");
            } else {
                $this->command->info("UserRequestSeeder already exist.");
            }
        } catch (Exception $ex) {
            $this->command->info($ex->getMessage());
        }
    }
}
