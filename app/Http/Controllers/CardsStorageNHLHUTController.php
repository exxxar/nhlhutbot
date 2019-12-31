<?php

namespace App\Http\Controllers;

use App\CardsStorageNHLHUT;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CardsStorageNHLHUTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $index = 0;
        echo "Cards upload start<br/>";
        Log::info("Cards upload start");

        ini_set('max_execution_time', 100000000);

        while (true) {
            $query = "draw=5&start=$index&length=20";


            try {
                $context = stream_context_create(array(
                    'http' => array(
                        'method' => 'POST',
                        'header' => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
                        'content' => $query
                    ),
                ));

                echo "Cards url prepare<br/>";
                Log::info("Cards url prepare");

                $content = file_get_contents(
                    $file = 'https://nhlhutbuilder.com/php/player_stats.php',
                    $use_include_path = false,
                    $context);


            } catch (ErrorException $e) {
                $content = [];
                echo "Ошибка загрзуки<br/>";
                Log::info("Ошибка загрзуки");
            }

            $cards = json_decode($content, true)["data"];


            echo "Cards count " . count($cards);
            if (count($cards) == 0)
                break;

            foreach ($cards as $key => $c) {
                echo "Parse cards<br/>";
                $start = strpos($c["card_art"], '<img src="') + 10;
                $end = strpos($c["card_art"], '" width');
                $path = substr($c["card_art"], $start, $end - $start);
                $imgUrl = 'https://nhlhutbuilder.com/' . $path;

                try {
                    $pattern = "/([0-9]+)/";

                    preg_match_all($pattern, $path, $matches);

                    $cardId = $matches[1][0];


                    $content = file_get_contents($imgUrl);
                    //file_put_contents("/$cardId.jpg", $content);

                    Storage::put("/public/$cardId.jpg", $content);

                    Log::info("Карточка $cardId.jpg сохранена");
                } catch (\Exception $e) {
                    Log::info("Ошибка сохранения карточки");
                }

                try {
                    $card = CardsStorageNHLHUT::create($c);
                    $card->hutid = $cardId;
                    $card->save();
                } catch (\Exception $e) {

                    echo "Ошибка добавления карты: карта уже есть в базе данных<br/>";
                    Log::info("Ошибка добавления карты: карта уже есть в базе данных");
                }

            }

            Log::info("Загрузка $index завершена");

            $index+=20;

        }

        ini_set('max_execution_time', 60);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\CardsStorageNHLHUT $cardsStorageNHLHUT
     * @return \Illuminate\Http\Response
     */
    public function show(CardsStorageNHLHUT $cardsStorageNHLHUT)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\CardsStorageNHLHUT $cardsStorageNHLHUT
     * @return \Illuminate\Http\Response
     */
    public function edit(CardsStorageNHLHUT $cardsStorageNHLHUT)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\CardsStorageNHLHUT $cardsStorageNHLHUT
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CardsStorageNHLHUT $cardsStorageNHLHUT)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CardsStorageNHLHUT $cardsStorageNHLHUT
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardsStorageNHLHUT $cardsStorageNHLHUT)
    {
        //
    }
}
