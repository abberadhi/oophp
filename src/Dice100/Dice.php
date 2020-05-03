<?php

namespace Abbe\Dice100;

class Dice
{
    private $number;

    public function __construct(int $number = null)
    {
        $this->number = $number ?? $this->roll();
    }

    public function getNumber()
    {
        return $this->number;
    }

    private function roll()
    {
        return rand(1, 6);
    }
}
