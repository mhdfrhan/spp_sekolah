<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = New Setting;
        $data->slug = "title";
        $data->title = "Judul Website";
        $data->content = "SD Hidayatullah Batam";
        $data->save();

        $data = New Setting;
        $data->slug = "month_begin";
        $data->title = "Bulan Dimulai -> 1/7";
        $data->content = "1";
        $data->save();

				$data = New Setting;
				$data->slug = "alamat";
				$data->title = "Alamat Sekolah";
				$data->content = "Jl. Letjen Soeprapto, RT.02/RW.11, Kibing, Kec. Batu Aji, Kota Batam, Kepulauan Riau 29424";
				$data->save();

				$data = New Setting;
				$data->slug = "telepon";
				$data->title = "Nomor Telepon";
				$data->content = "(0778) 364815";
				$data->save();
    }
}
