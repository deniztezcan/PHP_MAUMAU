<?php

namespace DenizTezcan\MauMau;

class Player
{
	/**
     * Class properties
     */

	/**
     * Name of the Player
     *
     * @type String
     */
    protected $name;

    /**
     * Collection of Cards in the Hand
     *
     * @type Collection
     */
    protected $hand;

    /**
     * Methods
     */
    /**
     * Constructor
     *
     * Create a new Game instance
     *
     * @param string $name The name of this Player
     * @return void
     */
    public function __construct($name = "Foo bar")
    {
    	$this->name($name);
    	$this->hand = new Collection();
    }

    /**
     * Get/Set the name of this player
     *
     * @param mixed  $name The name of this Player (set) or Null (get)
     * @return mixed
     */
    public function name($name = null)
    {
    	if (null !== $name) {
    		$this->name = $name;
    		return $this;
    	}

    	return $this->name;
    }

    /**
     * Get the Hand of this player
     *
     * @return array
     */
    public function getHand(): array
    {
    	return $this->hand->all();
    }

    /**
     * Count the Hand of this player
     *
     * @return int
     */
    public function countHand(): int
    {
    	return $this->hand->count();
    }

    /**
     * Add to the hand of this player
     *
     * @param Card $card a Card
     * @return void
     */
    public function addToHand($card): void
    {
    	$this->hand->set($card->getKey(), $card);
    }

    /**
     * Remove from the hand of this player
     *
     * @param Card $card a Card
     * @return void
     */
    public function removeFromHand($card): void
    {
    	$this->hand->remove($card->getKey());
    }

    /**
     * Checks if hand is empty
     *
     * @return bool
     */
    public function handIsEmpty(): bool
    {
        return ((bool) $this->countHand() ? false : true );
    }
}