<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\TransactionDetail;
use App\User;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
	public function indexReports()
	{
		$month = date('n');
		$year = date('Y');

		// ambil data transaksi yang sudah diterima dan tidak kedaluwarsa pada bulan dan tahun tertentu
		$transactions = TransactionDetail::where('month', $month)
			->join('transactions', 'transactions.id', '=', 'transaction_detail.transactions_id')
			->whereNotNull('approved_at')
			->whereYear('transactions.created_at', $year)
			->get();

		// ambil data detail transaksi yang terkait dengan transaksi yang sudah diterima dan tidak kedaluwarsa
		$transactionDetails = TransactionDetail::whereIn('transactions_id', $transactions->pluck('id')->toArray())
			->get();

		// hitung total pembayaran per siswa
		$payments = [];
		foreach ($transactionDetails as $detail) {
			if (!isset($payments[$detail->users_id])) {
				$payments[$detail->users_id] = [
					'user' => $detail->user,
					'total' => 0,
					'tanggal' => ''
				];
			}
			$payments[$detail->users_id]['total'] = $detail->transaction->amount;
			$payments[$detail->users_id]['tanggal'] = date('Y-m-d H:i:s', strtotime($detail->transaction->approved_at));
		}

		return view('reports.index', [
			'page_title' => 'Laporan Pembayaran',
			'payments' => $payments,
		]);
	}

	public function indexArrears()
	{
		$month = date('n');
		$year = date('Y');

		// Ambil semua siswa
		$students = User::get();

		// Ambil data transaksi yang sudah diterima dan tidak kedaluwarsa pada bulan dan tahun tertentu
		$transactions = TransactionDetail::where('month', $month)
			->join('transactions', 'transactions.id', '=', 'transaction_detail.transactions_id')
			->whereNotNull('approved_at')
			->whereYear('transactions.created_at', $year)
			->get();

		// Buat array kosong untuk menyimpan daftar siswa yang menunggak
		$overdueStudents = [];

		// Looping setiap siswa dan cek apakah siswa tersebut menunggak atau tidak
		foreach ($students as $student) {
			$hasPaid = false;
			foreach ($transactions as $transaction) {
				if ($transaction->users_id == $student->id) {
					$hasPaid = true;
					break;
				}
			}

			if (!$hasPaid) {
				$overdueStudents[] = $student;
			}
		}

		return view('reports.arrears', [
			'page_title' => 'Tunggakan Siswa',
			'overdueStudents' => $overdueStudents
		]);
	}
}
