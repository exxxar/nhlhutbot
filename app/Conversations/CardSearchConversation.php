<?php

namespace App\Conversations;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;
use ErrorException;
use Illuminate\Support\Facades\Log;

class CardSearchConversation extends Conversation
{

    use CustomConversation;

    protected $bot;

    public function __construct(BotMan $bot)
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
        $this->mainMenu("Поиск карточек NHL 2020");


    }

    private function allCards(){
        $this->bot->reply("All");

        try {
            $context = stream_context_create(array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
                    'content' => 'draw=5&start=0&length=10'
                ),
            ));
            $content =  file_get_contents(
                $file = 'https://nhlhutbuilder.com/php/player_stats.php',
                $use_include_path = false,
                $context);

        } catch (ErrorException $e) {
            $content = [];
        }

        foreach ($content as $c)
            Log::info(print_r($c,true));

        $this->bot->reply("Success [".count($content)."]");
    }

    private function searchCard(){
        $this->bot->reply("Search");
    }
    private function about(){
        $this->bot->reply("About");
    }
}
