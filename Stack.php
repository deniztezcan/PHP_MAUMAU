<?php
/**
 * PHP_MAUMAU - A non-interactive PHP version of the game mau mau (pesten)
 *
 * @package 	PHP_MAUMAU
 * @author      Deniz Tezcan <howdy@deniztezcan.me>
 * @link        https://github.com/deniztezcan/PHP_MAUMAU
 */


class Stack
{
	
	private $stack;

	public function __construct()
	{
		$this->initializeStack();
	}

	private function initializeStack()
	{
		$this->stack = array();
	}

	public function addToStack(
		$card
	){
		$this->stack[] = $card;
	}

	public function getTopStackCard()
	{
		$count = count($this->stack);
		return $this->stack[$count-1];
	}

	public function listTopStackCard()
	{	
		$card = $this->getTopStackCard();
		$returnString = "Top card is: ".$card->getCard()."<br>";
		return $returnString;
	}

}