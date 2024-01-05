<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\rejected_transaction;

class transaksiController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required',
            'jenis' => 'required',
            'kategori' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $gambarPath = $request->file('gambar')->store('public/gambar');
        $gambarUrl = asset('storage/' . str_replace('public/', '', $gambarPath));

        $tambahTransaksi = [
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'gambar' => $gambarUrl,
        ];

        transaksi::create($tambahTransaksi);
        $dataTransaksi = transaksi::all();
        $dataKategori = kategori::all();
        $jumlah5 = transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $jumlah6 = transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $jumlah5 - $jumlah6;
        return view('pegawai.transaksi', compact('dataTransaksi','dataKategori','jumlah5','jumlah6','saldo'))->with('success', 'Donasi berhasil ditambahkan.');
    }

    public function stor3(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required',
            'jenis' => 'required',
            'kategori' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $gambarPath = $request->file('gambar')->store('public/gambar');
        $gambarUrl = asset('storage/' . str_replace('public/', '', $gambarPath));

        $tambahTransaksi = [
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'gambar' => $gambarUrl,
        ];

        transaksi::create($tambahTransaksi);
        $dataTransaksi = transaksi::all();
        $dataKategori = kategori::all();
        $jumlah5 = transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $jumlah6 = transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $jumlah5 - $jumlah6;

        return view('admin.transaksi', compact('dataTransaksi','dataKategori','jumlah5','jumlah6','saldo'))->with('success', 'Donasi berhasil ditambahkan.');
    }

    public function getTra()
    {
        $dataTransaksi = transaksi::all();
        $dataKategori = kategori::all();
        $jumlah5 = transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $jumlah6 = transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $jumlah5 - $jumlah6;
        return view('pegawai.transaksi', compact('dataTransaksi','dataKategori','jumlah5','jumlah6','saldo'));
    }

    public function getTra2()
    {
        $dataTransaksi = transaksi::all();
        $dataKategori = kategori::all();
        $jumlah5 = transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $jumlah6 = transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $jumlah5 - $jumlah6;
        return view('admin.transaksi', compact('dataTransaksi','dataKategori','jumlah5','jumlah6','saldo'));
    }

    public function getRejected()
    {
        $dataRejected = rejected_transaction::all();
        $dataKategori = kategori::all();
        return view('admin.rejected', compact('dataRejected','dataKategori'));
    }

    public function getTra3()
    {
        $dataTransaksi = transaksi::all();
        $dataKategori = kategori::all();
        $jumlah5 = transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $jumlah6 = transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $jumlah5 - $jumlah6;
        return view('admin.dashboard', compact('dataTransaksi','dataKategori','jumlah5','jumlah6','saldo'));
    }

    public function edit($id)
{
    $data = transaksi::find($id);
    $dataKategori = kategori::all();
    return redirect()->back(compact('data'));
}

public function update(Request $request, $id)
{
    $data = transaksi::find($id);
    $data->tanggal = $request->input('tanggal');
    $data->jenis = $request->input('jenis');
    $data->kategori = $request->input('kategori');
    $data->jumlah = $request->input('jumlah');
    $data->keterangan = $request->input('keterangan');
    if ($request->hasFile('gambar')) {
        // Validasi gambar
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan gambar ke storage
        $gambarPath = $request->file('gambar')->store('public/gambar');
        $gambarUrl = asset('storage/' . str_replace('public/', '', $gambarPath));

        $data->gambar = $gambarUrl;
    }

    $data->save();
    $dataKategori = kategori::all();

    return redirect()->back();
}

public function filter(Request $request)
{
    $dataKategori = kategori::all();
    $jumlah5 = transaksi::where('jenis', 'pemasukan')->sum('jumlah');
    $jumlah6 = transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
    $saldo = $jumlah5 - $jumlah6;

    $tanggal_start = $request->input('tanggal_start');
    $tanggal_end = $request->input('tanggal_end');
    $approved = $request->input('approved');

    $request->validate([
        'tanggal_start' => 'required|date',
        'tanggal_end' => 'required|date|after_or_equal:tanggal_start',
    ]);
    

    $dataTransaksi = Transaksi::whereBetween('tanggal', [$tanggal_start, $tanggal_end])
    ->when($approved, function ($query) {
        return $query->where('is_approved', 1);
    })
    ->get();

    return view('admin.transaksi', compact('dataTransaksi','dataKategori','jumlah5','jumlah6','saldo'));
}

public function filter2(Request $request)
{
    $dataKategori = kategori::all();
    $jumlah5 = transaksi::where('jenis', 'pemasukan')->sum('jumlah');
    $jumlah6 = transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
    $saldo = $jumlah5 - $jumlah6;

    $tanggal_start = $request->input('tanggal_start');
    $tanggal_end = $request->input('tanggal_end');
    $approved = $request->input('approved');

    $request->validate([
        'tanggal_start' => 'required|date',
        'tanggal_end' => 'required|date|after_or_equal:tanggal_start',
    ]);
    

    $dataTransaksi = Transaksi::whereBetween('tanggal', [$tanggal_start, $tanggal_end])
    ->when($approved, function ($query) {
        return $query->where('is_approved', 1);
    })
    ->get();

    return view('pegawai.transaksi', compact('dataTransaksi','dataKategori','jumlah5','jumlah6','saldo'));
}

public function generatePDF(Request $request)
    {
        $dataKategori = kategori::all();
        $jumlah5 = transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $jumlah6 = transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $jumlah5 - $jumlah6;
        $dataByDate = Transaksi::all()->groupBy('tanggal'); // Mengelompokkan data transaksi berdasarkan tanggal
        $sortedDates = $dataByDate->keys()->sortDesc();

        $dataTransaksi = transaksi::all(); 
        $pdf = PDF::loadView('cetakPDF', compact('dataTransaksi','dataKategori','jumlah5','jumlah6','saldo','dataByDate','sortedDates'))->setOptions(['defaultFont' ]);

        return $pdf->download('transaksi.pdf');
    }

    public function export_excel()
	{
        $dataKategori = kategori::all();
        $jumlah5 = transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $jumlah6 = transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo = $jumlah5 - $jumlah6;

		return Excel::download(new TransaksiExport, 'transaksi.xlsx');
	}

    

    public function delTransaksi($id)
    {
        $trans = transaksi::find($id);
        $trans->delete();

        return redirect()->back();
    }

}
