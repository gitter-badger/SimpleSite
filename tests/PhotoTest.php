<?php

class PhotoTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    public function testFilePath()
    {
        $photo = new App\Photo();

        $photo->image  = 'test';
        $photo->thumb = 'test';

        $this->assertEquals($photo->image_path, public_path($photo->image));
        $this->assertEquals($photo->thumb_path, public_path($photo->thumb));
        $this->assertEquals($photo->image_url, url($photo->image));
        $this->assertEquals($photo->thumb_url, url($photo->thumb));
    }

    public function testFileUpload()
    {
        /** @var App\Photo $photo */
        $photo = factory(App\Photo::class)->make([
            'upload_file' => null
        ]);

        $filePath = base_path('tests/tmp/image.jpg');

        $file = new \Illuminate\Http\UploadedFile(
            $filePath,
            basename($filePath),
            'image/jpeg',
            File::size($filePath)
        );

        $photo->upload_file = $file;

        $photo->save();

        $oldFilePath = $photo->image_path;
        $oldThumbPath = $photo->thumb_path;

        $this->assertFileExists($oldFilePath);
        $this->assertFileExists($oldThumbPath);

        $photo->upload_file = $file;
        $photo->save();

        $this->assertFileNotExists($oldFilePath);
        $this->assertFileNotExists($oldThumbPath);

        $oldFilePath = $photo->image_path;
        $oldThumbPath = $photo->thumb_path;

        $photo->delete();

        $this->assertFileNotExists($oldFilePath);
        $this->assertFileNotExists($oldThumbPath);
    }
}