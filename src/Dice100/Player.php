<?php

namespace Abbe\Dice100;

use Abbe\Dice100;

class Player
{
    public $name;
    private $totalPoints = 0;
    private $currentPoints = 0;
    private $dices = [];

    public function __construct($human, string $name = "Player")
    {
        $this->name = $name;
        $this->human = $human;
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
            $newDice = new Dice();
            $this->dices[] = $newDice->getNumber();
            $this->currentPoints += $newDice->getNumber();
        }
    }

    public function winner()
    {
        return $this->totalPoints >= 100;
    }
}
