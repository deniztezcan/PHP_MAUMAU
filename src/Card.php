<?php

namespace DenizTezcan\MauMau;

class Card
{
	/**
     * Class properties
     */

	/**
     * string containing Suit
     *
     * @type String
     */
    protected $suit;

	/**
      * string containing Value
     *
     * @type String
     */
    protected $value;

    /**
     * Methods
     */
    /**
     * Constructor
     *
     */
    public function __construct(
        string $suit,
        string $value
    ){
        $this->suit($suit);
        $this->value($value);
    }

    /**
     * Get/Set the suit of this card
     *
     * @param mixed $suit The suit of this Card (set) or Null (get)
     * @return mixed
     */
    public function suit($suit = null)
    {
        if(null !== $suit)
        {
            $this->suit = $suit;
            return $this;
        }

        return $this->suit;
    }

    /**
     * Get/Set the value of this player
     *
     * @param mixed $value The value of this Card (set) or Null (get)
     * @return mixed
     */
    public function value($value = null)
    {
        if(null !== $value)
        {
            $this->value = $value;
            return $this;
        }

        return $this->value;
    }

    /**
     * Gets a pretty Array key from the card
     *
     * @return string
     */
    public function getKey(): string
    {   
        $suitPretty = $this->suit();
        $suitPretty = str_replace(["&", ";"], "", $suitPretty);
        $suitPretty = substr($suitPretty, 0, 1);

        return strtoupper($suitPretty.$this->value());
    }

    /**
     * Displays the card
     *
     * @return string
     */
    public function display(): string
    {
        return $this->suit().$this->value();
    }
}