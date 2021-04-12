<?php

declare(strict_types=1);

namespace Rois\Controller;

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
    use YatzyPostTrait;

    public function __invoke(): ResponseInterface
    {
        $_SESSION["callable"] = serialize(new YatzyGame());

        $data = [
            "header" => "Yatzy page",
            "message" => "This is the yatzy page",
        ];

        $body = renderView("layout/yatzy/yatzy.php", $data);

        return $this->response($body);
    }

    public function updateGameView()
    {
        $gameObj = unserialize($_SESSION["callable"]);
        $data = [
            "header" => "Dice page",
            "message" => "Hello, this is the dice page.",
            "rounds" => $gameObj->getRounds(),
            "diceValues" => $gameObj->getCurrentRound()->getDiceHand()->values(),
            "savedValues" => $gameObj->getCurrentRound()->getStoredDices(),
            "end" => $gameObj->getCurrentRound()->checkEnd(),
            "saved" => $gameObj->getCurrentRound()->checkSaved(),
            "endGame" => $gameObj->checkEndGame(),
            "sum" => $gameObj->getTotalScore(),
            "bonus" => $gameObj->getTotalScore() > 63 ? 50 : 0
        ];

        $body = renderView("layout/yatzy/yatzy_play.php", $data);

        return $this->response($body);
    }
}
