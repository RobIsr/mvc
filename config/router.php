<?php

/**
 * Load the routes into the router, this file is included from
 * `htdocs/index.php` during the bootstrapping to prepare for the request to
 * be handled.
 */

declare(strict_types=1);

use FastRoute\RouteCollector;

$router = $router ?? new RouteCollector(
    new \FastRoute\RouteParser\Std(),
    new \FastRoute\DataGenerator\MarkBased()
);

$router->addRoute("GET", "/", "\Mos\Controller\Index");
$router->addRoute("GET", "/debug", "\Mos\Controller\Debug");
$router->addRoute("GET", "/twig", "\Mos\Controller\TwigView");

$router->addGroup("/dice", function (RouteCollector $router) {
    $router->addRoute(["GET", "POST"], "", ["\Rois\Controller\Dice", "index"]);
    $router->addRoute(["GET", "POST"], "/play", ["\Rois\Controller\Dice", "play"]);
    $router->addRoute(["GET"], "/update", ["\Rois\Controller\Dice", "updateGameView"]);
    $router->addRoute("POST", "/controls", ["\Rois\Controller\Dice", "controls"]);
});

$router->addGroup("/yatzy", function (RouteCollector $router) {
    $router->addRoute(["GET", "POST"], "", "\Rois\Controller\Yatzy");
    $router->addRoute("POST", "/controls", ["\Rois\Controller\Yatzy", "controls"]);
    $router->addRoute(["GET"], "/update", ["\Rois\Controller\Yatzy", "updateGameView"]);
});

$router->addGroup("/session", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\Session", "index"]);
    $router->addRoute("GET", "/destroy", ["\Mos\Controller\Session", "destroy"]);
});

$router->addGroup("/some", function (RouteCollector $router) {
    $router->addRoute("GET", "/where", ["\Mos\Controller\Sample", "where"]);
});
