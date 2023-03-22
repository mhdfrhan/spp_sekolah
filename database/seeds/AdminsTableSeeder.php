<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = New Admin;
        $data->name = "Muhammad Farhan";
        $data->username = "farhan";
        $data->email = "farhan@gmail.com";
        $data->password = Hash::make('password');
        $data->save();
    }
}
