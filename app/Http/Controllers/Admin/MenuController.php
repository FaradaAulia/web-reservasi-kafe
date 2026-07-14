<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\KategoriMenu;
use App\Models\Menu;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('kategori')->latest()->get();

        return view('admin.menu.index', compact('menus'));
    }

    public function create()
    {
        $kategori = KategoriMenu::orderBy('nama_kategori')->get();

        return view('admin.menu.create', compact('kategori'));
    }

    public function store(MenuRequest $request)
    {
        $data = $request->validated();
        $data['foto'] = $this->storePhoto($request);

        Menu::create($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function show(Menu $menu)
    {
        return redirect()->route('admin.menu.index');
    }

    public function edit(Menu $menu)
    {
        $kategori = KategoriMenu::orderBy('nama_kategori')->get();

        return view('admin.menu.edit', compact('menu', 'kategori'));
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $this->deletePhoto($menu->foto);
            $data['foto'] = $this->storePhoto($request);
        } else {
            unset($data['foto']);
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        $this->deletePhoto($menu->foto);
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus!');
    }

    private function storePhoto(MenuRequest $request): ?string
    {
        if (! $request->hasFile('foto')) {
            return null;
        }

        if (! File::isDirectory(public_path('menus'))) {
            File::makeDirectory(public_path('menus'), 0755, true);
        }

        $file = $request->file('foto');
        $fileName = Str::uuid().'.'.$file->extension();
        $file->move(public_path('menus'), $fileName);

        return 'menus/'.$fileName;
    }

    private function deletePhoto(?string $path): void
    {
        if ($path && str_starts_with($path, 'menus/') && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
