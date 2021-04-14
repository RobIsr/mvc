<?php

namespace Rois\Yatzy;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class YatzyRoundObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use one argument corresponding to maximum number
     * of throws allowed.
     */
    public function testCreateObjectOneArgument()
    {
        $round = new Round(3);
        $this->assertInstanceOf("\Rois\Yatzy\Round", $round);
    }

    public function testRollAndGetDiceHand()
    {
        $round = new Round(3);
        $round->roll();
        $diceHand = $round->getDiceHand();
        $this->assertInstanceOf("\Rois\Dice\DiceHand", $diceHand);
    }

    public function testRollLimitEndsRound()
    {
        $round = new Round(3);
        $round->roll();
        $round->roll();
        $round->roll();
        $end = $round->checkEnd();
        $this->assertTrue($end);
    }

    public function checkStoreDices()
    {
        $round = new Round(3);
        $valueToSave = $round->getDiceHand()->values()[1];
        $round->roll();
        $round->storeDices(1);
        $diceHandValues = $round->getDiceHand()->values();
        $this->assertContains($valueToSave, $diceHandValues);
    }
}
