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
class YatzyWelcomeViewTest extends TestCase
{
    /**
     * Test that the welcome view renders the provided data.
     */
    public function testYatzyWelcomeView()
    {
        $data = [
            "header" => "Yatzy page",
            "message" => "This is the yatzy page",
        ];
        $controller = new Yatzy();
        $res = $controller();
        $responseBody = $res->getBody()->__toString();
        $this->assertStringContainsString($data["header"], $responseBody);
        $this->assertStringContainsString($data["message"], $responseBody);
    }
}
