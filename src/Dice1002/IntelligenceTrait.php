<?php

namespace Abbe\Dice1002;

use Abbe\Dice1002;

trait IntelligenceTrait
{
    public function calculateOdds($player)
    {
        $values = $this->players[$player]->serie->getNumbers($this->players[$player]->serie->serie);

        $one = $values["1"];
        $other = 0;

        foreach ($values as $key => $value) {
            if (strval($key) != "1") {
                $other += $value;   
            }
        }

        $other = $other / 5;
        $odds = ($one / ($one+$other+0.0001))*100;

        $random = rand(0, 100);

        return $odds < $random;
    }
}
