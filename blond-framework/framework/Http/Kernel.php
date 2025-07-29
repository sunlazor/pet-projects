<?php

namespace Sunlazor\BlondFramework\Http;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Kernel
{

    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $rc) {
            $routes = include BASE_PATH . '/routes/web.php';

            foreach ($routes as $route) {
                $rc->addRoute(...$route);
            }
            
//            $rc->addRoute('GET', '/', function () {
//                $content = '<h1>Content!sss</h1>';
//
//                return new Response($content);
//            });
//
//            $rc->get('/test/{id}', function (array $vars) {
//                $content = "<h1>Tesst = {$vars['id']}</h1>";
//
//                return new Response($content);
//            });
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPath(),
        );

        [$status, [$controller, $method], $vars] = $routeInfo;

        return call_user_func_array([new $controller, $method], $vars);
    }
}