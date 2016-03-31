<?php

namespace App\Http\Controllers;

use App\Http\Forms\StorePostForm;
use App\Http\Forms\UpdatePostForm;
use App\PhotoCategory;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('blog.index', [
            'posts' => \App\Post::latest()->paginate(5),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        if (is_null($post)) {
            abort(404, 'Новость не найдена');
        }

        return view('blog.show', [
            'post' => $post,
            'categories' => $post->photo_categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostForm $form
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostForm $form)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        if (is_null($post)) {
            abort(404, 'Новость не найдена');
        }

        return view('blog.edit', [
            'post' => $post,
            'categories' => PhotoCategory::pluck('title', 'id')->all(),
            'selected_categories' => $post->photo_categories->pluck('id')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePostForm $form
     * @param  int            $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostForm $form, $id)
    {
        $form->isValid();

        $post = Post::find($id);

        if (is_null($post)) {
            abort(404, 'Новость не найдена');
        }

        $post->update($form->fields());

        $post->photo_categories()->sync((array) $form->photo_categories);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
