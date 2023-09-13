<?php

namespace Database\Seeders;

use Exception;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $name = DB::select('select * from seeders where name=?', ["UpdateUsersSeeder"]);
            if (!isset($name[0]->name)) {
                $this->command->warn("Update Users Seeder Started");
                $json = file_get_contents('database/data/seeds/users.json');
                $data = json_decode($json);
                $total = count($data);
                $counter = 0;

                foreach ($data as $value) {
                    $counter++;
                    $user = User::where('email', $value->email)->update([
                        "company_id" => $value->company_id,
                    ]);


                    $this->command->info(($counter * 100) / $total);
                }
                DB::insert('insert into seeders (name) values (?)', ["UpdateUsersSeeder"]);
                $this->command->warn("Update Users Seeder Ended");
            } else $this->command->warn("Update Users Seeder already exist.");
        } catch (Exception $ex) {
            $this->command->error($ex->getMessage());
        }
    }
}
