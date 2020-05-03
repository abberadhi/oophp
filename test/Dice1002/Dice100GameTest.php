<?php

namespace Abbe\Dice1002;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class Dice1002GameTest extends TestCase
{
    /**
     * Construct object.
     * check get number of dice function.
     */
    public function testgetNumberOfDice()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);

        $res = $game->getNumberOfDice();
        $exp = 2;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object.
     * check that method resets player.
     */
    public function testResetPlayer()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);
        $game->players[0]->rollDices(100);
        $game->resetPlayer(0);
        $res = count($game->players[0]->getDices());
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object.
     * check that method player move works.
     */
    public function testPlayerMove()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);
        $game->playerMove();
        $res = count($game->players[0]->getDices());
        $exp = 2;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object.
     * check that method bot move works.
     */
    // public function testBotRoll()
    // {
    //     $game = new Game(2, 2, "Abbe");
    //     $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);
    //     $game->botMove();
    //     $res = $game->players[1]->getCurrentPoints();
    //     $this->assertGreaterThan(0, $res);
    // }

    /**
     * Construct object.
     * check that method bot move works.
     */
    public function testHistogram()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);
        $game->botMove();
        $res = $game->histogram();
        $this->assertContains("*", $res);
    }

    /**
     * Construct object.
     * check that method that calculates odds works
     */
    public function testCalculateOdds()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);
        $game->botMove();
        $res = $game->calculateOdds(1);
        $this->assertIsBool($res);
    }

    /**
     * Construct object.
     * check that method that calculates odds works
     */
    public function testgetHistogramSerie()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);
        $game->botMove();
        $res = $game->players[1]->serie->getHistogramSerie();
        $this->assertIsArray($res);
    }

    public function testgetHistogramMin()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);
        $game->botMove();
        $res = $game->players[1]->serie->getHistogramMin();
        $this->assertIsInt($res);
    }

    public function testgetHistogramMax()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);
        $game->botMove();
        $res = $game->players[1]->serie->getHistogramMax();
        $this->assertIsInt($res);
    }
}
