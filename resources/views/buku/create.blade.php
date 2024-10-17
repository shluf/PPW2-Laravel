@extends('layout')

@section('title', 'Tambah Buku')
@section('content')
    <div class="container">
        <h2 class="text-center my-4">Tambah Buku</h2>
        
        @if (count($errors) > 0)
        <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
        @endif

        <form method="post" action="{{route('buku.store')}}">
            @csrf
            <div >
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul">
            </div>
            <div >
                <label for="penulis" class="form-label">Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis">
            </div>
            <div >
                <label for="harga" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga">
            </div>
            <div class="mb-2">
                <label for="tgl_terbit" class="form-label">Tanggal Terbit</label>
                <input type="text" id="tgl_terbit" name="tgl_terbit" class="date form-control" placeholder="yyyy/mm/dd">
            </div>
            <button class="btn btn-primary" type="submit">Simpan</button>
            <a class="btn btn-outline-danger" href="{{'/buku'}}">Kembali</a>
        </form>
    </div>
@endsection


