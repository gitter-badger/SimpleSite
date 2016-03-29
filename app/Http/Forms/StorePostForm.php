<?php

namespace App\Http\Forms;

use App\Post;

class StorePostForm extends Form
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required',
            'text_source' => 'required',
        ];
    }

    /**
     * Persist the form.
     *
     * @return mixed
     */
    public function persist()
    {
        return Post::create($this->fields());
    }
}