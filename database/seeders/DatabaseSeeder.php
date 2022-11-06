<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        if (config('app.env') === 'production') {
            $this->call(
                [

                ]
            );
            $this->command->error('you cannot seed on environment production');
        } else {
            $this->call(
                [
                    EmployeeSeeder::class,
                    RoleAndPermissionSeeder::class,
                ]
            );
        }
    }
}
