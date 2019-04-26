<?php

namespace App\Library;

class Player {
	
	private $name = "Player 1";
	private $hand = array();

	public function __construct(String $name) {

		$this->name = $name;

		return $this;
	}

	public function draw(int $x=1, Deck $deck) {

		for($i=0;$i<$x;$i++){
			$shifted = $deck->getFirstCard();
			array_push($this->hand, $shifted);
		}

		return $i;
	}

	public function totalCardsInHand() {
		return count($this->hand);
	}

	public function cardsInHand() {
		return $this->hand;
	}

	public function intention(Game $game) {

		// if($game->getStack() < 3) {
		// 	dump("Jogar uma carta grande");

			if($this->name == "Teferi") {
				// teferi irá usar um modo diferente de jogo
				$using_card = $this->getBetterCardInHand($game);
			} else {
				$using_card = $this->getBiggerCardInHand();
			}

			if(!$using_card) {
				dump("Player ".$this->name." has no cards in hand anymore!");
				return;
			}

			$card = current($using_card);

			$predict = $card->getSize()+$game->getStack();

			if($predict > 10) {
				echo "####  Vou perder #######\n";
			}

			// confirma baixar a carta
			$this->removeCardFromHand(key($using_card));
			$game->playCard($this, current($using_card));
		// } elseif ($game->getStack() > 6) {
		// 	dump("Jogar uma carta media");
		// } else {
		// 	dump("Jogar uma carta baixa");
		// }

		dump($game->getStack());

	}

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getBiggerCardInHand() {
    	
    	$bigger_card = null;
    	$bigger_index = false;

    	foreach ($this->hand as $key => $card) {

    		if(!$bigger_card) {
    			$bigger_index = $key;
    			$bigger_card = $card;
    		}

    		if($bigger_card->getSize() < $card->getSize()) {
    			$bigger_index = $key;
    			$bigger_card = $card;
    		}
    	}

    	if($bigger_index === false) {
    		return $bigger_index;
    	}

      	return [$bigger_index => $bigger_card];

    }

    public function getBetterCardInHand(Game $game) {

    	$bigger_index = false;
    	
    	foreach ($this->hand as $key => $card) {

    		$predict = $game->getStack() + $card->getSize();

    		if($predict > $game->getLimit()) {
    			echo "[".$card->getSize()."] Se eu jogar esta, vou perder, melhor escolher outra.\n";

    			if($this->cardsInHand() == 1) {
    				echo "[".$card->getSize()."] Mas não tem jeito\n";
    				$bigger_index = $key;
    				$bigger_card = $card;

    				break;
    			}
    			continue;
    		} else {
    			echo "[".$card->getSize()."] Ok, não vou estourar, posso jogar essa\n";

    			$bigger_index = $key;
    			$bigger_card = $card;
    		}
    	}

    	if($bigger_index === false) {
    		return $bigger_index;
    	}

      	return [$bigger_index => $bigger_card];

    }

    public function removeCardFromHand(int $index) {
    	unset($this->hand[$index]);
    }
}