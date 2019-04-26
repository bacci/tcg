<?php

namespace App\Library;

class Deck {
	
	private $cards = array();

	public function __construct(array $cards) {

		$this->cards = $cards;

		return $this;
	}

	public function shuffle() {

		shuffle($this->cards);

	}

	public function getCards() {
		return $this->cards;
	}

	public function getFirstCard() {
		$shift = array_shift($this->cards);
		return $shift;
	}

	public function cardsInDeck() {
		return count($this->cards);
	}
}