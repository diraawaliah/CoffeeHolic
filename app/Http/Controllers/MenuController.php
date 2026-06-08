<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal ukuran 2MB
        ]);

        // 2. Logika untuk mengurus file gambar (jika admin mengunggah foto)
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Beri nama unik pada gambar berdasarkan waktu agar tidak tertukar
            $imageName = time() . '.' . $request->image->extension();  
            // Pindahkan ke folder public/img/
            $request->image->move(public_path('img'), $imageName);
            // Simpan rute jalurnya untuk database
            $imagePath = 'img/' . $imageName;
        }

        // 3. Simpan ke database
        \App\Models\Menu::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'image_path' => $imagePath,
        ]);

        // 4. Kembalikan admin ke dashboard dengan pesan sukses
        return redirect()->back()->with('success', 'Menu Kopi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Cari data berdasarkan ID
        $menu = \App\Models\Menu::findOrFail($id);
        
        // Buka halaman edit dan bawa data lamanya
        return view('admin.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $menu = \App\Models\Menu::findOrFail($id);

        // Jika admin mengunggah gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari folder jika ada
            if ($menu->image_path && file_exists(public_path($menu->image_path))) {
                unlink(public_path($menu->image_path));
            }

            // Simpan gambar baru
            $imageName = time() . '.' . $request->image->extension();  
            $request->image->move(public_path('img'), $imageName);
            $menu->image_path = 'img/' . $imageName;
        }

        // Update data teks
        $menu->name = $request->name;
        $menu->category = $request->category;
        $menu->price = $request->price;
        $menu->save();

        return redirect()->route('admin.dashboard')->with('success', 'Data menu berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 1. Cari data menu berdasarkan ID yang diklik
        $menu = \App\Models\Menu::findOrFail($id);

        // 2. Cek apakah menu ini punya gambar, jika iya, hapus file fisiknya
        if ($menu->image_path && file_exists(public_path($menu->image_path))) {
            unlink(public_path($menu->image_path));
        }

        // 3. Hapus data dari database
        $menu->delete();

        // 4. Kembalikan ke halaman dashboard dengan pesan sukses
        return redirect()->back()->with('success', 'Data menu berhasil dihapus selamanya!');
    }
}
