<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 5; $i++) { 
            DB::table('posts')->insert([
                'title' => "title$i",
                'description' => "this is post number $i",
                'user_id' => "$i",
            ]);
            
        }
    }
}
