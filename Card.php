<?php
/**
 * PHP_MAUMAU - A non-interactive PHP version of the game mau mau (pesten)
 *
 * @package 	PHP_MAUMAU
 * @author      Deniz Tezcan <howdy@deniztezcan.me>
 * @link        https://github.com/deniztezcan/PHP_MAUMAU
 */

class Card
{
	
	private $suit;
	private $value;

	public function __construct(
		$suit,
		$value
	){
		$this->setSuit($suit);
		$this->setValue($value);
	}

	private function setSuit(
		$suit
	){
		$this->suit = $suit;
	}

	public function getSuit()
	{
		return $this->suit;
	}

	private function setValue(
		$value
	){
		$this->value = $value;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function getCard()
	{
		return $this->getSuit().$this->getValue();
	}

}