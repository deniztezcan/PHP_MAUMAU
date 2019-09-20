<?php

namespace DenizTezcan\MauMau;

class Deck extends Collection
{
	/**
     * Class properties
     */

	/**
     * Array of possiple suits
     *
     * @type Array
     */
    protected $suits = [
    	"&hearts;",
		"&spades;",
		"&diams;",
		"&clubs;"
    ];

	/**
     * Array of possiple values
     *
     * @type Array
     */
    protected $values = [
    	"A",
		"K",
		"Q",
		"J",
		"10",
		"9",
		"8",
		"7",
		"6",
		"5",
		"4",
		"3",
		"2"
    ];

    /**
     * Methods
     */
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        foreach ($this->suits as $suit) {
        	foreach ($this->values as $value) {
        		$card = new Card($suit, $value);
        		$this->set($card->getKey(), $card);
        	}
        }
    }

     /**
     * Shuffles the array to make it more random
     *
     * @return void
     */
    public function shuffle(): void
    {
    	$keys = array_keys($this->attributes); 
		shuffle($keys); 
		$random = array(); 
		
		foreach ($keys as $key) { 
			$random[$key] = $this->attributes[$key]; 
		}
		
		$this->attributes = $random; 
    }

	/**
	* Deals a card
	*
	* @return Card
	*/
	public function deal(): object
	{
		$card = reset($this->attributes);
		$this->remove($card->getKey());
		return $card;	
	}

	/**
	* Add a card to the Deck
	*
	* @param  Card
	* @return void
	*/
	public function add(Card $card): void
	{
		$this->set($card->getKey(), $card);
	}

}