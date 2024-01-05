<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\transaksi;
use Illuminate\Http\Request;
use App\Models\rejected_transaction;

class approvedController extends Controller
{
    public function getApp()
    {
        $dataTransaksi = transaksi::all();
        $dataKategori = kategori::all();
        return view('bendahara.approved', compact('dataTransaksi','dataKategori'));
    }

    public function approve(Request $request, $id)
    {
        $post = transaksi::findOrFail($id);

        $post->is_approved = 1;
        $post->save();

        return redirect()->back();
    }

    public function reject(Request $request, $id)
{
    $transaction = transaksi::findOrFail($id);

    rejected_transaction::create([
        'tanggal' => $transaction->tanggal,
        'jenis' => $transaction->jenis,
        'kategori' => $transaction->kategori,
        'jumlah' => $transaction->jumlah,
        'keterangan' => $transaction->keterangan,
        'gambar' => $transaction->gambar,
    ]);

    $transaction->delete();

    return redirect()->back();
}

    public function g3tApp()
    {
        $dataTransaksi = transaksi::all();
        $dataKategori = kategori::all();
        return view('admin.approved', compact('dataTransaksi','dataKategori'));
    }
}
