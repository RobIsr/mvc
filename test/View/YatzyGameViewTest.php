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
class YatzyGameViewTest extends TestCase
{
    /**
     * Test that the welcome view renders the provided data.
     */
    public function testYatzyGameViewBaseData()
    {
        $gameObj = new YatzyGame();
        $gameObj->initGame();
        $_SESSION["callable"] = serialize($gameObj);
        $data = [
            "header" => "Dice page",
            "message" => "Hello, this is the dice page.",
            "sum" => $gameObj->getTotalScore(),
            "bonus" => $gameObj->getTotalScore() >= 63 ? 50 : 0
        ];
        $controller = new Yatzy();
        $res = $controller->updateGameView();
        $responseBody = $res->getBody()->__toString();
        $this->assertStringContainsString($data["header"], $responseBody);
        $this->assertStringContainsString($data["message"], $responseBody);
        $this->assertStringContainsString(strval($data["sum"]), $responseBody);
        $this->assertStringContainsString(strval($data["bonus"]), $responseBody);
        $_SESSION = [];
    }
}
