<?php

namespace App\Helpers;

use App\User;
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

        return [$text, $textIntro, $parser->getMentionedUsers()];
    }

    /**
     * MarkdownParser constructor.
     */
    public function __construct()
    {
        $this->InlineTypes['@'] = ['userMention'];
        $this->inlineMarkerList .= '@';
        $this->mentionedUsers = [];
    }

    /**
     * @var array
     */
    protected $mentionedUsers = [];

    /**
     * @return array
     */
    public function getMentionedUsers()
    {
        return $this->mentionedUsers;
    }

    /**
     * @param array $Excerpt
     *
     * @return array
     */
    protected function inlineUserMention(array $Excerpt)
    {
        if (preg_match('/\@\{([а-яёА-ЯЁa-zA-Z ]+)(\|([а-яёА-ЯЁa-zA-Z ]+))?\}/iu', $Excerpt['text'], $matches)) {
            if (! empty($matches[1])) {
                $user = User::where('display_name', 'like', "%{$matches[1]}%")->orWhere('name', 'like', "%{$matches[1]}%")->first();
                if(! is_null($user)) {

                    $this->mentionedUsers[] = $user->id;

                    return [
                        'extent' => strlen($matches[0]),
                        'element' => [
                            'name' => 'a',
                            'text' => $user->getNameWithAvatarAttribute(array_get($matches, 3)),
                            'attributes' => [
                                'href' => route('user.profile', [$user->id]),
                                'target' => '_blank'
                            ],
                        ],
                    ];
                }

            }
        }
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