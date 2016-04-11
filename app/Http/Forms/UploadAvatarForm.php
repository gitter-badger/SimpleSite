<?php

namespace App\Http\Forms;

class UploadAvatarForm extends Form
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
        if (is_null($user = auth()->user())) {
            return;
        }

        $uploadFile = $this->request->file('file');

        if (is_null($uploadFile)) {
            return;
        }

        $user->avatar_file = $uploadFile;
        $user->save();

        return [
            'user' => $user
        ];
    }
}