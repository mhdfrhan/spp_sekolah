<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithTitle, WithHeadings
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
			'Gender',
			'Alamat',
			'Telp',
			'Password',
			'Rombels_id',
			'Spp_id'
		];
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function collection()
	{
		return User::select('name', 'username', 'email', 'gender', 'address', 'telp', 'password', 'rombels_id', 'spp_id')
			->get()
			->map(function ($user) {
				return [
					'name' => $user->name,
					'username' => $user->username,
					'email' => $user->email,
					'gender' => $user->gender,
					'address' => $user->address,
					'telp' => $user->telp,
					'password' => $user->password,
					'rombels_id' => $user->rombels_id,
					'spp_id' => $user->spp_id
				];
			});
	}
}
