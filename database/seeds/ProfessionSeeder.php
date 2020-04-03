<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
//        DB::insert('INSERT INTO professions (title) VALUES(:title)', [
//            'title' => 'Desarrollador back-end']);

//        DB::table('professions')->insert([
//            'title' => 'Desarrollador back-end',         
//        ]);

        \App\Profession::create([
            'title' => 'Desarrollador back-end',
        ]);

        \App\Profession::create([
            'title' => 'Desarrollador front-end',
        ]);

        \App\Profession::create([
            'title' => 'Diseñador web',
        ]);
        
    }
}
