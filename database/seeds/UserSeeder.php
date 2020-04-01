<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professions = DB::select('SELECT id FROM professions WHERE title = ?', ['Desarrollador back-end']);

        dd($professions[0]->id);

        DB::table('users')->insert([
            'name' => 'Jose Rodezno',
            'email' => 'joserodezno99@gmail.com',
            'password' => bcrypt('prueba'),
            'profession_id' => $professions[0]->id,
        ]);
    }
}
