<?php

namespace Rois\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceGameObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use one argument corresponding to number of sides
     * on dice.
     */
    public function testCreateObjectOneArgument()
    {
        $game = new Game();
        $this->assertInstanceOf("\Rois\Dice\Game", $game);
    }

    /**
     * Test that playGame function initializes a new DiceHand and rolls
     * the correct number of dices.
     */
    public function testPlayGame()
    {
        $game = new Game();
        $game->playGame(2);
        $dices = $game->getDices();
        $values = $game->getValues();
        $this->assertCount(2, $dices);
        $this->assertCount(2, $values);
    }

    /**
     * Test that a new roll can be made and that values change.
     */
    public function testNewRoll()
    {
        $game = new Game();
        $game->playGame(2);
        $firstValues = $game->getValues();
        $game->newRoll();
        $secondValues = $game->getValues();
        $this->assertNotEqual($firstValues, $secondValues);
    }
}
