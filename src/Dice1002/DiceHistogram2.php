<?php

namespace Abbe\Dice1002;

/**
 * A dice which has the ability to present data to be used for creating
 * a histogram.
 */
class DiceHistogram2 extends Dice implements HistogramInterface
{
    use HistogramTrait2;
    

    /**
     * Roll the dice, remember its value in the serie and return
     * its value.
     *
     * @return int the value of the rolled dice.
     */
    public function roll()
    {
        $this->serie[] = parent::roll();
        return end($this->serie);
    }

    public static function getNumbers($serie)
    {

        $numbers = [
            "1"=>0,
            "2"=>0,
            "3"=>0,
            "4"=>0,
            "5"=>0,
            "6"=>0,
        ];
        sort($serie);

        for ($i = 0; $i < count($serie); $i++) {
                $numbers[$serie[$i]] += 1;
        }

        return $numbers;
    }

    public static function printHistogram($serie, int $min = null, int $max = null)
    {
        $numbers = self::getNumbers($serie);
        
        $res = "";

        foreach ($numbers as $key => $value) {
            if ($min && $max) {
                if ($key >= $min && $key <= $max) {
                    if ($value > 0) {
                        $res .= $key . ". " . str_repeat("*", intval($value)) . "<br>";
                    }
                }
            } else {
                $res .= $key . ". " . str_repeat("*", intval($value)) . "<br>";
            }
        }
        
        return $res;
    }
}
