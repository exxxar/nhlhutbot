<?php
/**
 * Created by PhpStorm.
 * User: exxxa
 * Date: 24.11.2019
 * Time: 20:57
 */

namespace App\Conversations;


use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;


trait CustomConversation
{
    protected $keyboard = [
        ["Все карточки"],
        ["Фильтр карточек"],
        ["Как пользоваться"],

    ];

    protected $keyboard_fallback = [
        ["Попробовать снова"],
    ];

    protected $keyboard_conversation = [
        ["Продолжить позже"],
    ];

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

        $nationality = $this->bot->userStorage()->get("nationality") ?? null;
        $position = $this->bot->userStorage()->get("position") ?? null;
        $hand =$this->bot->userStorage()->get("hand") ?? null;

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
            ["Применить фильтр"],
            ["Player Name" . ($full_name == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Player Type" . ($ptype == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
            ["Card Type" . ($card == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Synergy" . ($synergies == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
            ["League" . ($league == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Team" . ($team == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
            ["Nationality" . ($nationality == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Overall" . ($overall == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
            ["Height Min" . ($height_min == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"),"Height Max" . ($height_max == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85") ],
            ["Weight" . ($weight == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85") ],
            ["Position" . ($position == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Hand" . ($hand == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
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

    public function createUser($telegram_user) {

        $id = $telegram_user->getId();

        $username = $telegram_user->getUsername();
        $lastName = $telegram_user->getLastName();
        $firstName = $telegram_user->getFirstName();

        $user = \App\User::create([
            'name' => $username??"$id",
            'email' => "$id@t.me",
            'password' => bcrypt($id),
            'fio_from_telegram' => "$firstName $lastName",
            'source' => "000",
            'telegram_chat_id' => $id,
            'referrals_count' => 0,
            'referral_bonus_count' => 10,
            'cashback_bonus_count' => 0,
            'is_admin' => false,
        ]);

        return $user;
    }

    private function menu($message,$keyboard){
        $this->bot->sendRequest("sendMessage", [
            "text" => $message,
            'reply_markup' => json_encode([
                'keyboard' => $keyboard,
                'one_time_keyboard' => false,
                'resize_keyboard' => true
            ])
        ]);
    }

    public function mainMenu($message){
        $this->menu($message,$this->keyboard);
    }

    public function fallbackMenu($message){
        $this->menu($message,$this->keyboard_fallback);
    }

    public function conversationMenu($message){
        $this->menu($message,$this->keyboard_conversation);
    }

    public function mainMenuWithAdmin($message){
        $this->menu($message,$this->keyboard_admin);
    }

}