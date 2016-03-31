<?php

namespace App\Http\Forms;

use App\Upload;
use File;
use Illuminate\Http\UploadedFile;

class UploadForm extends Form
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
        $data = $this->request->getContent();
        $name = $this->request->server->get('HTTP_X_FILE_NAME');
        File::put($filePath = storage_path('app/public/'.$name), $data);

        if (! File::exists($filePath)) {
            return [];
        }

        /** @var UploadedFile $uploadFile */
        $uploadFile = new UploadedFile($filePath, $name, File::mimeType($filePath), File::size($filePath));

        $file = new Upload();

        $file->file = $uploadFile;
        $file->name = $uploadFile->getClientOriginalName();
        $file->content_type = $uploadFile->getClientMimeType();
        $file->size = $uploadFile->getClientSize();

        $file->save();

        unlink($filePath);

        return $file->toArray();
    }
}