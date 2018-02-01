<?php
/**
 * PHP_MAUMAU - A non-interactive PHP version of the game mau mau (pesten)
 *
 * @package 	PHP_MAUMAU
 * @author      Deniz Tezcan <howdy@deniztezcan.me>
 * @link        https://github.com/deniztezcan/PHP_MAUMAU
 */

class Player
{
	
	private $name;
	private $hand;

	function __construct(
		$name
	){
		$this->setName($name);
		$this->initializeHand();
	}

	private function initializeHand()
	{
		$this->hand = array();
	}

	private function setName(
		$name
	){
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}

	public function addToHand(
		$card
	){
		$this->hand[] = $card;
	}

	public function removeFromHand(
		$index
	){
		unset($this->hand[$index]);
		$this->hand = array_values($this->hand);
	}

	public function countHand()
	{
		return count($this->hand);
	}

	public function getHand()
	{
		return $this->hand;
	}

	public function getTopCard()
	{
		$count = count($this->hand);
		return $this->hand[$count-1];
	}

}