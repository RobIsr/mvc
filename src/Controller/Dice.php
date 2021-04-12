<?php

declare(strict_types=1);

namespace Rois\Controller;

use Rois\Dice\Game;
use Nyholm\Psr7\{
    Factory\Psr17Factory,
    Response
};
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\{
    destroySession,
    renderView,
    url
};

/**
 * Controller for the dice route.
 */
class Dice
{
    public function index(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $_SESSION["callable"] = serialize(new Game());

        $data = [
            "header" => "Dice page",
            "message" => "Hello, this is the dice page.",
        ];

        $body = renderView("layout/dice.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function play(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $gameObj = unserialize($_SESSION["callable"]);

        $gameObj->playGame(intval($_POST["dices"]));

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/dice/update"));
    }

    public function controls(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $gameObj = unserialize($_SESSION["callable"]);

        if (isset($_POST["roll"])) {
            $gameObj->newRoll();
        } elseif (isset($_POST["stop"])) {
            $gameObj->stop();
        } elseif (isset($_POST["reset"])) {
            $gameObj->resetRounds();
        }

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/dice/update"));
    }

    public function updateGameView() {
        $psr17Factory = new Psr17Factory();

        $gameObj = unserialize($_SESSION["callable"]);

        $data = [
            "header" => "Dice page",
            "message" => "Hello, this is the dice page.",
            "gameObj" => $gameObj
        ];

        $body = renderView("layout/dice_play.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }
}
