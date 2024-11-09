<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BukuController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin'); 
    }

    public function index()
    {
        $batas = 5;
        $jumlah_buku = Buku::count();
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($data_buku->currentPage() - 1);
        $total_harga = $data_buku->sum('harga');

        return view('buku.index', compact('data_buku', 'no', 'jumlah_buku', 'total_harga'));
    }

    public function search(Request $request)
    {
        $batas = 5;
        $cari = $request->kata;
        $data_buku = Buku::where('judul', 'like', "%" . $cari . "%")
                        ->orWhere('penulis', 'like', "%" . $cari . "%")
                        ->paginate($batas);
        $jumlah_buku = $data_buku->count();
        $no = $batas * ($data_buku->currentPage() - 1);
        $total_harga = $data_buku->sum('harga');
        
        return view('buku.search', compact('jumlah_buku', 'data_buku', 'no', 'cari', 'total_harga'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string',
            'penulis'     => 'required|string|max:30',
            'harga'       => 'required|numeric',
            'tgl_terbit'  => 'required|date',
            'thumbnail'   => 'image|mimes:jpeg,jpg,png|max:2048',
            'gallery.*'   => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;

        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = time() . ' ' . $thumbnailFile->getClientOriginalName();
            $thumbnailPath = $thumbnailFile->storeAs('uploads', $thumbnailName, 'public');

            Image::make(storage_path('app/public/uploads/' . $thumbnailName))
                ->fit(240, 320)
                ->save();

            $buku->filename = $thumbnailName;
            $buku->filepath = '/storage/' . $thumbnailPath;
        }

        $buku->save();

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $fileName = time() . ' ' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                Gallery::create([
                    'nama_galeri' => $fileName,
                    'path'        => '/storage/' . $filePath,
                    'foto'        => $fileName,
                    'buku_id'     => $buku->id
                ]);
            }
        }

        return redirect('/buku')->with('pesan', 'Data buku berhasil disimpan');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect('/buku');
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul'     => 'required|string',
            'penulis'   => 'required|string|max:30',
            'harga'     => 'required|numeric',
            'tgl_terbit'=> 'required|date',
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048',
            'gallery.*' => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;

        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = time() . ' ' . $thumbnailFile->getClientOriginalName();
            $thumbnailPath = $thumbnailFile->storeAs('uploads', $thumbnailName, 'public');

            Image::make(storage_path('app/public/uploads/' . $thumbnailName))
                ->fit(240, 320)
                ->save();

            $buku->filename = $thumbnailName;
            $buku->filepath = '/storage/' . $thumbnailPath;
        }

        $buku->save();

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $fileName = time() . ' ' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                Gallery::create([
                    'nama_galeri' => $fileName,
                    'path'        => '/storage/' . $filePath,
                    'foto'        => $fileName,
                    'buku_id'     => $buku->id
                ]);
            }
        }

        return redirect('/buku')->with('pesan', 'Perubahan data buku berhasil disimpan');
    }
}
