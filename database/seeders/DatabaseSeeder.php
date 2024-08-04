<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => 'name'.$i,
                'email' => 'test'.$i.'@example.com',
                'password' => bcrypt('123456'),
            ]);
        }
        for ($i = 0; $i < 10; $i++) {
            if($i%2 ==0){
                Admin::create([
                    'name' => 'admin'.$i,
                    'email' => 'admin'.$i.'@.com',
                    'password' => bcrypt('123456'),
                    'role' => 'admin',
                ]);
            }else{
                Admin::create([
                    'name' => 'operator'.$i,
                    'email' => 'operator'.$i.'@.com',
                    'password' => bcrypt('123456'),
                    'role' => 'operator',
                ]); 
            }
           
        }
    }
}
