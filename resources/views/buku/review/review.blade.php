@extends('layouts.app')

@section('title', 'Daftar Review Buku')

@section('content')
<div class="container-fluid mt-3">
    <a href="{{ route('buku') }}" class="btn btn-success mb-4">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Review</h3>
                    @if(Auth::check() && Auth::user()->level=='internal_reviewer')
                    <a href="{{ route('review.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Review Baru
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row mb-4">

                        <div class="col-md-6">
                            <form method="GET" action="{{ route('review') }}">
                                <label for="reviewer" class="form-label">Filter Reviewer</label>
                                <select name="reviewer" id="reviewer" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Reviewer</option>
                                    @foreach($reviewers as $reviewer)
                                    <option value="{{ $reviewer->id }}" {{ request('reviewer') == $reviewer->id ? 'selected' : '' }}>
                                        {{ $reviewer->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <form method="GET" action="{{ route('review') }}">
                                <label for="tag" class="form-label">Filter Tag</label>
                                <select name="tag" id="tag" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Tag</option>
                                    @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>
                                        {{ $tag->tag }}
                                    </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        @foreach($reviews as $review)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center h-100">

                                        <div class="relative h-8 w-8 me-4">
                                            @if ( $review->buku->filepath )
                                            <img class="h-full rounded-full object-cover object-center shadow"
                                                src="{{ asset($review->buku->filepath) }}"
                                                style="max-height: 150px;"
                                                alt="">
                                            @else
                                            <img class="h-full rounded-full object-cover object-center shadow"
                                                src="https://fakeimg.pl/240x320?text=Belum+ada+gambar&font_size=35"
                                                style="max-height: 150px;"
                                                alt="">
                                            @endif
                                        </div>

                                        <div>
                                            <h5 class="card-title">{{ $review->buku->judul }}</h5>
                                            <h6 class="card-subtitle text-muted">Oleh: {{ $review->user->name }}</h6>
                                            <p class="mt-3">
                                                <strong>Tanggal:</strong> {{ $review->created_at->format('d M Y') }}
                                            </p>
                                            <p>
                                                <strong class="me-3">Tags:</strong>
                                                @foreach($review->tags as $tag)
                                                <span class="badge bg-secondary me-1">{{ $tag->tag->tag }}</span>
                                                @endforeach
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($reviews->hasPages())
                <div class="card-footer">
                    {{ $reviews->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')

@endpush
@endsection
