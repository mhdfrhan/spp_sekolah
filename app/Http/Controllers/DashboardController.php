<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Rombel;
use App\Spp;
use App\Transaction;

class DashboardController extends Controller
{
    public function getIndex(){
    	$data['page_title'] = 'Dashboard';
    	$data['incoming'] = Transaction::sum('amount');
    	$data['user'] = User::count();
    	$data['rombel'] = Rombel::count();
    	$data['spp'] = Spp::count();

    	return view('dashboard.index', $data);
    }
}
