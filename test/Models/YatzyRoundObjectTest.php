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

    public function testStoreDices()
    {
        $round = new Round(3);
        $round->roll();
        $valueToStore = $round->getDiceHand()->values()[1];
        $round->storeDices(1);
        $storedDices = $round->getStoredDices();
        $this->assertCount(1, $storedDices);
        $this->assertEquals($valueToStore, $storedDices[0]);
        $saved = $round->checkSaved();
        $this->assertTrue($saved);
    }

    public function testRemoveDices()
    {
        $round = new Round(3);
        $round->roll();

        $round->storeDices(1);

        $diceHandValues = $round->getDiceHand()->values();
        $storedDices = $round->getStoredDices();
        $this->assertCount(1, $storedDices);

        $round->removeDices(0);
        $diceHandValues = $round->getDiceHand()->values();
        $storedDices = $round->getStoredDices();
        $this->assertCount(5, $diceHandValues);
        $this->assertCount(0, $storedDices);
    }

    public function testGetRoundResult()
    {
        $round = new Round(3);
        $round->roll();
        $valueToStore = $round->getDiceHand()->values()[0];
        $round->storeDices(0);
        $result = $round->getRoundResult($valueToStore);
        $this->assertEquals($valueToStore, $result);
    }
}
