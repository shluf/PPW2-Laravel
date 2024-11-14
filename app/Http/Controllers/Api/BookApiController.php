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
}
