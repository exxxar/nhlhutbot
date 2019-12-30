<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class OverallConversation extends Conversation
{
    use CustomConversation;
    protected $bot;

    public function __construct($bot)
    {
        $this->bot = $bot;
    }
    /**
     * Start the conversation.
     *
     * @return mixed
     */

    public function run()
    {
        $this->minOverall();
    }

    public function minOverall(){
        $this->ask('Минимальное значение', function ( Answer $answer) {

                $overall = $answer->getText();


                $this->bot->userStorage()->save([
                    "overall_min" => strlen(trim($overall)) == 0 ? null : $overall
                ]);

                $this->bot->reply("Значение " . $this->bot->userStorage()->get("overall_min") . " установлено!");

                $this->maxOverall();


        });
    }
    public function maxOverall(){
        $this->ask('Максимальное значние', function ( Answer $answer) {


                $overall = $answer->getText();


                $this->bot->userStorage()->save([
                    "overall_max" => strlen(trim($overall)) == 0 ? null : $overall
                ]);

                $this->bot->reply("Значение " . $this->bot->userStorage()->get("overall_max") . " установлено!");

                $this->filterMenu("Обновлен фильтр");

        });
    }
}
