<?php

declare(strict_types=1);

namespace Rois\Controller;

use Rois\Yatzy\YatzyGame;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\{
    url
};

/**
 * Test cases for the controller Yatzy.
 */
class ControllerYatzyGameTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateTheControllerClass()
    {
        $controller = new Yatzy();
        $this->assertInstanceOf("\Rois\Controller\Yatzy", $controller);
    }

    /**
     * Check that the controller returns a response.
     */
    public function testControllerReturnsResponse()
    {
        $controller = new Yatzy();
        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller();
        $this->assertInstanceOf($exp, $res);
        $this->assertEquals(200, $res->getStatusCode());
    }

    // Tests for YatzyPostTrait

    /**
     * Test that controls() returns a new ResponseInterface.
    */
    public function testControlsResponseInterface()
    {
        $gameObj = new YatzyGame();
        $gameObj->initGame();
        $_SESSION["callable"] = serialize($gameObj);
        $controller = new Yatzy();
        $responseInterFace = $controller->controls();
        $exp = "\Psr\Http\Message\ResponseInterface";
        $_SESSION = [];
        $this->assertInstanceOf($exp, $responseInterFace);
    }

    /**
     * Test that a round in initiated when calling controls with "start"
     * set in $_POST.
    */
    public function testControlsWithStart()
    {
        $gameObj = new YatzyGame();
        $gameObj->initGame();
        $_SESSION["callable"] = serialize($gameObj);
        $controller = new Yatzy();
        $_POST["start"] = "start";
        $controller->controls();
        $gameObj = unserialize($_SESSION["callable"]);
        $roundCount = $gameObj->getRoundCount();
        $this->assertEquals(1, $roundCount);
        $_SESSION = [];
        $_POST = [];
    }

    /**
     * Test that a round in initiated when calling controls with "start"
     * set in $_POST.
    */
    public function testControlsWithRoll()
    {
        $gameObj = new YatzyGame();
        $gameObj->initGame();
        $_SESSION["callable"] = serialize($gameObj);
        $controller = new Yatzy();
        $_POST["roll"] = "roll";
        $controller->controls();
        $gameObj = unserialize($_SESSION["callable"]);
        $throwCount = $gameObj->getCurrentRound()->getThrowCount();
        $this->assertEquals(1, $throwCount);
        $_SESSION = [];
        $_POST = [];
    }

    /**
     * Test that a another round is initiated when calling controls with "saveResult"
     * set in $_POST.
    */
    public function testControlsWithSaveResult()
    {
        $_POST = [];
        $gameObj = new YatzyGame();
        $gameObj->initGame();
        $gameObj->getCurrentRound()->roll();
        $_SESSION["callable"] = serialize($gameObj);
        $controller = new Yatzy();
        $_POST["save_result"] = true;
        $_POST["save_position"] = 1;
        $controller->controls();
        $gameObj = unserialize($_SESSION["callable"]);
        $roundCount = $gameObj->getRoundCount();
        $this->assertEquals(2, $roundCount);
        $_SESSION = [];
        $_POST = [];
    }

    /**
     * Test that a another round is initiated when calling controls with "saveResult"
     * set in $_POST.
    */
    public function testControlsWithNewGame()
    {
        $_POST = [];
        $gameObj = new YatzyGame();
        $gameObj->initGame();
        $gameObj->newRound();
        $gameObj->newRound();
        $initialRoundCount = $gameObj->getRoundCount();
        $_SESSION["callable"] = serialize($gameObj);
        $controller = new Yatzy();
        $_POST["new_game"] = true;
        $controller->controls();
        $gameObj = unserialize($_SESSION["callable"]);
        $newRoundCount = $gameObj->getRoundCount();
        $this->assertNotEquals($initialRoundCount, $newRoundCount);
        $_SESSION = [];
        $_POST = [];
    }

    /**
     * Test that controllers functions for adding and removing stored dices
     * updates the gameobject accordingly.
     */
    public function testAddRemoveDices()
    {
        $_POST = [];
        $gameObj = new YatzyGame();
        $gameObj->initGame();
        $gameObj->getCurrentRound()->roll();
        $_SESSION["callable"] = serialize($gameObj);

        $controller = new Yatzy();

        /**
         * Add all dices in turn to storedDices and check that storedDices count
         * increases.
        */
        for ($i = 0; $i < 5; $i++) {
            $gameObj = unserialize($_SESSION["callable"]);
            $prevDices = $gameObj->getCurrentRound()->getStoredDices();
            $initialCount = count($prevDices);
            $_POST["add-0"] = 0;
            $controller->controls();
            $gameObj = unserialize($_SESSION["callable"]);
            $newDices = $gameObj->getCurrentRound()->getStoredDices();
            $newCount = count($newDices);
            $this->assertNotEquals($initialCount, $newCount);
            $_POST = [];
        }

        /**
         * Remove all dices in turn from storedDices and check that storedDices count
         * decreases.
        */
        for ($i = 0; $i < 5; $i++) {
            $gameObj = unserialize($_SESSION["callable"]);
            $prevDices = $gameObj->getCurrentRound()->getStoredDices();
            $initialCount = count($prevDices);
            $_POST["rem-0"] = 0;
            $controller->controls();
            $gameObj = unserialize($_SESSION["callable"]);
            $newDices = $gameObj->getCurrentRound()->getStoredDices();
            $newCount = count($newDices);
            $this->assertNotEquals($initialCount, $newCount);
            $_POST = [];
        }
    }
}
