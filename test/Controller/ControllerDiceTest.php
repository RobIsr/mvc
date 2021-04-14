<?php

declare(strict_types=1);

namespace Rois\Controller;

use Rois\Dice\Game;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Debug.
 */
class ControllerDiceTest extends TestCase
{
    private function setupGameInSession() {
        $game = new Game();
        $game->playGame(2);
        $_SESSION["callable"] = serialize($game);
    }

    /**
     * Try to create the controller class.
     */
    public function testCreateTheControllerClass()
    {
        $controller = new Dice();
        $this->assertInstanceOf("\Rois\Controller\Dice", $controller);
    }

    /**
     * Try to create the controller class.
     */
    public function testControllerResponseInterface()
    {
        $controller = new Dice();
        $responseInterFace = $controller->index();
        $exp = "\Psr\Http\Message\ResponseInterface";
        $_SESSION = [];
        $this->assertInstanceOf($exp, $responseInterFace);
    }

    /**
     * Test that contoller sets a new Game object in $_SESSION.
     */
    public function testControllerInitsGameInSession()
    {
        $controller = new Dice();
        $responseInterFace = $controller->index();
        $this->assertArrayHasKey("callable", $_SESSION);
        $_SESSION = [];
    }

    /**
     * Test that play() returns a new ResponseInterface.
     */
    public function testPlayResponseInterface()
    {
        $this->setupGameInSession();
        $_POST["dices"] = 2;
        $controller = new Dice();
        $responseInterFace = $controller->play();
        $exp = "\Psr\Http\Message\ResponseInterface";
        $_SESSION = [];
        $this->assertInstanceOf($exp, $responseInterFace);
    }

     /**
     * Test that controls() returns a new ResponseInterface.
     */
    public function testControlsResponseInterface()
    {
        $this->setupGameInSession();
        $controller = new Dice();
        $responseInterFace = $controller->controls();
        $exp = "\Psr\Http\Message\ResponseInterface";
        $_SESSION = [];
        $this->assertInstanceOf($exp, $responseInterFace);
    }

    /**
     * Test that controller makes a new roll when "controls" is callad with "roll"
     * set i $_POST.
     */
    public function testControlsWithRoll()
    {
        $controller = new Dice();
        $game = new Game();
        $game->playGame(1);
        $initalRollCount = $game->getRollCount();
        $_SESSION["callable"] = serialize($game);
        $_POST["roll"] = "roll";
        $controller->controls();
        $game = unserialize($_SESSION["callable"]);
        $newRollCount = $game->getRollCount();
        $this->assertNotEquals($initalRollCount, $newRollCount);
    }

    /**
     * Test that controller generates a result when controls is callad with "stop"
     * set i $_POST.
     */
    public function testControlsWithStop()
    {
        $_POST = [];
        $controller = new Dice();
        $game = new Game();
        $game->playGame(1);
        $_SESSION["callable"] = serialize($game);
        $_POST["stop"] = "stop";
        $controller->controls();
        $game = unserialize($_SESSION["callable"]);
        $result = $game->getResult();
        $this->assertNotNull($result);
    }

    /**
     * Test that controller unsets "player" and "computer" when "controls"
     * is callad with "reset"
     * set i $_POST.
     */
    public function testControlsWithReset()
    {
        $_POST = [];
        $_SESSION["player"] = 1;
        $_SESSION["computer"] = 2;
        $game = new Game();
        $game->playGame(1);

        $_SESSION["callable"] = serialize($game);
        $controller = new Dice();
        $_POST["reset"] = "reset";
        $controller->controls();
        $this->assertArrayNotHasKey("player", $_SESSION);
        $this->assertArrayNotHasKey("computer", $_SESSION);
    }

    /**
     * @runInSeparateProcess
     */
    public function testUpdateGameView()
    {       
        $game = new Game();
        $game->playGame(2);
        $_SESSION["callable"] = serialize($game);
        $data = [
            "header" => "Dice page",
            "message" => "Hello, this is the dice page.",
            "gameObj" => serialize($game)
        ];
        $controller = new Dice();
        $response = $controller->updateGameView();
        $exp = "\Psr\Http\Message\ResponseInterface";
        $this->assertInstanceOf($exp, $response);
    }
}
