<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\KategoriMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('kategori')->latest()->get();
        return view('admin.menu.index', compact('menus'));
    }

    public function create()
    {
        $kategori = KategoriMenu::all();
        return view('admin.menu.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_menu,id',
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:tersedia,habis',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Create directory if not exists
            if (!File::isDirectory(public_path('menus'))) {
                File::makeDirectory(public_path('menus'), 0777, true, true);
            }
            
            $file->move(public_path('menus'), $fotoName);
            $fotoPath = 'menus/' . $fotoName;
        }

        Menu::create([
            'kategori_id' => $request->kategori_id,
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'foto' => $fotoPath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.menu.index');
    }

    public function edit(string $id)
    {
        $menu = Menu::findOrFail($id);
        $kategori = KategoriMenu::all();
        return view('admin.menu.edit', compact('menu', 'kategori'));
    }

    public function update(Request $request, string $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:kategori_menu,id',
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:tersedia,habis',
        ]);

        $fotoPath = $menu->foto;
        if ($request->hasFile('foto')) {
            // Delete old file if exists
            if ($menu->foto && File::exists(public_path($menu->foto))) {
                File::delete(public_path($menu->foto));
            }

            $file = $request->file('foto');
            $fotoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            if (!File::isDirectory(public_path('menus'))) {
                File::makeDirectory(public_path('menus'), 0777, true, true);
            }
            
            $file->move(public_path('menus'), $fotoName);
            $fotoPath = 'menus/' . $fotoName;
        }

        $menu->update([
            'kategori_id' => $request->kategori_id,
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'foto' => $fotoPath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $menu = Menu::findOrFail($id);

        // Delete photo file if exists
        if ($menu->foto && File::exists(public_path($menu->foto))) {
            File::delete(public_path($menu->foto));
        }

        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
