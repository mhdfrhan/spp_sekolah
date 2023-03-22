<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Carbon\Carbon;
use App\TransactionDetail;

class InvoiceController extends Controller
{
	public function getIndex()
	{
		// Data untuk ditampilkan pada halaman index invoice
		$data['page_title'] = "Invoice";
		$data['data'] = Transaction::orderBy('created_at', 'desc')
			->get();

		// Tampilkan view invoice.index dengan data yang telah diambil
		return view('invoice.index', $data);
	}

	public function getWaiting()
	{
		// Data untuk ditampilkan pada halaman menunggu pembayaran
		$data['page_title'] = "Menunggu Pembayaran";
		$data['data'] = Transaction::where('status', 'Waiting Payment')
			->orderBy('updated_at', 'desc')
			->get();

		// Tampilkan view invoice.waiting dengan data yang telah diambil
		return view('invoice.waiting', $data);
	}

	public function getSuccess()
	{
		// Data untuk ditampilkan pada halaman pembayaran sukses
		$data['page_title'] = "Pembayaran Sukses";
		$data['data'] = Transaction::whereNotNull('approved_at')
			->orderBy('updated_at', 'desc')
			->get();

		// Ubah format bulan pada setiap data
		foreach ($data['data'] as $d) {
			$implode = explode(',', $d->for_month);

			$namemonth = [];
			foreach ($implode as $key => $i) {
				$namemonth[] = spp_month($i);
			}

			$d->for_month = implode(', ', $namemonth);
		}

		// Tampilkan view invoice.success dengan data yang telah diambil
		return view('invoice.success', $data);
	}

	public function getFailed()
	{
		// Set judul halaman
		$data['page_title'] = "Pembayaran Gagal";

		// Ambil data transaksi yang statusnya Failed
		$data['data'] = Transaction::where('status', 'Failed')
			->orderBy('updated_at', 'desc')
			->get();

		// Ubah format bulan pada data transaksi
		foreach ($data['data'] as $d) {
			$implode = explode(',', $d->for_month);

			$namemonth = [];
			foreach ($implode as $key => $i) {
				$namemonth[] = spp_month($i);
			}

			$d->for_month = implode(', ', $namemonth);
		}

		// Tampilkan halaman invoice.failed dengan data yang telah diambil
		return view('invoice.failed', $data);
	}

	// Fungsi untuk menyetujui pembayaran
	public function getApprove($id)
	{
		// Ambil data transaksi berdasarkan id
		$data = Transaction::findOrFail($id);

		// Update status transaksi menjadi Success Payment dan approved_at menjadi waktu saat ini
		$data->status = "Success Payment";
		$data->approved_at = now();
		$data->save();

		// Ambil bulan-bulan yang terdapat pada data transaksi
		$months = explode(',', $data->for_month);

		// Tambahkan detail transaksi pada tabel transaction_detail
		foreach ($months as $row) {
			$detail = new TransactionDetail;
			$detail->users_id = $data->users_id;
			$detail->month = $row;
			$detail->transactions_id = $data->id;
			$detail->save();
		}

		// Redirect ke halaman sebelumnya dengan pesan sukses
		return redirect()->back()->with([
			'message_type' => 'success',
			'message' => 'Pembayaran Disetujui!'
		]);
	}

	// Fungsi untuk membatalkan pembayaran
	public function reject($id)
	{
		// Ambil data transaksi berdasarkan id
		$data = Transaction::findOrFail($id);

		// Hapus data transaksi
		$data->delete();

		// Redirect ke halaman sebelumnya dengan pesan sukses
		return redirect()->back()->with([
			'message_type' => 'success',
			'message' => 'Pembayaran Dibatalkan!'
		]);
	}
}
