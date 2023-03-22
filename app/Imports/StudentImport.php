<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
	private $skippedRows = 0;

	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function model(array $row)
	{
		// Check if the username or email already exists in the database
		$existingUser = User::where('username', $row['username'])
			->orWhere('email', $row['email'])
			->first();

		// If a user with the same username or email exists, return null
		if ($existingUser) {
			$this->skippedRows++;
			return null;
		}

		return new User([
			'name' => $row['nama'],
			'username' => $row['username'],
			'email' => $row['email'],
			'gender' => $row['gender'],
			'address' => $row['alamat'],
			'telp' => $row['telp'],
			'password' => $row['password'],
			'rombels_id' => $row['rombels_id'],
			'spp_id' => $row['spp_id']
		]);
	}

	public function getSkippedRows()
	{
			return $this->skippedRows;
	}
}
