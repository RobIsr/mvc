<?php

declare(strict_types=1);

namespace Rois\Controller;

use Nyholm\Psr7\{
    Factory\Psr17Factory,
    Response
};

use Rois\Yatzy\YatzyGame;
use Psr\Http\Message\ResponseInterface;
use function Mos\Functions\{
    destroySession,
    renderView,
    url
};

/**
 * Controller for the yatzy route.
 */
class Yatzy
{
    public function __invoke(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $_SESSION["callable"] = serialize(new YatzyGame());

        $data = [
            "header" => "Yatzy page",
            "message" => "This is the yatzy page",
        ];

        $body = renderView("layout/yatzy/yatzy.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function controls(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $gameObj = unserialize($_SESSION["callable"]);

        if (isset($_POST["start"])) {
            $gameObj->initGame();
            return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy/update"));
        } elseif (isset($_POST["roll"])) {
            //TODO: Roll a new dicehand.
        }

        $_SESSION["callable"] = serialize($gameObj);

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy/update"));
    }

    public function updateGameView() {
        $psr17Factory = new Psr17Factory();

        $gameObj = unserialize($_SESSION["callable"]);

        $data = [
            "header" => "Dice page",
            "message" => "Hello, this is the dice page.",
            "gameObj" => $gameObj
        ];

        $body = renderView("layout/yatzy/yatzy_play.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }
}
