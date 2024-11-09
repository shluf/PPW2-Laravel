<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function destroy($id)
    {
        // Temukan gambar berdasarkan ID
        $gallery = Gallery::findOrFail($id);
        
        // Hapus file gambar dari storage
        if (Storage::exists('public' . $gallery->path)) {
            Storage::delete('public' . $gallery->path);
        }

        // Hapus entri gallery dari database
        $gallery->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('pesan', 'Gambar berhasil dihapus.');
    }
}
