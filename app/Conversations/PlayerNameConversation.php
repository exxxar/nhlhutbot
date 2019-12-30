<?php

namespace App\Conversations;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class PlayerNameConversation extends Conversation
{

    protected $bot;

    public function filterMenu( $message)
    {
        $telegramUser = $this->bot->getUser();
        $id = $telegramUser->getId();

        $full_name = $this->bot->userStorage()->get("full_name") ?? null;
        $card = $this->bot->userStorage()->get("card") ?? null;
        $ptype = $this->bot->userStorage()->get("ptype") ?? null;
        $synergies = $this->bot->userStorage()->get("synergies") ?? null;
        $league = $this->bot->userStorage()->get("league") ?? null;
        $team = $this->bot->userStorage()->get("team") ?? null;
        $nationality = $this->bot->userStorage()->get("nationality") ?? null;

        $overall_min = $this->bot->userStorage()->get("overall_min") ?? null;
        $overall_max = $this->bot->userStorage()->get("overall_max") ?? null;

        $overall = ($overall_min || $overall_max) ?? null;

        $height_min = $this->bot->userStorage()->get("height_min") ?? null;
        $height_max = $this->bot->userStorage()->get("height_max") ?? null;

        $height = ($height_min || $height_max) ?? null;

        $weight_min = $this->bot->userStorage()->get("weight_min") ?? null;
        $weight_max = $this->bot->userStorage()->get("weight_max") ?? null;

        $weight = ($weight_min || $weight_max) ?? null;

        $keyboard = [
            ["Player Name" . ($full_name == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Player Type" . ($ptype == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
            ["Card Type" . ($card == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Synergy" . ($synergies == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
            ["League" . ($league == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Team" . ($team == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
            ["Nationality" . ($nationality == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Overall" . ($overall == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
            ["Height" . ($height == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Weight" . ($weight == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
            ["Сбросить фильтр"],
            ["Главное меню"],
        ];


        $this->bot->sendRequest("sendMessage",
            [
                "chat_id" => "$id",
                "text" => $message,
                "parse_mode" => "Markdown",
                'reply_markup' => json_encode([
                    'keyboard' => $keyboard,
                    'one_time_keyboard' => false,
                    'resize_keyboard' => true
                ])

            ]);
    }

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

            $full_name = $answer->getText();


            $this->bot->userStorage()->save([
                "full_name" => strlen(trim($full_name)) == 0 ? null : $full_name
            ]);

            $this->bot->reply("Значение ".$this->bot->userStorage("full_name")." установлено!");


        });
    }
}
