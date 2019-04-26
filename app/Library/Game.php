<?php

namespace App\Library;

class Game {
	
	private $players = null;
	private $deck = null;
	private $slot = [];
	private $turn = 1;
	private $stack = 0;
	private $limit = 10;

	public function __construct(array $players, int $slots) {
		
		$this->openSlots($slots);

		foreach ($players as $player) {
			$this->setPlayer($player);
		}
	}

	private function openSlots(int $slots) {
		
		for($i=0;$i<$slots;$i++) {
			$this->slot[$i] = null;
		}

		return $this->slot;
	}

	private function setPlayer(Player $player) {
		$this->players[] = $player;
		$this->setPlayerSlot($player);
	}

	public function playerCount() {
		return count($this->players);
	}

	public function slotCount() {
		return count($this->slot);
	}

	private function setPlayerSlot(Player $player) {

		for($i=0;$i<count($this->slot);$i++) {

			if(empty($this->slot[$i])) {
				$this->slot[$i] = $player;
				return;
			}
		}

		echo  "The slots is full";

	}

	public function createDeck() {
		$deck = null;

        $cards = Card::createXCards(10, "Zero", 0);
        $deck = $cards;

        $cards = Card::createXCards(10, "Um", 1);
        $deck = array_merge_recursive($deck, $cards);
        $cards = Card::createXCards(10, "Dois", 2);
        $deck = array_merge_recursive($deck, $cards);
        $cards = Card::createXCards(10, "Tres", 3);
        $deck = array_merge_recursive($deck, $cards);

        return $deck;
	}

	public function setDeck(Deck $deck) {
		$this->deck = $deck;
	}

	public function  getDeck() {
		return $this->deck;
	}

	public function begin() {

		$key_player_first = $this->playFirst();

		foreach($this->slot as $idx => $key) {
			if($key_player_first != $idx)
				next($this->slot);
		}

		$this->setCurrentPlayer(current($this->slot));

		foreach($this->slot as $slot) {
			$slot->draw(4, $this->deck);
		}

		dump("Player ".$this->currentPlayer->getName()." plays first");
	}

	public function play() {

		dump("Player ".$this->currentPlayer->getName()." playing in turn ".$this->turn);

		$this->currentPlayer->intention($this);

		if($this->over()) {
			dump("This game is over, ".$this->currentPlayer->getName(). " loses because reach ".$this->stack." points");
		}
	}

	public function passTurn() {

		dump("End of turn ".$this->turn);

		$this->setCurrentPlayer($this->nextPlayer());


		$this->turn++;
	}

	public function playCard(Player $player, Card $card) {
		dump("Player ".$player->getName()." play ".$card->getSize());
		$this->setStack($this->getStack()+$card->getSize());
	}

	public function setCurrentPlayer(Player $player) {
		if(@$this->currentPlayer)
			dump("Changing Player ".$this->currentPlayer->getName()." to ".$player->getName());
		else
			dump("Starting with ".$player->getName());

		$this->currentPlayer = $player;
	}

	public function nextPlayer() {

		dump("Changing Player ".current($this->slot)->getName());

		$next = next($this->slot);


		if($next !== false) {
			dump("To Player ".current($this->slot)->getName());
			return $next;
		} else {
			reset($this->slot);

			$next = current($this->slot);
		}

		return $next;
	}

	private function playFirst() {
		$first = rand(0,($this->slotCount())-1);

		return $first;
	}

	public function debug() {
		echo "Current slot: ";dump(current($this->slot));
	}

	public function getTurn() {
		return $this->turn;
	}


    /**
     * @return mixed
     */
    public function getStack()
    {
        return $this->stack;
    }

    /**
     * @param mixed $stack
     *
     * @return self
     */
    public function setStack($stack)
    {
        $this->stack = $stack;

        dump("Stack: ".$stack);

        return $this;
    }

    public function over() {
    	if($this->stack > 10) {
    		dump("GAME OVER");
    		return true;
    	}

    	return false;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     *
     * @return self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }
}
