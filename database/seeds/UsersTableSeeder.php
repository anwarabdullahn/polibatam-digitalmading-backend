<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $data = [
      [
      'name' => 'Ormawa User',
      'email' => 'user@ormawa.com',
      'password' => bcrypt('user123'),
      'role' => 'ormawa',
      'notelpon' => '087791194987',
      'remember_token' => str_random(10),
      ],
      [
      'name' => 'Super Admin',
      'email' => 'admin@admin.com',
      'password' => bcrypt('admin123'),
      'role' => 'admin',
      'notelpon' => '087791194987',
      'remember_token' => str_random(10),
    ]];

    DB::table('users')->insert($data);
    }

}
