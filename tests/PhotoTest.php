<?php

class PhotoTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    public function testFilePath()
    {
        $photo = new App\Photo();

        $photo->image = 'test';
        $photo->thumb = 'test';

        $this->assertEquals(public_path($photo->image), $photo->image_path);
        $this->assertEquals(public_path($photo->thumb), $photo->thumb_path);
        $this->assertEquals(url($photo->image), $photo->image_url);
        $this->assertEquals(url($photo->thumb), $photo->thumb_url);
    }

    public function testFileUpload()
    {
        /** @var App\Photo $photo */
        $photo = factory(App\Photo::class)->make([
            'upload_file' => null
        ]);

        $file = $this->getUploadedFile();

        $photo->upload_file = $file;

        $photo->save();

        $oldFilePath  = $photo->image_path;
        $oldThumbPath = $photo->thumb_path;

        $this->assertFileExists($oldFilePath);
        $this->assertFileExists($oldThumbPath);

        $photo->upload_file = $file;
        $photo->save();

        $this->assertFileNotExists($oldFilePath);
        $this->assertFileNotExists($oldThumbPath);

        $oldFilePath  = $photo->image_path;
        $oldThumbPath = $photo->thumb_path;

        $photo->save();

        $this->assertEquals($oldFilePath, $photo->image_path);
        $this->assertEquals($oldThumbPath, $photo->thumb_path);

        $this->assertFileExists($photo->image_path);
        $this->assertFileExists($photo->thumb_path);

        $oldFilePath  = $photo->image_path;
        $oldThumbPath = $photo->thumb_path;

        $photo->delete();

        $this->assertFileNotExists($oldFilePath);
        $this->assertFileNotExists($oldThumbPath);
    }

    public function testPhotoUpdate()
    {
        /** @var App\Photo $photo */
        $photo = factory(App\Photo::class)->make([
            'upload_file' => null
        ]);

        $file = $this->getUploadedFile();

        $photo->upload_file = $file;

        $photo->save();

        $this->assertFileExists($photo->image_path);
        $this->assertFileExists($photo->thumb_path);

        $photo->save();

        $this->assertFileExists($photo->image_path);
        $this->assertFileExists($photo->thumb_path);

        $oldFilePath = $photo->image_path;
        $oldThumbPath = $photo->thumb_path;

        $photo->image_file = null;
        $photo->thumb_file = null;

        $photo->save();

        $this->assertNull($photo->image_path);
        $this->assertNull($photo->thumb_path);

        $this->assertFileNotExists($oldFilePath);
        $this->assertFileNotExists($oldThumbPath);
    }

    /**
     * @return \Illuminate\Http\UploadedFile
     */
    protected function getUploadedFile()
    {
        $filePath = base_path('tests/tmp/image.jpg');

        return new \Illuminate\Http\UploadedFile($filePath, basename($filePath), 'image/jpeg', File::size($filePath));
    }
}