<?php

class PostTest extends TestCase
{

    public function testTextParser()
    {
        $source = <<<EOS
An h1 header
============

Paragraphs are separated by a blank line.
<cut></cut>
2nd paragraph. *Italic*, **bold**, and `monospace`. Itemized lists look like:

  * this one
  * that one
  * the other one

Note that --- not considering the asterisk --- the actual text content starts at 4-columns in.
EOS;

        $blog = new \App\Post([
            'title'       => 'Test title',
            'text_source' => $source
        ]);

        list($text, $textIntro) = \App\Helpers\MarkdownParser::parseText($blog->text_source);

        $this->assertEquals($blog->text_source, trim($source));
        $this->assertEquals($blog->text_intro, $textIntro);
        $this->assertEquals($blog->text, $text);
    }

    public function testPostTitle()
    {
        $title = " Test title\t";
        $blog  = new \App\Post([
            'title' => $title
        ]);

        $this->assertEquals($blog->title, trim($title));
    }

    public function testFileUpload()
    {
        /** @var App\Post $photo */
        $post = factory(App\Post::class)->make();

        $filePath = base_path('tests/tmp/image.jpg');

        $file = new \Illuminate\Http\UploadedFile($filePath, basename($filePath), 'image/jpeg', File::size($filePath));

        $post->image_file = $file;

        $post->save();

        $oldFilePath = $post->image_path;
        $this->assertFileExists($post->image_path);

        $post->image_file = $file;
        $post->save();

        $this->assertFileNotExists($oldFilePath);

        $oldFilePath = $post->image_path;

        $post->delete();

        $this->assertFileNotExists($oldFilePath);
    }
}