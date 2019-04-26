<?php

namespace App\Library;

class Card {
	
	private $name = "";
	private $size = null;

	public function __construct(String $name, int $size) {

		$this->name = $name;
		$this->size = $size;

		return $this;
	}

	public static function createXCards(int $x, String $name, int $size) {

		$cards = array();

		for ($i=0;$i<$x;$i++) {
			array_push($cards, new Card($name, $size));
		}

		return $cards;
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

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     *
     * @return self
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }
}