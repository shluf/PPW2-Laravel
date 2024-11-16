<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Buku;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    public function index() {
        $books = Buku::latest('updated_at')->paginate(5);

        return new BookResource(true, 'List Data Buku', $books);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
            'filename' => 'nullable|string|max:255',
            'filepath' => 'nullable|string|max:255',
        ]);

        $book = Buku::create([
            'judul' => $validated['judul'],
            'penulis' => $validated['penulis'],
            'harga' => $validated['harga'],
            'tgl_terbit' => $validated['tgl_terbit'],
            'filename' => $validated['filename'] ?? null,
            'filepath' => $validated['filepath'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil disimpan',
            'data' => new BookResource(true, 'Berhasil disimpan', $book)
        ]);
    }
}
