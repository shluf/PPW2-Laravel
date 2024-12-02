@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->level=='internal_reviewer')
<div class="container mt-5">
    <h2 class="mb-4">Tambahkan Review Buku</h2>

    <form action="{{ route('review.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="text" hidden class="form-control" name="reviewer" value="{{ Auth::user()->id }}">

        <div class="mb-3 position-relative">
            <label for="book_id" class="form-label">Pilih Buku</label>
            <input type="text" class="form-control" id="book-search" placeholder="Cari Buku">
            <div id="book-list" class="dropdown-menu w-100 shadow mt-1 overflow-x-hidden" style="display: none; max-height: 300px; overflow-y: auto;">
                <div class="row g-2">
                    @foreach($books as $book)
                    <div class="col-8 col-md-6 book-item" data-id="{{ $book->id }}">
                        <div class="dropdown-item d-flex align-items-center">
                            <img src="{{ $book->filepath }}" alt=" " class="img-thumbnail me-2" style="width: 50px; height: 50px;">
                            <div class="d-flex flex-column">
                                <span>{{ $book->judul }}</span>
                                <span class="text-secondary" style="font-size: 12px;">{{ $book->penulis }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <input type="hidden" id="book_id" name="book_id">
        </div>


        <div class="mb-3">
            <label for="review_content" class="form-label">Review</label>
            <textarea class="form-control" id="review_content" name="review_content" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tags</label>
            <div id="tags-container">
                <div class="position-relative">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control tag-input" id="new-tag-input" placeholder="Masukkan tag">
                        <button class="btn btn-success add-tag-btn px-5" type="button">+</button>
                    </div>
                    <div class="dropdown-menu w-100" id="tags-dropdown" style="max-height: 200px; overflow-y: auto;"></div>
                </div>
            </div>
            <div id="added-tags" class="mt-3">
                <!-- Tag yang ditambahkan -->
            </div>
        </div>



        <button type="submit" class="btn btn-primary">Simpan Review</button>
        <a class="btn btn-outline-danger ms-3" href="{{ route('review') }}">Kembali</a>
    </form>
</div>
@endif
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const $bookSearch = $('#book-search');
        const $bookList = $('#book-list');
        const $bookIdInput = $('#book_id');

        $bookSearch.on('input', function() {
            const query = $(this).val().toLowerCase().trim();
            if (query) {
                $bookList.show();
                let hasResults = false;
                $('.book-item').each(function() {
                    const bookTitle = $(this).find('span').text().toLowerCase();
                    const isMatch = bookTitle.includes(query);

                    if (isMatch) {
                        $(this).removeClass('d-none');
                        hasResults = true;
                    } else {
                        $(this).addClass('d-none');
                    }
                });
                if (!hasResults) $bookList.hide();
            } else {
                $bookList.hide();
            }
        });

        $bookList.on('click', '.book-item', function() {
            const bookTitle = $(this).find('span').text();
            const bookId = $(this).data('id');
            $bookSearch.val(bookTitle);
            $bookIdInput.val(bookId);
            $bookList.hide();
        });

        $bookSearch.on('blur', function() {
            setTimeout(() => $bookList.hide(), 100);
        });

        $bookSearch.on('focus', function() {
            if (!$bookSearch.val()) $bookList.show();
        });

        $bookList.on('mousedown', function(e) {
            e.preventDefault();
        });
    });

    $(document).ready(function() {
        const $dropdown = $('#tags-dropdown');

        $('#new-tag-input').on('input', function() {
            const query = $(this).val().trim();

            if (query.length > 1) {
                $.ajax({
                    url: "{{ route('tags.search') }}",
                    data: {
                        term: query
                    },
                    success: function(tags) {
                        if (tags.length > 0) {
                            $dropdown.empty();
                            $dropdown.show();
                            tags.forEach(tag => {
                                $dropdown.append(`<button class="dropdown-item" type="button">${tag}</button>`);
                            });
                            $dropdown.addClass('show');
                        } else {
                            $dropdown.removeClass('show');
                        }
                    },
                });
            } else {
                $dropdown.removeClass('show');
            }
        });

        $dropdown.on('click', '.dropdown-item', function() {
            const selectedTag = $(this).text();
            addTag(selectedTag);
            $('#new-tag-input').val('');
            $dropdown.removeClass('show');
        });

        $('.add-tag-btn').click(function() {
            const input = $('#new-tag-input');
            const tagValue = input.val().trim();
            if (tagValue) {
                addTag(tagValue);
                input.val('');
            }
        });

        $(document).on('click', '.remove-tag-btn', function() {
            $(this).closest('.input-group').remove();
        });

        function addTag(tag) {
            const newTagHtml = `
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="tags[]" value="${tag}" readonly>
                <button class="btn btn-danger remove-tag-btn px-5" type="button">-</button>
            </div>
        `;
            $('#added-tags').append(newTagHtml);
        }

        $('#new-tag-input').on('blur', function() {
            setTimeout(() => $dropdown.hide(), 400);
        });
    });
</script>
@endpush