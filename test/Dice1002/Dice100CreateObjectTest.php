<?php

namespace Abbe\Dice1002;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class Dice1002CreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no name arguments.
     */
    public function testCreateObjectNoNameArguments()
    {
        $game = new Game(2, 2);
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);

        $res = count($game->players);
        $exp = 2;
        $this->assertEquals($exp, $res);
    }
    
    /**
     * Construct object and verify that the object has the expected
     * properties. Use name as arguments.
     */
    public function testCreateObjectWithNameArgument()
    {
        $game = new Game(2, 2, "Abbe");
        $this->assertInstanceOf("\Abbe\Dice1002\Game", $game);

        $res = $game->players[0]->name;
        $exp = "Abbe (You)";
        $this->assertEquals($exp, $res);
    }
}
