<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Ddeboer\Imap\Connection;
use Ddeboer\Imap\Message;
use Ddeboer\Imap\Search\Flag\Unseen;
use Ddeboer\Imap\SearchExpression;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CheckEmail extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:email';

    public function handle()
    {
        /** @var Connection $imap */
        $imap = app('imap');

        $mailbox = $imap->getMailbox('ITProtect');

        $search = new SearchExpression();

        /** @var Message[] $messages */
        $messages = $mailbox->getMessages($search->addCondition(new Unseen()));

        foreach ($messages as $i => $message) {
            $this->analyzeMessage($imap, $message);
        }
    }

    /**
     * @param Connection $imap
     * @param Message $message
     */
    protected function analyzeMessage($imap, Message $message)
    {
        $subject = $message->getSubject();
        $body = $message->getBodyText();

        $text = $subject.$body;

        $isDisease = false;
        $isHoliday = false;

        if (preg_match('/(отпуск)/iu', $text)) {
            $range = null;
        } else if (preg_match('/(отсутст|удалё|работа([ \-]+)?удал(е|ё)нно|вне([ \-]+)?офис)/iu', $text)) {
            $dateStart = Carbon::now()->setTime(9, 0);
            $dateEnd = Carbon::now()->setTime(18, 0);

            if (preg_match('/((\d){2}.(\d){2}.(\d){2,4})/u', $subject, $matches)) {
                $dateStart = Carbon::parse($matches[1]);
            }

            if (preg_match('/завтр/u', $text)) {
                $dateStart = $dateStart->tomorrow();
                $dateEnd = $dateEnd->tomorrow();
            }

            if (preg_match('/до ((\d){2}(.|:)(\d){2})/u', $text, $matches)) {
                $dateEnd = $dateEnd->setTimeFromTimeString(str_replace('.', ':', $matches[1]));
            }

            dd($subject, $dateStart, $dateEnd);
        }

        //imap_setflag_full($imap->getResource(), $message->getNumber(), "\\Seen \\Flagged", ST_UID);
    }
}