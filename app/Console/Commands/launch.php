<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\Player;
use App\Library\Game;
use App\Library\Card;
use App\Library\Deck;

class launch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:launch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launch Command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        // $arr = ["Um", "Dois", "Três"];

        // $result= array_shift($arr);
        // dump($arr);
        // dd($result);

        $players[] = new Player("Teferi");
        $players[] = new Player("Jace");
        $players[] = new Player("Ajani");

        $game = new Game($players, 3);
        $deck = new Deck($game->createDeck());

        $game->setDeck($deck);

        $game->getDeck()->shuffle();

        $game->begin();
        
        while ($game->getTurn() <= 10 && !$game->over()) {

            // dump("Player ".$game->currentPlayer->getName()." turn:".$game->getTurn()."/ cards in hand: ".$game->currentPlayer->totalCardsInHand());

            echo $game->currentPlayer->getName()." Cards in hand: \n";
            foreach($game->currentPlayer->cardsInHand() as $card) {

                dump($card->getSize());
            }

            $game->play();

            if($game->over())
                break;

            echo $game->currentPlayer->getName()." Cards in hand in the end of turn: \n";
            foreach($game->currentPlayer->cardsInHand() as $card) {
                dump($card->getSize());
            }

            $game->passTurn();
        }

        // dump($game);

    }
}
