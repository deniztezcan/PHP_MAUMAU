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
	private $gameFinished;
	private $losers;

	public function __construct()
	{
		$this->initializeDeck();
		$this->initializePlayers();
		$this->initializeStack();
		$this->initializeStatus();
		$this->initializeLosers();
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

	private function initializeStack()
	{
		$this->stack = new Stack();
	}

	private function initializeStatus()
	{
		$this->gameFinished = false;
	}

	private function initializeLosers()
	{
		$this->losers = array();
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

	private function listWinner(
		$player
	){
		return $player->getName()." has won.";	
	}

	private function setGameFinished(
		$newStatus
	){
		$this->gameFinished = $newStatus;
	}

	private function setLoser(
		$player
	){
		if($this->countLosers() == 0)
		{
			$this->losers[] = $player;
			return;
		}else
		{
			$foundPlayer = false;

			foreach ($this->losers as $losingPlayer)
			{				

				if($losingPlayer == $player)
				{
					$foundPlayer = true;
				}

			}

			if($foundPlayer)
			{
				return;
			}else
			{
				$this->losers[] = $player;
				return;
			}

		}
	}

	private function removeLosers()
	{
		$this->initializeLosers();
	}

	private function countLosers()
	{
		return count($this->losers);
	}

	private function countPlayers()
	{
		return count($this->players);
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
			if(!$this->deck->isEmpty())
			{
				$newCard = $this->deck->dealCard();
				$this->players[$index]->addToHand($newCard);
				echo $player->getName()." does not have a suitable card. taking from deck ".$newCard->getCard()."<br>";
			}else
			{
				if($this->countLosers() == $this->countPlayers())
				{
					echo "No cards left in deck. There is no winner :(<br>";
					$this->setGameFinished(true);
					exit;
				}else
				{
					$this->setLoser($player);
					echo $player->getName()." does not have a suitable card. Deck is empty - skipping turn<br>";
					return;
				}
			}	
		}else
		{
			$this->stack->addToStack($canPlay['card']);
			$player->removeFromHand($canPlay['index']);
			$this->removeLosers();
			echo $player->getName()." plays ".$canPlay['card']->getCard()."<br>";
		}

	}

	private function restOfGame()
	{
		while(!$this->gameFinished){
			foreach ($this->players as $index => $player) {
				if($player->countHand() > 0) {
					$this->play($index, $player);
					if($player->countHand() == 0) 
					{
						echo $this->listWinner($player);
						$this->setGameFinished(true);
						exit;
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