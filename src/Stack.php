<?php

namespace DenizTezcan\MauMau;

class Stack
{
	/**
     * Class properties
     */

	/**
     * Array of Cards in stack
     *
     * @type Array
     */
    protected $cards = [];

    /**
     * Methods
     */
    /**
     * Constructor
     *
     */
    public function __construct()
    {
    }

    /**
    * Add a card to the Deck
    *
    * @param  Card
    * @return void
    */
    public function add(Card $card): void
    {
        $this->cards[] = $card;
    }

    /**
     * Count the cards via a simple "count" call
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->cards);
    }

     /**
     * Returns the card on the top of the stack
     *
     * @return Card
     */
    public function getTopCard(): object
    {
        return $this->cards[$this->count()-1];
    }

    /**
     * Displays the card on the top of the stack
     *
     * @return string
     */
    public function displayTopCard(): string
    {
        return "Top cards is: " . $this->getTopCard()->display();
    }

}