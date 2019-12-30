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
        ["Поиск карточек"],
        ["Как пользоваться"],

    ];

    protected $keyboard_fallback = [
        ["Попробовать снова"],
    ];

    protected $keyboard_conversation = [
        ["Продолжить позже"],
    ];

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