<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Buku;
use App\Models\User;
use App\Models\Tag;
use App\Models\ReviewTag;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['buku', 'user', 'tags']);

        if ($request->has('reviewer') && $request->reviewer) {
            $query->where('reviewer_id', $request->reviewer);
        }

        if ($request->has('tag') && $request->tag) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tag_id', $request->tag);
            });
        }

        $reviews = $query->latest()->paginate(10);
        $reviewers = User::all();
        $tags = Tag::all();

        Log::info('Reviews:', ['reviews' => $reviews]);

        return view('buku.review.review', compact('reviews', 'reviewers', 'tags'));
    }

    public function create()
    {
        $books = Buku::all();
        return view('buku.review.create', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reviewer'       => 'required|integer|exists:users,id',
            'book_id'        => 'required|integer|exists:books,id',
            'review_content' => 'required|string',
            'tags'           => 'array',
            'tags.*'         => 'string',
        ]);

        $review = new Review();
        $review->buku_id = $request->book_id;
        $review->review = $request->review_content;
        $review->reviewer_id = $request->reviewer;
        $review->save();

        if (!empty($request->tags)) {
            foreach ($request->tags as $tag) {
                $existingTag = Tag::where('tag', $tag)->first();

                if ($existingTag) {
                    ReviewTag::create([
                        'review_id' => $review->id,
                        'tag_id' => $existingTag->id,
                    ]);
                } else {
                    $newTag = Tag::create([
                        'review_id' => $review->id,
                        'tag' => $tag,
                    ]);
                    ReviewTag::create([
                        'review_id' => $review->id,
                        'tag_id' => $newTag->id,
                    ]);
                }
            }
        }

        return redirect('/buku/review')->with('pesan', 'Review buku berhasil ditambahkan');
    }

    public function searchTags(Request $request)
    {
        $search = $request->input('term');
        $tags = Tag::where('tag', 'like', "%{$search}%")
                ->pluck('tag');
        return response()->json($tags);
    }
}
