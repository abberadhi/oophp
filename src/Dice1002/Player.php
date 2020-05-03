<?php

namespace Abbe\Dice1002;

use Abbe\Dice1002;

class Player
{
    public $name;
    private $totalPoints = 0;
    private $currentPoints = 0;
    private $dices = [];
    public $serie;

    public function __construct($human, string $name = "Player")
    {
        $this->name = $name;
        $this->human = $human;
        $this->serie = new DiceHistogram2();
    }

    public function increaseTotalPoints()
    {
        $this->totalPoints += $this->currentPoints;
    }
    
    public function getTotalPoints()
    {
        return $this->totalPoints;
    }
    
    public function getCurrentPoints()
    {
        return $this->currentPoints;
    }

    public function setCurrentPoints(int $points)
    {
        $this->currentPoints = $points;
    }
    
    public function getDices()
    {
        return $this->dices;
    }

    public function setDices($dices)
    {
        $this->dices = $dices;
    }
    
    public function rollDices(int $times)
    {
        $this->dices = [];
        for ($curr = 0; $curr < $times; $curr++) {
            $newNumber = $this->serie->roll();
            $this->dices[] = $newNumber;
            $this->currentPoints += $newNumber;
        }
    }

    public function winner()
    {
        return $this->totalPoints >= 100;
    }
}
