<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Admin;
use Activity;
use Hash;
use App\Exports\AdminExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Imports\AdminImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminsController extends Controller
{
	public function getIndex()
	{
		$data['page_title'] = "Data Admin";
		$data['data'] = Admin::all();

		return view('admins.index', $data);
	}

	public function getAdd()
	{
		$data['page_title'] = 'Tambah Data Admin';

		return view('admins.form', $data);
	}

	// Fungsi untuk menambahkan data admin baru
	public function postAdd(Request $request)
	{
		// Validasi input dari form tambah data admin
		$request->validate([
			'name' => 'required',
			'username' => 'required',
			'password' => 'required',
		]);

		// Buat objek baru dari model Admin
		$data = new Admin;

		// Set nilai atribut dari objek sesuai dengan input dari form
		$data->name = $request->name;
		$data->username = $request->username;
		$data->email = $request->email;
		$data->password = Hash::make($request->password);
		$data->save();

		// Tambahkan aktivitas ke dalam log
		Activity::add([
			'page' => 'Tambah Data Admin',
			'description' => 'Menambahkan Admin Baru: ' . $request->name
		]);

		// Alihkan pengguna ke halaman data admin dengan pesan sukses
		return redirect('admin/data')->with([
			'message_type' => 'success',
			'message' => 'Data Berhasil Disimpan'
		]);
	}


	public function getEdit($id)
	{
		$data['page_title'] = 'Edit Data Admin';
		$data['data'] = Admin::find($id);

		return view('admins.form', $data);
	}

	// Fungsi untuk mengedit data admin yang telah ada
	public function postEdit($id, Request $request)
	{
		// Validasi input dari form edit data admin
		$request->validate([
			'name' => 'required',
			'username' => 'required',
		]);

		// Cari data admin berdasarkan id
		$data = Admin::find($id);

		// Set nilai atribut dari objek sesuai dengan input dari form
		$data->name = $request->name;
		$data->username = $request->username;
		$data->email = $request->email;

		// Periksa apakah password diubah
		if ($request->password != NULL) {
			$data->password = Hash::make($request->password);
		}

		// Simpan perubahan ke dalam database
		$data->save();

		// Perbarui data admin yang sesuai dengan input form
		Admin::findOrFail($id)->update($request->all());

		// Tambahkan aktivitas ke dalam log
		Activity::add([
			'page' => 'Edit Data Admin',
			'description' => 'Mengedit Admin: ' . $request->name
		]);

		// Alihkan pengguna ke halaman data admin dengan pesan sukses
		return redirect('admin/data')->with([
			'message_type' => 'success',
			'message' => 'Data Berhasil Diedit'
		]);
	}


	// Fungsi untuk menghapus data admin
	public function getDelete($id)
	{
		// Cari data admin berdasarkan id
		$data = Admin::findOrFail($id);
		$name = $data->name;

		// Hapus data admin dari database
		$data->delete();

		// Tambahkan aktivitas ke dalam log
		Activity::add([
			'page' => 'Data Admin',
			'description' => 'Menghapus Admin: ' . $name
		]);

		// Alihkan pengguna ke halaman sebelumnya dengan pesan sukses
		return redirect()->back()->with([
			'message_type' => 'success',
			'message'   => 'Data Berhasil Dihapus!'
		]);
	}


	public function showProfile()
	{
		$data['page_title'] = "Profile";

		return view('admins.profile', $data);
	}

	// Fungsi untuk mengubah profil pengguna admin
	public function changeProfile(Request $request)
	{
		// Ambil data pengguna yang sedang login
		$user = Admin::where('id', Auth::user()->id)->first();

		// Validasi data yang diterima dari form
		$validated = $request->validate([
			'image' => 'image|file|max:1024',
			'name' => 'required|max:100',
			'username' => 'required|alpha_dash|max:100|unique:admins,username,' . $user->id,
			'email' => 'required|email:dns|unique:users,email,' . $user->id,
		]);

		if ($request->hasFile('image')) {
			// Hapus gambar profil yang lama
			if ($user->image) {
				$oldPath = public_path('/assets/img/profile/' . $user->image);
				if (File::exists($oldPath)) {
					File::delete($oldPath);
				}
			}
			// Simpan gambar baru dengan nama acak
			$validated['image'] =  Str::random(10) . '.' . $request->file('image')->getClientOriginalExtension();
			$path = public_path('/assets/img/profile/');
			$request->file('image')->move($path, $validated['image']);
		}

		// Update data pengguna dengan data yang telah divalidasi
		Admin::where('id', $user->id)->update($validated);

		// Alihkan pengguna ke halaman sebelumnya dengan pesan sukses
		return redirect()->back()->with([
			'message_type' => 'success',
			'message' => 'Berhasil update profile!'
		]);
	}


	public function deleteImage()
	{
		// Ambil data admin yang sedang login
		$user = Admin::where('id', Auth::user()->id)->first();

		// Jika admin belum memiliki foto profil
		if ($user->image == null) {
			return redirect()->back()->with([
				'message_type' => 'danger',
				'message' => 'Anda belum mempunyai foto!'
			]);
		}

		// Hapus foto profil yang lama
		$oldPath = public_path('/assets/img/profile/' . $user->image);
		if (File::exists($oldPath)) {
			File::delete($oldPath);
		}

		// Update data admin dengan menghapus data foto profil
		DB::table('admins')->where('id', $user->id)->update([
			'image' => null
		]);

		// Redirect ke halaman sebelumnya dengan pesan sukses
		return redirect()->back()->with([
			'message_type' => 'success',
			'message' => 'Berhasil menghapus foto!'
		]);
	}


	public function getChangePassword()
	{
		$data['page_title'] = "Change Password";

		return view('admins.password', $data);
	}

	public function postChangePassword(Request $request)
	{
		// Validasi inputan
		$request->validate([
			'current_password' => ['required', new MatchOldPassword],
			'new_password' => ['required'],
			'new_confirm_password' => ['same:new_password'],
		]);

		// Update password dari user yang sedang login
		Admin::find(auth('admin')->user()->id)->update(['password' => Hash::make($request->new_password)]);

		// Redirect kembali dengan pesan sukses
		return redirect()->back()->with([
			'message_type' => 'success',
			'message' => 'Password Berhasil Diupdate!'
		]);
	}

	public function adminExport()
	{
		// Download file Excel dengan data admin menggunakan class AdminExport
		return Excel::download(new AdminExport, 'dataadmin.xlsx');
	}

	public function adminImport(Request $request)
	{
		// Simpan file Excel yang diupload ke dalam folder DataSiswa
		$file = $request->file('file');
		$namaFile = $file->getClientOriginalName();
		$file->move('DataSiswa', $namaFile);

		// Import data admin dari file Excel menggunakan class AdminImport
		$import = new AdminImport();
		$importedRows = Excel::import($import, public_path('/DataAdmin/' . $namaFile));
		$skippedRows = $import->getSkippedRows();

		// Jika terdapat baris yang dilewati saat import, redirect kembali dengan pesan error
		if ($skippedRows > 0) {
			return redirect()->back()->with([
				'message_type' => 'danger',
				'message' => "Gagal import data karna ada username/email/nis yang sama"
			]);
		} else {
			// Jika tidak ada baris yang dilewati, redirect kembali dengan pesan sukses
			return redirect()->back()->with([
				'message_type' => 'success',
				'message'   => 'Data Berhasil Di import!'
			]);
		}
	}
}
