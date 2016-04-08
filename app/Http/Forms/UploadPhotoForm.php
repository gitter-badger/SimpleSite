<?php

namespace App\Http\Forms;

use App\Photo;
use App\PhotoCategory;

class UploadPhotoForm extends Form
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|image',
        ];
    }

    /**
     * Persist the form.
     *
     * @return mixed
     */
    public function persist()
    {
        if (is_null($categoryId = $this->request->route('id')) or is_null($category = PhotoCategory::find($categoryId))) {
            return;
        }

        $uploadFile = $this->request->file('file');

        if (is_null($uploadFile)) {
            return;
        }

        $photo = new Photo();

        $photo->upload_file = $uploadFile;
        $photo->category()->associate($category);

        $photo->save();

        return [
            'photo' => $photo,
            'html' => view('gallery.partials.photo', ['photo' => $photo])->render(),
        ];
    }
}