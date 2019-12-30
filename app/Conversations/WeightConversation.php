<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class WeightConversation extends Conversation
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
        $this->minWeight();
    }

    public function minWeight(){
        $this->ask('Минимальное значение', function ( Answer $answer) {

                $weight = $answer->getText();


                $this->bot->userStorage()->save([
                    "weight_min" => strlen(trim($weight)) == 0 ? null : $weight
                ]);

                $this->bot->reply("Значение " . $this->bot->userStorage()->get("weight_min") . " установлено!");

                $this->filterMenu("Обновлен фильтр");

                $this->maxWeight();


        });
    }
    public function maxWeight(){
        $this->ask('Максимальное значние', function ( Answer $answer) {


                $weight = $answer->getText();


                $this->bot->userStorage()->save([
                    "weight_max" => strlen(trim($weight)) == 0 ? null : $weight
                ]);

                $this->bot->reply("Значение " . $this->bot->userStorage()->get("weight_max") . " установлено!");

                $this->filterMenu("Обновлен фильтр");

        });
    }
}
