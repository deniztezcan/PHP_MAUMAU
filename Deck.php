<?php
/**
 * PHP_MAUMAU - A non-interactive PHP version of the game mau mau (pesten)
 *
 * @package 	PHP_MAUMAU
 * @author      Deniz Tezcan <howdy@deniztezcan.me>
 * @link        https://github.com/deniztezcan/PHP_MAUMAU
 */

include_once "Card.php";

class Deck
{
	
	private $suits;
	private $values;

	public 	$cards;

	public function __construct()
	{
		$this->initializeSuits();
		$this->initializeValues();
		$this->initializeCards();
		$this->initializeDeck();
	}

	private function setCard(
		$suit,
		$value
	){
		$this->cards[] = new Card($suit, $value);
	}

	private function initializeSuits()
	{
		$this->suits = array(
			"hearts" 	=> "&hearts;",
			"spades" 	=> "&spades;",
			"diamonds" 	=> "&diams;",
			"clubs" 	=> "&clubs;"
		);
	}

	private function initializeValues()
	{
		$this->values = array(
			"ace" 	=> "A",
			"king" 	=> "K",
			"queen" => "Q",
			"jack" 	=> "J",
			"ten" 	=> "10",
			"nine" 	=> "9",
			"eight" => "8",
			"seven" => "7",
			"six" 	=> "6",
			"five" 	=> "5",
			"four" 	=> "4",
			"three" => "3",
			"two" 	=> "2"
		);
	}

	private function initializeCards()
	{
		$this->cards = array();
	}

	private function initializeDeck()
	{

		foreach($this->suits as $suit)
		{
			foreach($this->values as $value)
			{
				$this->setCard($suit, $value);
			}
		}

	}

	public function shuffle()
	{

		shuffle($this->cards);
	}

	public function count()
	{

		return count($this->cards);
	}

	public function addToDeck(
		$card
	){
		$this->cards[] = $card;
	}

	public function removeFromDeck(
		$index
	){
		unset($this->cards[$index]);
		$this->cards = array_values($this->cards);
	}	

	public function dealCard(){
		$cardInHand = $this->cards[0];
		$this->removeFromDeck(0);
		return $cardInHand;
	}
	
}