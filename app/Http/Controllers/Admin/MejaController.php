<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MejaRequest;
use App\Models\Meja;

class MejaController extends Controller
{
    public function index()
    {
        $meja = Meja::orderBy('nomor_meja')->get();

        return view('admin.meja.index', compact('meja'));
    }

    public function create()
    {
        return redirect()->route('admin.meja.index');
    }

    public function store(MejaRequest $request)
    {
        Meja::create($request->validated());

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil ditambahkan!');
    }

    public function show(Meja $meja)
    {
        return redirect()->route('admin.meja.index');
    }

    public function edit(Meja $meja)
    {
        $mejaToEdit = $meja;
        $meja = Meja::orderBy('nomor_meja')->get();

        return view('admin.meja.index', compact('meja', 'mejaToEdit'));
    }

    public function update(MejaRequest $request, Meja $meja)
    {
        $meja->update($request->validated());

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil diperbarui!');
    }

    public function destroy(Meja $meja)
    {
        $meja->delete();

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil dihapus!');
    }
}
