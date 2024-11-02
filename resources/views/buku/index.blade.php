@extends('layouts.app')

@section('content')
<body class="p-4">
    @if(Session::has('pesan'))
    <div class="alert alert-success">{{Session::get('pesan')}}</div>
    @endif
    <nav class="d-flex justify-content-end w-100 my-4 gap-4">
        <form action="{{ route('buku.search') }}" method="get">@csrf
            <input type="text" name="kata" class="form-control" placeholder="Cari ... ">
        </form>
        @if(Auth::check() && Auth::user()->level=='admin')
        <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>
        @endif
    </nav>
    <table class="table table-stripped">
        <thead>
            <tr>
                <th>id</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Tanggal Terbit</th>
                @if(Auth::check() && Auth::user()->level=='admin')
                <th>Aksi</th>
                <th>Edit</th>
                @endif
            </tr>
        </thead>
        <tbody>

            @foreach($data_buku as $buku)
            <tr>
                <div>
                    <td>{{ $buku->id}}</td>
                    <td id="baris-1{{ $buku->id }}">{{ $buku->judul }}</td>
                    <td id="baris-2{{ $buku->id }}">{{ $buku->penulis }}</td>
                    <td id="baris-3{{ $buku->id }}">{{ "Rp. ".number_format($buku->harga, 2, ',','.') }}</td>
                    <td id="baris-4{{ $buku->id }}">{{ $buku->tgl_terbit->format('d/m/Y') }}</td>
                </div>

                <form action="{{ route ('buku.update', $buku->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $buku->id }}">
                    <td id="form-edit-0{{ $buku->id }}" style="display: none;"><input type="text" name="judul" value="{{ $buku->judul }}"></td>
                    <td id="form-edit-1{{ $buku->id }}" style="display: none;"><input type="text" name="penulis" value="{{ $buku->penulis }}"></td>
                    <td id="form-edit-2{{ $buku->id }}" style="display: none;"><input type="text" name="harga" value="{{ $buku->harga }}"></td>
                    <td id="form-edit-3{{ $buku->id }}" style="display: none;"><input type="date" name="tgl_terbit" value="{{ $buku->tgl_terbit->format('Y-m-d') }}"></td>
                    <td id="form-edit-4{{ $buku->id }}" style="display: none;"><button type="submit" class="btn btn-success">Update</button></td>
                </form>

                @if(Auth::check() && Auth::user()->level=='admin')

                <td id="hps-{{ $buku->id }}">
                    <form action="{{ route ('buku.destroy', $buku->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin mau dihapus?')"
                            type="submit"
                            class="btn btn-danger">Hapus</button>
                    </form>
                </td>

                <td>
                    <button class="btn btn-outline-warning" onclick="toggleEditForm('{{ $buku->id }}')">Edit</button>
                </td>
                @endif
            </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total Harga Buku</strong></td>
                <td colspan="5"><strong>Rp. {{ number_format($total_harga, 2, ',', '.') }}</strong></td>
            </tr>

        </tbody>
    </table>


    <p class="alert alert-info">Jumlah Buku: {{ $jumlah_buku }}</p>
    <div class="d-flex justify-content-center flex-row">
        {{ $data_buku->links('pagination::bootstrap-5') }}
    </div>

    <script src="/js/toggleEdit.js"></script>
</body>

@endsection