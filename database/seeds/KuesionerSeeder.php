<?php

use Illuminate\Database\Seeder;

class KuesionerSeeder extends Seeder
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
            'pertanyaan1' => ' Setujukah Anda bahwa Aplikasi Digital Mading Polibatam mudahahkan dalam penyampaian dan penerimaan informasi ? ',
            'pertanyaan2' => ' Setujukah Anda bahwa Aplikasi Digital Mading Polibatam cepat dalam penyampaian informasi ? ',
            'pertanyaan3' => ' Setujukah Anda bahwa Aplikasi Digital Mading Polibatam mudahankan dalam mobilitas akses Informasi ? ',
            'pertanyaan4' => ' Setujukah Anda bahwa Aplikasi Digital Mading Polibatam memberikan data yang valid ? ',
            ]];
      
        DB::table('pertanyaans')->insert($data);
    }
}

