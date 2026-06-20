<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriMenu;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = KategoriMenu::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return redirect()->route('admin.kategori.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriMenu::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.kategori.index');
    }

    public function edit(string $id)
    {
        $kategoriToEdit = KategoriMenu::findOrFail($id);
        $kategori = KategoriMenu::all();
        return view('admin.kategori.index', compact('kategori', 'kategoriToEdit'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = KategoriMenu::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $kategori = KategoriMenu::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
