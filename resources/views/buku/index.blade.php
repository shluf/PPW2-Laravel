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
        <a href="{{ route('review') }}" class="btn btn-primary">Lihat Review</a>
        @if(Auth::check() && Auth::user()->level=='admin')
        <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>
        @endif
        @if(Auth::check() && Auth::user()->level=='internal_reviewer')
        <a href="{{ route('review.create') }}" class="btn btn-primary">Tambah Review</a>
        @endif
    </nav>

    <!-- Table Section -->
    <table class="table table-stripped">
        <thead>
            <tr>
                <th>id</th>
                <th>Thumbnail</th>
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
                <td>{{ $buku->id}}</td>
                <td>
                    <div class="relative h-8 w-8">
                        @if ( $buku->filepath )
                        <img class="h-full rounded-full object-cover object-center"
                            src="{{ asset($buku->filepath) }}"
                            style="max-height: 100px;"
                            alt="">
                        @else
                        <img class="h-full rounded-full object-cover object-center"
                            src="https://fakeimg.pl/240x320?text=Belum+ada+gambar&font_size=35"
                            style="max-height: 100px;"
                            alt="">
                        @endif
                    </div>
                </td>
                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ "Rp. ".number_format($buku->harga, 2, ',','.') }}</td>
                <td>{{ $buku->tgl_terbit->format('d/m/Y') }}</td>

                @if(Auth::check() && Auth::user()->level=='admin')
                <td>
                    <form action="{{ route ('buku.destroy', $buku->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin mau dihapus?')"
                            type="submit"
                            class="btn btn-danger">Hapus</button>
                    </form>
                </td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{$buku->id}}">
                        Edit
                    </button>
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


    @foreach($data_buku as $buku)
    <div class="modal fade" id="editModal{{$buku->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$buku->id}}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{$buku->id}}">Edit Buku - {{$buku->judul}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{ $buku->id }}">

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="judul" name="judul" value="{{ $buku->judul }}">
                        </div>

                        <div class="mb-3">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control" id="penulis" name="penulis" value="{{ $buku->penulis }}">
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" value="{{ $buku->harga }}">
                        </div>

                        <div class="mb-3">
                            <label for="tgl_terbit" class="form-label">Tanggal Terbit</label>
                            <input type="date" class="form-control" id="tgl_terbit" name="tgl_terbit" value="{{ $buku->tgl_terbit->format('Y-m-d') }}">
                        </div>

                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                            @if($buku->filepath)
                            <div class="mt-2">
                                <small>Current thumbnail:</small>
                                <img src="{{ asset($buku->filepath) }}" alt="Current thumbnail" class="mt-2" style="max-height: 100px;">
                            </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="gallery" class="form-label">Gallery</label>
                            <div id="fileinput_wrapper_{{$buku->id}}">
                                <input type="file" name="gallery[]" class="form-control mb-2">
                            </div>
                            <button type="button" class="btn btn-secondary mt-2" onclick="addFileInput('{{$buku->id}}')">
                                Add More Images
                            </button>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                @if($buku->galleries()->count() > 0)
                <div class="m-3">
                    <h2 class="form-label">Current Gallery Images</h2>
                    <div class="row">
                        @foreach($buku->galleries()->get() as $gallery)
                        <div class="col-md-4 mb-2">
                            <img src="{{ asset($gallery->path) }}" alt="Gallery image" class="img-fluid rounded">
                            <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    <p class="alert alert-info">Jumlah Buku: {{ $jumlah_buku }}</p>
    <div class="d-flex justify-content-center flex-row">
        {{ $data_buku->links('pagination::bootstrap-5') }}
    </div>

    <script>
        function addFileInput(bookId) {
            const wrapper = document.getElementById(`fileinput_wrapper_${bookId}`);
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'gallery[]';
            input.className = 'form-control mb-2';
            wrapper.appendChild(input);
        }
    </script>
</body>
@endsection