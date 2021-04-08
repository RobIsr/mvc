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

        $addRemove = [
            "add-0" => 0,
            "add-1" => 1,
            "add-2" => 2,
            "add-3" => 3,
            "add-4" => 4,
            "rem-0" => 0,
            "rem-1" => 1,
            "rem-2" => 2,
            "rem-3" => 3,
            "rem-4" => 4
        ];

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
        } 
        
        foreach($addRemove as $index => $value) {
            if (isset($_POST[$index])) {
                $func = explode("-", $index);
                if ($func[0] === "add") {
                    $gameObj->getCurrentRound()->storeDices($value);
                } else {
                    $gameObj->getCurrentRound()->removeDices($value);
                }
                
                $_SESSION["callable"] = serialize($gameObj);
                return $this->redirect(url("/yatzy/update"));
            }
        }

        $_SESSION["callable"] = serialize($gameObj);
        return $this->redirect(url("/yatzy/update"));
    }
}