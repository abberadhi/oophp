<?php

namespace Abbe\Dice100;

use Abbe\Dice100;

class Game
{
    public $numberOfDice;
    public $players = [];

    public function __construct($numberOfPlayers, int $numberOfDice, $name = "Player")
    {
        $this->players[] = new Player(true, $name . " (You)");

        for ($i = 1; $i < $numberOfPlayers; $i++) {
            $this->players[] = new Player(false, "CPU".$i);
        }
        $this->numberOfDice = intval($numberOfDice);
    }

    public function getNumberOfDice()
    {
        return $this->numberOfDice;
    }

    public function resetPlayer($index)
    {
        $this->players[$index]->setDices([]);
        $this->players[$index]->setCurrentPoints(0);
    }

    public function botRoll(int $player, int $times)
    {
        for ($j = 0; $j < $times; $j++) {
            $this->players[$player]->rollDices($this->numberOfDice);

            if (in_array(1, $this->players[$player]->getDices())) {
                return true;
            }
        }
    }

    public function botMove()
    {
        $this->players[0]->increaseTotalPoints();
        for ($i = 1; $i < count($this->players); $i++) {
            $times = rand(1, 4);
            $oneFound = $this->botRoll($i, $times);

            if (!$oneFound) {
                $this->players[$i]->increaseTotalPoints();
            }
            $this->players[$i]->setCurrentPoints(0);
            
            if ($this->players[$i]->winner()) {
                return $this->players[$i]->name;
                break;
            }
        }
        $this->resetPlayer(0);
    }

    public function playerMove()
    {
        $this->players[0]->rollDices($this->numberOfDice);
        
        if (in_array(1, $this->players[0]->getDices())) {
            $this->players[0]->setCurrentPoints(0);
        }

        if ($this->players[0]->winner()) {
            return $this->players[0]->name;
        }
    }
}
