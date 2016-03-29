<?php

class BlogTest extends TestCase
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
            'title' => 'Test title',
            'text_source' => $source
        ]);

        list($text, $textIntro) = \App\Helpers\MarkdownParser::parseText($blog->text_source);

        $this->assertEquals($blog->text_source, trim($source));
        $this->assertEquals($blog->text_intro, $textIntro);
        $this->assertEquals($blog->text, $text);
    }
}