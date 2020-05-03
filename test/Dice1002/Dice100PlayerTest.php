<?php

namespace Abbe\Dice1002;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class Dice1002PlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use name as arguments.
     */
    public function testPlayerSetDice()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);
        $game->players[0]->setDices([0]);

        $res = $game->players[0]->getDices();
        $exp = [0];
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object
     * Give player points and check if player won.
     */
    public function testPlayerWinner()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);

        $game->players[0]->setCurrentPoints(100);
        $game->players[0]->increaseTotalPoints(100);
        $res = $game->players[0]->winner();
        $exp = true;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object
     * Give player points and current points changed.
     */
    public function testCurrentPoints()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);

        $game->players[0]->setCurrentPoints(100);
        $res = $game->players[0]->getCurrentPoints();
        $exp = 100;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object
     * Give player points and check total points increased.
     */
    public function testTotalPoints()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);

        $game->players[0]->setCurrentPoints(100);
        $game->players[0]->increaseTotalPoints();
        $res = $game->players[0]->getTotalPoints();
        $exp = 100;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object
     * Give make player roll dice.
     */
    public function testrollDices()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);

        $game->players[0]->rollDices(5);
        $res = count($game->players[0]->getDices());
        $exp = 5;
        $this->assertEquals($exp, $res);
    }
}
