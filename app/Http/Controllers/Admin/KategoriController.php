<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KategoriRequest;
use App\Models\KategoriMenu;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = KategoriMenu::orderBy('nama_kategori')->get();

        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return redirect()->route('admin.kategori.index');
    }

    public function store(KategoriRequest $request)
    {
        KategoriMenu::create($request->validated());

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show(KategoriMenu $kategori)
    {
        return redirect()->route('admin.kategori.index');
    }

    public function edit(KategoriMenu $kategori)
    {
        $kategoriToEdit = $kategori;
        $kategori = KategoriMenu::orderBy('nama_kategori')->get();

        return view('admin.kategori.index', compact('kategori', 'kategoriToEdit'));
    }

    public function update(KategoriRequest $request, KategoriMenu $kategori)
    {
        $kategori->update($request->validated());

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(KategoriMenu $kategori)
    {
        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
