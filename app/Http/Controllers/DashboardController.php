<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;

class DashboardController extends Controller
{
    public function index()
    {
        $transaksi_count = Transaksi::count();

        $jumlah_item_terjual = TransaksiDetail::sum('jumlah');

        $omzet = TransaksiDetail::sum('subtotal');

        return view('dashboard', compact('transaksi_count'));
    }
}
