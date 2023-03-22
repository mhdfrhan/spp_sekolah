<?php

namespace App\Exports;

use App\Admin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminExport implements FromCollection, WithTitle, WithHeadings
{
	/**
	 * @return string
	 */
	public function title(): string
	{
		return 'Data Siswa';
	}

	/**
	 * @return array
	 */
	public function headings(): array
	{
		return [
			'Nama',
			'Username',
			'Email',
			'Password'
		];
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function collection()
	{
		return Admin::select('name', 'username', 'email', 'password')
			->get()
			->map(function ($admin) {
				return [
					'name' => $admin->name,
					'username' => $admin->username,
					'email' => $admin->email,
					'password' => $admin->password,
				];
			});
	}
}
