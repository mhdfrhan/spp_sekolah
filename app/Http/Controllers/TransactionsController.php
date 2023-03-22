<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\TransactionDetail;
use App\User;
use Activity;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
	public function getIndex()
	{
		$data['page_title'] = "Transaksi";
		$data['students'] = User::all();

		return view('transactions.index', $data);
	}

	public function postAdd(Request $request)
	{
		$user = User::findOrFail($request->users_id);
		$tdetail = TransactionDetail::where('users_id', $user->id)->count();

		$data = new Transaction;
		$data->users_id = $user->id;
		$data->spp_id = $user->spp_id;
		$data->payment_method = "Cash";
		$data->amount = $request->total_spp;
		$data->no_transaksi = 'INV-' . rand(100000000, 999999999);

		$for_month = [];
		for ($i = $tdetail + 1; $i <= $request->for_month; $i++) {
			$for_month[] = $i;
		}

		$data->for_month = implode(',', $for_month);
		$data->description = "-";
		$data->status = "Success Payment";
		$data->approved_at = now();
		$data->admins_id = auth('admin')->user()->id;
		$data->save();

		foreach ($for_month as $row) {
			$detail = new TransactionDetail;
			$detail->users_id = $user->id;
			$detail->month = $row;
			$detail->transactions_id = $data->id;
			$detail->save();
		}

		Activity::add([
			'page' => 'Transaksi',
			'description' => 'Menambahkan Transaksi Baru: ' . $user->name
		]);

		return redirect()->back()->with([
			'message_type' => 'success',
			'message'   => 'Transaksi Berhasil!'
		]);
	}

	public function print($id)
	{
		$transaksi = DB::table('transactions')->select('transactions.*', 'transactions.id as id_transaksi', 'users.*', 'users.id as id_user', 'spp.*', 'spp.id as id_spp')
			->join('users', 'users.id', '=', 'transactions.users_id')
			->join('spp', 'spp.id', '=', 'transactions.spp_id')
			->where('transactions.id', $id)
			->first();

		$implode = explode(',', $transaksi->for_month);

		$namemonth = [];
		foreach ($implode as $key => $i) {
			$namemonth[] = spp_month($i);
		}

		$transaksi->for_month = implode(', ', $namemonth);

		if (empty($transaksi)) {
			return redirect()->back();
		}

		// dd($transaksi);

		return view('invoice.print', [
			't' => $transaksi,
			'page_title' => "Print Invoice"
		]);
	}

	public function printAll()
	{
		$transaksi = DB::table('transactions')->select('transactions.*', 'transactions.id as id_transaksi', 'users.*', 'users.id as id_user', 'spp.*', 'spp.id as id_spp')
			->join('users', 'users.id', '=', 'transactions.users_id')
			->join('spp', 'spp.id', '=', 'transactions.spp_id')->get();

		foreach ($transaksi as $t) {
			$implode = explode(',', $t->for_month);

			$namemonth = [];
			foreach ($implode as $key => $i) {
				$namemonth[] = spp_month($i);
			}

			$t->for_month = implode(', ', $namemonth);
		}

		if (empty($transaksi)) {
			return redirect()->back();
		}

		return view('invoice.printAll', [
			'transaksi' => $transaksi,
			'page_title' => "Print Semua Invoice"
		]);
	}
}
