<?php

use Illuminate\Database\Seeder;

class AnnouncementCategoriesTableSeeder extends Seeder
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
      'name' => 'Umum',
      'image' => 'bg.jpg'
      ]];

    DB::table('announcement_categories')->insert($data);
    }
}
