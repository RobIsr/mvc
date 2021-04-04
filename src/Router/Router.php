<?php

declare(strict_types=1);

namespace Mos\Router {

    use Rois\Dice;

    use function Mos\Functions\{

        destroySession,
        redirectTo,
        renderView,
        renderTwigView,
        sendResponse,
        url
    };

    /**
     * Class Router.
     */
    class Router
    {
        public static function dispatch(string $method, string $path): void
        {
            if ($method === "GET" && $path === "/") {
                $data = [
                    "header" => "Index page",
                    "message" => "Hello, this is the index page, rendered as a layout.",
                ];
                $body = renderView("layout/page.php", $data);
                sendResponse($body);
                return;
            } else if ($method === "GET" && $path === "/session") {
                $body = renderView("layout/session.php");
                sendResponse($body);
                return;
            } else if ($method === "GET" && $path === "/session/destroy") {
                destroySession();
                redirectTo(url("/session"));
                return;
            } else if ($method === "GET" && $path === "/debug") {
                $body = renderView("layout/debug.php");
                sendResponse($body);
                return;
            } else if ($method === "GET" && $path === "/twig") {
                $data = [
                    "header" => "Twig page",
                    "message" => "Hey, edit this to do it youreself!",
                ];
                $body = renderTwigView("index.html", $data);
                sendResponse($body);
                return;
            } else if ($method === "GET" && $path === "/some/where") {
                $data = [
                    "header" => "Rainbow page",
                    "message" => "Hey, edit this to do it youreself!",
                ];
                $body = renderView("layout/page.php", $data);
                sendResponse($body);
                return;
            } else if ($method === "GET" && $path === "/dice") {
                //Route that initiates a new game object and renders the inital view.
                $callable = new Dice\Game();
                $_SESSION["callable"] = serialize($callable);
                $data = [
                    "header" => "Dice Game",
                    "message" => "Select number of dices",
                ];
                $body = renderView("layout/dice.php", $data);
                sendResponse($body);
                return;
            } else if ($method === "GET" && $path === "/dice/play") {
                //Route that renders the game view.
                $data = [
                    "header" => "Dice Game",
                    "message" => "Roll dices to get as close to 21 as possible but not above...",
                ];
                $body = renderView("layout/dice_play.php", $data);
                sendResponse($body);
                return;
            } else if ($method === "POST" && $path === "/dice") {
                //Load game object from session and call its methods as appropriate.
                $callable = unserialize($_SESSION["callable"]);
                if (isset($_POST["roll"])) {
                    $callable->newRoll();
                } elseif (isset($_POST["stop"])) {
                    $callable->stop(count($callable->getDices()));
                } elseif (isset($_POST["dices"])) {
                    $callable->playGame($_POST["dices"]);
                    redirectTo(url("/dice/play"));
                } elseif (isset($_POST["new_game"])) {
                    $callable->playGame($_POST["dices"]);
                    unset($_SESSION["dice"]);
                    unset($_SESSION["callable"]);
                    redirectTo(url("/dice"));
                } elseif (isset($_POST["reset_count"])) {
                    $callable->resetRounds();
                }
                //Save the updated game object to session.
                $_SESSION["callable"] = serialize($callable);
                return;
            }

            $data = [
                "header" => "404",
                "message" => "The page you are requesting is not here. You may also checkout the HTTP response code, it should be 404.",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body, 404);
        }
    }
}
