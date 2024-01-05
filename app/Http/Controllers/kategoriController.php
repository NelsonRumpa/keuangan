<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategori;

class kategoriController extends Controller
{

    public function kate(Request $request)
    {
        $validatedData = $request->validate([
            'jenis' => 'required',
            'kategori' => 'required'
        ]);

        $tambahKategori = [
            'jenis' => $request->jenis,
            'kategori' => $request->kategori
        ];

        kategori::create($tambahKategori);
        $dataKategori = kategori::all();

        
        return view('pegawai.kategori', compact('dataKategori'))->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function kat3(Request $request)
    {
        $validatedData = $request->validate([
            'jenis' => 'required',
            'kategori' => 'required'
        ]);

        $tambahKategori = [
            'jenis' => $request->jenis,
            'kategori' => $request->kategori
        ];

        kategori::create($tambahKategori);
        $dataKategori = kategori::all();

        
        return view('admin.kategori', compact('dataKategori'))->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function getKat()
    {
        $dataKategori = kategori::all();
        return view('pegawai.kategori', compact('dataKategori'));
    }

    public function getKat2()
    {
        $dataKategori = kategori::all();
        return view('admin.kategori', compact('dataKategori'));
    }

    public function edit($id)
{
    $data = kategori::find($id);
    return redirect()->back(compact('data'));
}

public function update(Request $request, $id)
{
    $data = kategori::find($id);
    $data->jenis = $request->input('jenis');
    $data->kategori = $request->input('kategori');

    $data->save();

    return redirect()->back();
}


    public function delKategori($id)
    {
        $katego = kategori::find($id);
        $katego->delete();

        return redirect()->back();
    }
}
