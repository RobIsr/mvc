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
 * Reusable trait with utilities to create responses.
 */
trait YatzyPostTrait
{

    protected function response(
        string $body,
        int $status = 200
    ): ResponseInterface {
        $psr17Factory = new Psr17Factory();

        return $psr17Factory
            ->createResponse($status)
            ->withBody($psr17Factory->createStream($body));
    }


    protected function redirect(
        string $url,
        int $status = 301
    ): ResponseInterface {
        $psr17Factory = new Psr17Factory();

        return $psr17Factory
            ->createResponse($status)
            ->withHeader("Location", $url);
    }

    public function controls(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $gameObj = unserialize($_SESSION["callable"]);
        if (isset($_POST["start"])) {
            $_SESSION["callable"] = serialize($gameObj);
            $gameObj->initGame();
            $gameObj->getCurrentRound()->roll();
        } elseif (isset($_POST["roll"])) {
            $gameObj->getCurrentRound()->roll();
        } elseif (isset($_POST["save_result"])) {
            $gameObj->saveRound(intval($_POST["save_position"]));
            $gameObj->newRound();
            $gameObj->getCurrentRound()->roll();
        } elseif (isset($_POST["new_game"])) {
            $gameObj = new YatzyGame();
            $gameObj->initGame();
            $gameObj->getCurrentRound()->roll();
        } elseif (isset($_POST["add-0"])) {
            $gameObj->getCurrentRound()->storeDices(0);
        } elseif (isset($_POST["add-1"])) {
            $gameObj->getCurrentRound()->storeDices(1);
        } elseif (isset($_POST["add-2"])) {
            $gameObj->getCurrentRound()->storeDices(2);
        } elseif (isset($_POST["add-3"])) {
            $gameObj->getCurrentRound()->storeDices(3);
        } elseif (isset($_POST["add-4"])) {
            $gameObj->getCurrentRound()->storeDices(4);
        } elseif (isset($_POST["rem-0"])) {
            $gameObj->getCurrentRound()->removeDices(0);
        } elseif (isset($_POST["rem-1"])) {
            $gameObj->getCurrentRound()->removeDices(1);
        } elseif (isset($_POST["rem-2"])) {
            $gameObj->getCurrentRound()->removeDices(2);
        } elseif (isset($_POST["rem-3"])) {
            $gameObj->getCurrentRound()->removeDices(3);
        } elseif (isset($_POST["rem-4"])) {
            $gameObj->getCurrentRound()->removeDices(4);
        }
        $_SESSION["callable"] = serialize($gameObj);
        return $this->redirect(url("/yatzy/update"));
    }
}