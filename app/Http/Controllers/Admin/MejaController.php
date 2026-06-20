<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index()
    {
        $meja = Meja::all();
        return view('admin.meja.index', compact('meja'));
    }

    public function create()
    {
        return redirect()->route('admin.meja.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|string|unique:meja,nomor_meja|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,dipesan',
        ]);

        Meja::create([
            'nomor_meja' => $request->nomor_meja,
            'kapasitas' => $request->kapasitas,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.meja.index');
    }

    public function edit(string $id)
    {
        $mejaToEdit = Meja::findOrFail($id);
        $meja = Meja::all();
        return view('admin.meja.index', compact('meja', 'mejaToEdit'));
    }

    public function update(Request $request, string $id)
    {
        $meja = Meja::findOrFail($id);
        
        $request->validate([
            'nomor_meja' => 'required|string|max:255|unique:meja,nomor_meja,' . $meja->id,
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,dipesan',
        ]);

        $meja->update([
            'nomor_meja' => $request->nomor_meja,
            'kapasitas' => $request->kapasitas,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $meja = Meja::findOrFail($id);
        $meja->delete();

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil dihapus!');
    }
}
