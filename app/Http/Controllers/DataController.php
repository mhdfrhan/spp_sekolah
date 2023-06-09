<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\TransactionDetail;
use DataTables;

class DataController extends Controller
{
	public function getStudents(){
		// Mengambil data dari tabel users, rombels, dan spp
		$data = DB::table('users')
			->join('rombels','users.rombels_id','=','rombels.id')
			->join('spp','users.spp_id','=','spp.id')
			->select('users.id','users.username','users.name','rombels.name as rombel','users.gender','spp.amount','spp.info')
			->get();
	
		// Mengembalikan data dalam format datatables
		return datatables()->of($data)->make(true);
	}
	
	public function getInfoStudent($username){
		// Mengambil data user dengan username tertentu
		$user = User::where('username', $username)->first();
		
		// Menghitung jumlah detail transaksi dari user tersebut
		$detail = TransactionDetail::where('users_id', $user->id)
			->count();
	
		// Membuat list bulan
		$list_month = [];
		$i = $detail+1;
		for ($i > $detail; $i <= 12; $i++) { 
			$arr['value'] = $i;
			$arr['text'] = spp_month($i);
			$list_month[] = $arr;
		}
	
		// Menyiapkan data yang akan dikembalikan dalam bentuk array
		$data['users_id'] = $user->id;
		$data['amount_spp'] = $user->spp->amount;
		if ($detail) {
			$data['last_month'] = spp_month($detail);
			$data['last_month_int'] = $detail;
		}else{
			$data['last_month'] = "Belum Ada";
			$data['last_month_int'] = 0;
		}
		$data['list_month'] = $list_month;
	
		// Mengembalikan data dalam bentuk json
		return response()->json($data);
	}
	
}
