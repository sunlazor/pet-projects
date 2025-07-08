<?php

namespace Sunlazor\BlondFramework\Http;

use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

class Kernel
{

    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $rc) {
            $rc->addRoute('GET', '/', function () {
                $content = '<h1>Content!sss</h1>';

                return new Response($content);
            });

            $rc->get('/test/{id}', function (array $vars) {
                $content = "<h1>Tesst = {$vars['id']}</h1>";

                return new Response($content);
            });
        });

        $routeInfo = $dispatcher->dispatch(
            $request->server['REQUEST_METHOD'],
            $request->server['REQUEST_URI'],
        );

        [$status, $handler, $vars] = $routeInfo;

        return $handler($vars);
    }
}