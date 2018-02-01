<?php
/**
 * PHP_MAUMAU - A non-interactive PHP version of the game mau mau (pesten)
 *
 * @package 	PHP_MAUMAU
 * @author      Deniz Tezcan <howdy@deniztezcan.me>
 * @link        https://github.com/deniztezcan/PHP_MAUMAU
 */

include_once "Deck.php";
include_once "Player.php";
include_once "Stack.php";

class Application
{
	
	private $deck;
	private $players;
	private $stack;
	private $status;

	public function __construct()
	{
		$this->initializeDeck();
		$this->initializePlayers();
		$this->initializeStack();
		$this->initializeStatus();
	}

	private function initializeDeck()
	{
		$this->deck = new Deck();
		$this->deck->shuffle();
	}

	private function initializePlayers()
	{
		$this->players = array();
		$this->players[] = new Player('Churchill');
		$this->players[] = new Player('Stalin');
		$this->players[] = new Player('Roosevelt');
		$this->players[] = new Player('de Gaulle');
	}

	private function listPlayers()
	{
		$returnString = "Starting game with";

		foreach ($this->players as $player) {
			$returnString.= " ".$player->getName().",";
		}

		$returnString = rtrim($returnString, ",");
		$returnString.= "<br>";

		return $returnString;

	}

	private function initializeStack()
	{
		$this->stack = new Stack();
	}

	private function initializeStatus()
	{
		$this->status = false;
	}

	private function initialDealing()
	{
		foreach($this->players as $index => $player)
		{
			for($cardIndex = 0; $cardIndex < 7; $cardIndex++)
			{
				$this->players[$index]->addToHand($this->deck->dealCard());
			}
		}
	}

	private function listInitialDealings()
	{
		$returnString = "";
		foreach($this->players as $index => $player)
		{
			$returnString.= $player->getName()." has been dealt:";

			foreach ($this->players[$index]->getHand() as $card) {
				$returnString.= " ".$card->getCard().",";
			}

			$returnString = rtrim($returnString, ",");
			$returnString.= "<br>";
		}
		return $returnString;
	}

	private function canPlay(
		$stackCard,
		$hand
	){
		foreach ($hand as $cardIndex => $card) {

			if(
				$stackCard->getSuit() == $card->getSuit()
			){
				return array("index" => $cardIndex, "card" => $card);
			}elseif(
				$stackCard->getValue() == $card->getValue()
			){
				return array("index" => $cardIndex, "card" => $card);
			}

		}

		return false;
	}

	private function play(
		$index,
		$player
	){

		$stackCard 	= $this->stack->getTopStackCard();
		$canPlay	= $this->canPlay($stackCard, $player->getHand());

		if(
			!$canPlay
		){	
			$newCard = $this->deck->dealCard();
			$this->players[$index]->addToHand($newCard);
			echo $player->getName()." does not have a suitable card. taking from deck ".$newCard->getCard()."<br>";
		}else
		{
			$this->stack->addToStack($canPlay['card']);
			$player->removeFromHand($canPlay['index']);
			echo $player->getName()." plays ".$canPlay['card']->getCard()."<br>";
		}

	}

	private function restOfGame()
	{
		while(!$this->status){
			foreach ($this->players as $index => $player) {
				if($player->countHand() > 0) {
					$this->play($index, $player);
					if($player->countHand() == 0) 
					{
						echo $player->getName()." has won.";	
						$this->status = true;
						break;
					}
				}
			}
		}	
	}

	public function startGame()
	{
		
		echo $this->listPlayers();
		$this->initialDealing();
		echo $this->listInitialDealings();
		$this->stack->addToStack($this->deck->dealCard());
		echo $this->stack->listTopStackCard();
		$this->restOfGame();

	}

}