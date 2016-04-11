<?php

namespace App\Http\Forms;

use App\User;

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

        $userId = $this->request->input('user_id');
        if ($user->id != $userId and ($user->isManager() and is_null($user = User::find($userId)))) {
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