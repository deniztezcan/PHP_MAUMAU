<?php

namespace DenizTezcan\MauMau;

class Game
{
    /**
     * Class properties.
     */

    /**
     * Collection of the Cards in the Deck.
     *
     * @var Deck
     */
    protected $deck;

    /**
     * Collection of the Players.
     *
     * @var Collection
     */
    protected $players;

    /**
     * Collection of the losing Players.
     *
     * @var Collection
     */
    protected $losers;

    /**
     * Collection of the Cards in the Drawing stack.
     *
     * @var Stack
     */
    protected $stack;

    /**
     * Checks if the game is finished.
     *
     * @var bool
     */
    protected $finished = false;

    /**
     * Methods.
     */

    /**
     * Constructor.
     *
     * Create a new Game instance
     */
    public function __construct()
    {
        $this->deck = new Deck();
        $this->deck->shuffle();
        $this->players = new Collection([
            new Player('Churchill'),
            new Player('Stalin'),
            new Player('Roosevelt'),
            new Player('de Gaulle'),
        ]);
        $this->losers = new Collection();
        $this->stack = new Stack();
    }

    /**
     * Generates a string containing all player names.
     *
     * @return string
     */
    private function listPlayers(): string
    {
        $returnString = 'Starting game with';
        foreach ($this->players->all() as $player) {
            $returnString .= ' '.$player->name().',';
        }
        $returnString = rtrim($returnString, ',');
        $returnString .= '<br>';

        return $returnString;
    }

    /**
     * Deals seven cards to all players.
     *
     * @return void
     */
    private function initialDealing(): void
    {
        foreach ($this->players->all() as $player) {
            for ($i = 0; $i < 7; $i++) {
                $player->addToHand($this->deck->deal());
            }
        }
    }

    /**
     * Generates a string containing all players with their dealed cards.
     *
     * @return string
     */
    private function listInitialDealings(): string
    {
        $returnString = '';
        foreach ($this->players->all() as $player) {
            $returnString .= $player->name().' has been dealt:';
            foreach ($player->getHand() as $card) {
                $returnString .= ' '.$card->display().',';
            }
            $returnString = rtrim($returnString, ',');
            $returnString .= '<br>';
        }

        return $returnString;
    }

    /**
     * Decides if player could play based on the topCard and his hand.
     *
     * @return mixed
     */
    private function canPlay(
        Card $topCard,
        array $hand
    ) {
        foreach ($hand as $cardInHand) {
            if ($topCard->suit() == $cardInHand->suit()) {
                return $cardInHand;
            } elseif ($topCard->value() == $cardInHand->value()) {
                return $cardInHand;
            }
        }

        return false;
    }

    /**
     * Plays a card if able and if not takes a card from the deck.
     * When no cards available in deck it adds the player to the "tmp" losers Collection.
     *
     * @return void
     */
    private function play(Player $player): void
    {
        $canPlay = $this->canPlay($this->stack->getTopCard(), $player->getHand());

        if (!$canPlay) {
            if (!$this->deck->isEmpty()) {
                $newCard = $this->deck->deal();
                $player->addToHand($newCard);
                echo $player->name().' does not have a suitable card. taking from deck '.$newCard->display().'<br>';

                return;
            } else {
                if ($this->players->count() == $this->losers->count()) {
                    echo 'No cards left in deck. There is no winner :(<br>';
                    $this->finished = true;

                    return;
                } else {
                    $this->losers->set($player->name(), $player);
                    echo $player->name().' does not have a suitable card. Deck is empty - skipping turn<br>';

                    return;
                }
            }
        } else {
            $this->stack->add($canPlay);
            $player->removeFromHand($canPlay);
            echo $player->name().' plays '.$canPlay->display().'<br>';
            $this->losers->clear();

            return;
        }
    }

    /**
     * Runs the main logic for the entire game.
     *
     * @return void
     */
    public function run(): void
    {
        echo $this->listPlayers();
        $this->initialDealing();
        echo $this->listInitialDealings();
        $this->stack->add($this->deck->deal());
        echo $this->stack->displayTopCard();

        while (!$this->finished) {
            foreach ($this->players->all() as $player) {
                if (!$player->handIsEmpty()) {
                    $this->play($player);

                    if ($player->handIsEmpty()) {
                        echo $player->name().' has won.';
                        $this->finished = true;

                        return;
                    } elseif ($this->finished) {
                        return;
                    }
                }
            }
        }
    }
}
