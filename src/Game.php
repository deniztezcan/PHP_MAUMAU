<?php

namespace DenizTezcan\MauMau;

class Game
{
	/**
     * Class properties
     */

	/**
     * Collection of the Cards in the Deck
     *
     * @type Deck
     */
    protected $deck;

	/**
     * Collection of the Players
     *
     * @type Collection
     */
    protected $players;

	/**
     * Collection of the Cards in the Drawing stack
     *
     * @type Stack
     */
    protected $stack;

	/**
     * Checks if the game is finished
     *
     * @type Boolean
     */
    protected $finished = false;

    /**
     * Methods
     */
    /**
     * Constructor
     *
     * Create a new Game instance
     *
     */
    public function __construct()
    {
    	$this->deck = (new Deck)->shuffle();
    	$this->players = New Collection([
    		new Player('Churchill'),
    		new Player('Stalin'),
    		new Player('Roosevelt'),
    		new Player('de Gaulle')
    	]);
    	$this->stack = new Stack();
    }

    /**
     * Runs the logic for the entire game
     *
     * @return void
     */
    public function run(): void
    {
        echo "a";
    }
}