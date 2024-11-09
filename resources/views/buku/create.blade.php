@extends('layout')

@section('title', 'Tambah Buku')
@section('content')
    <div class="container">
        <h2 class="text-center my-4">Tambah Buku</h2>

        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="post" action="{{ route('buku.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul">
            </div>
            <div class="mb-3">
                <label for="penulis" class="form-label">Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis">
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga">
            </div>
            <div class="mb-3">
                <label for="tgl_terbit" class="form-label">Tanggal Terbit</label>
                <input type="text" id="tgl_terbit" name="tgl_terbit" class="date form-control" placeholder="yyyy/mm/dd">
            </div>
            <div class="mb-3">
                <label for="thumbnail" class="block text-sm font-medium leading-6 text-gray-900">Thumbnail</label>
                    <div class="mt-2">
                        <input type="file" name="thumbnail" class="form-control mb-2" id="thumbnail" onchange="previewThumbnail(event)">
                    </div>
                    <!-- Preview Thumbnail -->
                    <div id="thumbnailPreviewContainer" class="mt-3">
                        <img id="thumbnailPreview" src="" alt="Thumbnail Preview" style="max-width: 150px; display: none;" />
                    </div>

                <label for="gallery" class="form-label">Gallery</label>
                <div class="upload-container">
                    <input id="fileInput" type="file" name="gallery[]" class="form-control mb-2" multiple>
                    <div id="previewContainer" class="mt-3 mb-3 d-flex flex-wrap gap-2"></div>
                    <button type="button" class="btn btn-secondary mt-2" id="addFileButton">Tambah Gambar</button>
                </div>
            </div>

            <button class="btn btn-primary" type="submit">Simpan</button>
            <a class="btn btn-outline-danger" href="{{ url('/buku') }}">Kembali</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('fileInput');
            const previewContainer = document.getElementById('previewContainer');
            const addFileButton = document.getElementById('addFileButton');

            fileInput.addEventListener('change', (event) => handleFileChange(event, previewContainer));
            addFileButton.addEventListener('click', addNewFileInput);

            function handleFileChange(event, previewContainer) {
                const files = event.target.files;
                previewContainer.innerHTML = '';
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-thumbnail');
                        img.style.width = '100px';
                        img.style.height = '100px';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }

            function addNewFileInput() {
                const newFileInputWrapper = document.createElement('div');
                const newFileInput = document.createElement('input');
                newFileInput.type = 'file';
                newFileInput.name = 'gallery[]';
                newFileInput.classList.add('form-control', 'mb-2');
                const newPreviewContainer = document.createElement('div');
                newPreviewContainer.classList.add('mt-3', 'mb-3', 'd-flex', 'flex-wrap', 'gap-2');
                newFileInput.addEventListener('change', (event) => handleFileChange(event, newPreviewContainer));
                newFileInputWrapper.appendChild(newFileInput);
                newFileInputWrapper.appendChild(newPreviewContainer);
                document.querySelector('.upload-container').insertBefore(newFileInputWrapper, addFileButton);
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.classList.add('btn', 'btn-danger', 'mt-2', 'mb-3');
                removeButton.textContent = 'Hapus Gambar';
                removeButton.addEventListener('click', () => {
                    newFileInputWrapper.remove();
                });
                newFileInputWrapper.appendChild(removeButton);
            }
        });

        function previewThumbnail(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('thumbnailPreviewContainer');
            const previewImage = document.getElementById('thumbnailPreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    previewImage.style.width = '100px';
                    previewImage.style.height = '100px';
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.style.display = 'none';
            }
        }
    </script>
@endsection
