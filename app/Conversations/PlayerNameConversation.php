<?php

namespace App\Conversations;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class PlayerNameConversation extends Conversation
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
        //

        $this->ask('Введите имя игрока', function ( Answer $answer) {

            if ($answer->isInteractiveMessageReply()) {
                $full_name = $answer->getText();


                $this->bot->userStorage()->save([
                    "full_name" => strlen(trim($full_name)) == 0 ? null : $full_name
                ]);

                $this->bot->reply("Значение " . $this->bot->userStorage()->get("full_name") . " установлено!");

                $this->filterMenu("Обновлен фильтр");
            }

        });
    }
}
