<?php

namespace Abbe\Dice1002;

class Dice
{
    private $number;

    // public function __construct(int $number = null)
    // {
    //     $this->number = $number ?? $this->roll();
    // }

    public function getNumber()
    {
        return $this->number;
    }

    protected function roll()
    {
        return rand(1, 6);
    }
}
