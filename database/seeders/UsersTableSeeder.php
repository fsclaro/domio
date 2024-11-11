<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Testing\Fakes\Fake;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            "name" => "Administrador Geral",
            "email" => "admin@domio.test",
            "email_verified_at" => now(),
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "type" => 0,
            'created_at' => now(),
            'updated_at'=> now(),
        ]);

        DB::table("users")->insert([
            "name" => fake()->name(),
            "email" => "gestor1@domio.test",
            "email_verified_at" => now(),
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "type" => 1,
            'created_at' => now(),
            'updated_at'=> now(),
        ]);

        DB::table("users")->insert([
            "name" => fake()->name(),
            "email" => "gestor2@domio.test",
            "email_verified_at" => now(),
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "type" => 1,
            'created_at' => now(),
            'updated_at'=> now(),
        ]);

        DB::table("users")->insert([
            "name" => fake()->name(),
            "email" => "gestor3@domio.test",
            "email_verified_at" => now(),
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "type" => 1,
            'created_at' => now(),
            'updated_at'=> now(),
        ]);

        DB::table("users")->insert([
            "name" => fake()->name(),
            "email" => "morador1@domio.test",
            "email_verified_at" => now(),
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "type" => 2,
            'created_at' => now(),
            'updated_at'=> now(),
        ]);

        DB::table("users")->insert([
            "name" => fake()->name(),
            "email" => "morador2@domio.test",
            "email_verified_at" => now(),
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "type" => 2,
            'created_at' => now(),
            'updated_at'=> now(),
        ]);

        DB::table("users")->insert([
            "name" => fake()->name(),
            "email" => "morador3@domio.test",
            "email_verified_at" => now(),
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "type" => 2,
            'created_at' => now(),
            'updated_at'=> now(),
        ]);

        DB::table("users")->insert([
            "name" => fake()->name(),
            "email" => "morador4@domio.test",
            "email_verified_at" => now(),
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "type" => 2,
            'created_at' => now(),
            'updated_at'=> now(),
        ]);

        DB::table("users")->insert([
            "name" => fake()->name(),
            "email" => "morador5@domio.test",
            "email_verified_at" => now(),
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "type" => 2,
            'created_at' => now(),
            'updated_at'=> now(),
        ]);
    }
}
