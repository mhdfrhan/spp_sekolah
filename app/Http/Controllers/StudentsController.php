<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Rombel;
use App\Spp;
use App\Transaction;
use App\TransactionDetail;
use Activity;
use Illuminate\Support\Facades\Hash;
use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Imports\StudentImport;

class StudentsController extends Controller
{
	public function getIndex()
	{
		$data['page_title'] = 'Data Siswa';
		$data['data'] = User::all();

		return view('students.index', $data);
	}

	public function getAdd()
	{
		$data['page_title'] = 'Tambah Data Siswa';
		$data['rombels'] = Rombel::all();
		$data['spp'] = Spp::all();

		return view('students.form', $data);
	}

	public function postAdd(Request $request)
	{
		$validate = $request->validate([
			'username' => 'required|unique:users,username|min:8',
			'name' => 'required',
			'email' => 'nullable',
			'password' => 'required|min:6',
			'gender' => 'required',
			'rombels_id' => 'required',
			'address' => 'nullable',
			'telp' => 'nullable',
			'spp_id' => 'required',
		]);

		$validate['password'] = Hash::make($validate['password']);

		User::create($validate);

		Activity::add([
			'page' => 'Tambah Data Siswa',
			'description' => 'Menambahkan Siswa Baru: ' . $request->name
		]);

		return redirect('admin/students')->with([
			'message_type' => 'success',
			'message' => 'Data Berhasil Disimpan'
		]);
	}

	public function getEdit($id)
	{
		$data['page_title'] = 'Edit Data Siswa';
		$data['data'] = User::find($id);
		$data['rombels'] = Rombel::all();
		$data['spp'] = Spp::all();

		return view('students.form', $data);
	}

	public function postEdit($id, Request $request)
	{
		$request->validate([
			'username' => 'required|min:8',
			'name' => 'required',
			'email' => 'nullable',
			'gender' => 'required',
			'rombels_id' => 'required',
			'address' => 'nullable',
			'telp' => 'nullable',
			'spp_id' => 'required',
		]);

		User::findOrFail($id)->update($request->all());

		Activity::add([
			'page' => 'Edit Data Siswa',
			'description' => 'Mengedit Data Siswa: ' . $request->name
		]);

		return redirect('admin/students')->with([
			'message_type' => 'success',
			'message' => 'Data Berhasil Diedit'
		]);
	}

	public function getDelete($id)
	{
		$data = User::findOrFail($id);
		$name = $data->name;

		$data->delete();

		Activity::add([
			'page' => 'Data Siswa',
			'description' => 'Menghapus Data Siswa: ' . $name
		]);

		return redirect()->back()->with([
			'message_type' => 'success',
			'message'   => 'Data Berhasil Dihapus!'
		]);
	}

	public function getDetail($id)
	{
		$data['page_title'] = 'Detail Siswa';
		$data['data'] = User::findOrFail($id);
		$data['history'] = Transaction::where('status', 'Success Payment')->where('users_id', $id)->get();
		$data['total'] = Transaction::where('status', 'Success Payment')->where('users_id', $id)->sum('amount');
		$data['last_month'] =  TransactionDetail::where('users_id', $id)->count();

		foreach ($data['history'] as $d) {
			$implode = explode(',', $d->for_month);

			$namemonth = [];
			foreach ($implode as $key => $i) {
				$namemonth[] = spp_month($i);
			}

			$d->for_month = implode(', ', $namemonth);
		}

		return view('students.detail', $data);
	}


	public function studentExport()
	{
		return Excel::download(new StudentExport, 'datasiswa.xlsx');
	}

	public function studentImport(Request $request)
	{
		$file = $request->file('file');
		$namaFile = $file->getClientOriginalName();
		$file->move('DataSiswa', $namaFile);

		$import = new StudentImport();
		$importedRows = Excel::import($import, public_path('/DataSiswa/' . $namaFile));
		$skippedRows = $import->getSkippedRows();

		// If there were skipped rows, redirect back with an error message
		if ($skippedRows > 0) {
			return redirect()->back()->with([
				'message_type' => 'danger',
				'message' => "Gagal import data karna ada username/email/nis yang sama"
			]);
		} else {
			return redirect()->back()->with([
				'message_type' => 'success',
				'message'   => 'Data Berhasil Di import!'
			]);
		}
	}
}
