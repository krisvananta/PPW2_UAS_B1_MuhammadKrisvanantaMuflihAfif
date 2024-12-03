<?php

namespace App\Http\Controllers;

use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::orderBy('tanggal_pembelian','DESC')->get();

        return view('transaksi.index');
    }

    public function create()
    {
        return view('transaksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pembelian' => 'required|date',
            'bayar' => 'required|numeric',
            'nama_produk1' => 'required|string',
            'harga_satuan1' => 'required|numeric',
            'jumlah1' => 'required|numeric',
            'nama_produk2' => 'required|string',
            'harga_satuan2' => 'required|numeric',
            'jumlah2' => 'required|numeric',
            'nama_produk3' => 'required|string',
            'harga_satuan3' => 'required|numeric',
            'jumlah3' => 'required|numeric',
        ]);

        // Gunakan transaction
        DB::beginTransaction();
        try {
            $transaksi = new Transaksi();
            $transaksi->tanggal_pembelian = $request->input('tanggal_pembelian');
            $transaksi->total_harga = 0;
            $transaksi->bayar = $request->input('bayar');
            $transaksi->kembalian = 0;
            $transaksi->save();

            $total_harga = 0;

            foreach ($request->input('nama_produk') as $index => $nama_produk) {
                $transaksidetail = new TransaksiDetail();
                $transaksidetail->id_transaksi = $transaksi->id;
                $transaksidetail->nama_produk = $nama_produk;
                $transaksidetail->harga_satuan = $request->input('harga_satuan')[$index];
                $transaksidetail->jumlah = $request->input('jumlah')[$index];
                $transaksidetail->subtotal = $transaksidetail->harga_satuan * $transaksidetail->jumlah;
                $transaksidetail->save();

                $total_harga += $transaksidetail->subtotal; // Tambahkan ke total harga
            }
            $transaksi->total_harga = $total_harga;
            $transaksi->kembalian = $transaksi->bayar - $total_harga;
            $transaksi->save();

            DB::commit();

            return redirect('transaksidetail/'.$transaksi->id)->with('pesan', 'Berhasil menambahkan data');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['Transaction' => 'Gagal menambahkan data'])->withInput();
        }
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi_details = TransaksiDetail::where('id_transaksi', $id)->get();
        return view('transaksi.edit', compact('transaksi', 'transaksi_details'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bayar' => 'required|numeric'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->bayar = $request->input('bayar');
        $transaksi->kembalian = $transaksi->bayar - $transaksi->total_harga;
        $transaksi->save();

        return redirect('/transaksi') -> with('pesan', 'Berhasil mengubah data');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect('/transaksi');
    }
}
