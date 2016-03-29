<?php

namespace App\Helpers;

use Illuminate\Pagination\BootstrapThreePresenter;
use Illuminate\Support\HtmlString;

class SemanticUIPresenter extends BootstrapThreePresenter
{
    /**
     * Convert the URL window into Bootstrap HTML.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function render()
    {
        if ($this->hasPages()) {
            return new HtmlString(sprintf(
                '<div class="ui pagination menu">%s %s %s</div>',
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton()
            ));
        }

        return '';
    }

    /**
     * Get HTML wrapper for an available page link.
     *
     * @param  string      $url
     * @param  int         $page
     * @param  string|null $rel
     *
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="'.$rel.'"';

        return '<a class="item" href="'.htmlentities($url).'"'.$rel.'>'.$page.'</a>';
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string $text
     *
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return '<div class="disabled item">'.$text.'</div>';
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param  string $text
     *
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<a class="active item">'.$text.'</a>';
    }
}