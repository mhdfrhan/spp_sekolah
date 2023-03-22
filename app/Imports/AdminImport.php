<?php

namespace App\Imports;

use App\Admin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdminImport implements ToModel, WithHeadingRow
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
		$existingUser = Admin::where('username', $row['username'])
			->orWhere('email', $row['email'])
			->first();

		// If a user with the same username or email exists, return null
		if ($existingUser) {
			$this->skippedRows++;
			return null;
		}

		return new Admin([
			'name' => $row['nama'],
			'username' => $row['username'],
			'email' => $row['email'],
			'password' => $row['password'],
		]);
	}

	public function getSkippedRows()
	{
			return $this->skippedRows;
	}
}
