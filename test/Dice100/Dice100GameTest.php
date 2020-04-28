<?php

namespace Abbe\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class Dice100GameTest extends TestCase
{
    /**
     * Construct object.
     * check get number of dice function.
     */
    public function testgetNumberOfDice()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice100\Game", $game);

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
        $this->assertInstanceOf("\Abbe\Dice100\Game", $game);
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
        $this->assertInstanceOf("\Abbe\Dice100\Game", $game);
        $game->playerMove();
        $res = count($game->players[0]->getDices());
        $exp = 2;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object.
     * check that method bot move works.
     */
    public function testBotRoll()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice100\Game", $game);
        $game->botRoll(1, 4);
        $res = $game->players[1]->getCurrentPoints();
        $this->assertGreaterThan(0, $res);
    }
}
