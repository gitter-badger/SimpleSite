<?php

namespace App\Helpers;

use Parsedown;

class MarkdownParser extends Parsedown
{

    /**
     * @param string $text
     *
     * @return array [string $text, string $textIntro]
     */
    public static function parseText($text)
    {
        $parser = new static;

        $pattern = "/<cut>(.*?)<\\/cut>/si";
        preg_match($pattern, $text, $matches);

        if (! empty($matches)) {
            list($textIntro, $text) = preg_split($pattern, $text, 2);
        } else {
            $textIntro = '';
        }

        if (! empty($textIntro)) {
            $textIntro = $parser->text($textIntro);
        }

        $text = $parser->text($text);

        return [$text, $textIntro];
    }

    /**
     * @param array $Element
     *
     * @return null|string
     */
    protected function element(array $Element)
    {
        if (is_array($Element) and is_string($Element['name'])) {

            $method = 'customElement'.ucfirst($Element['name']);

            if (method_exists($this, $method)) {
                $Element = $this->$method($Element);

                if (is_null($Element)) {
                    return null;
                }
            }
        }

        return parent::element($Element);
    }
}