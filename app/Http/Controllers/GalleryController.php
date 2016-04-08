<?php

namespace App\Http\Controllers;

use App\PhotoCategory;

use App\Http\Requests;
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = PhotoCategory::notEmpty()->with('photo')->paginate();

        return view('gallery.index', compact('categories'));
    }

    /**
     * @param Request $request
     * @param int     $categoryId
     */
    public function showCategory(Request $request, $categoryId)
    {
        $category = PhotoCategory::findOrFail($categoryId);

        $photos = $category->photos;

        return view('gallery.show', compact('category', 'photos'));
    }

}
