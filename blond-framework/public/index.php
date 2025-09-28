<?php

namespace App;

define('BASE_PATH', dirname(__DIR__));

include_once BASE_PATH . '/vendor/autoload.php';

use App\Listeners\ContentLengthListener;
use App\Listeners\EntityHandleListener;
use League\Container\Container;
use Psr\EventDispatcher\EventDispatcherInterface;
use Sunlazor\BlondFramework\Dbal\Event\EntityPersist;
use Sunlazor\BlondFramework\Event\EventDispatcher;
use Sunlazor\BlondFramework\Http\Event\ResponseEvent;
use Sunlazor\BlondFramework\Http\Kernel;
use Sunlazor\BlondFramework\Http\Request;

/** @var Container $container */
$container = require_once BASE_PATH . '/config/services.php';

/** @var Kernel $kernel */
$kernel = $container->get(Kernel::class);

/** @var EventDispatcher $eventDispatcher */
$eventDispatcher = $container->get(EventDispatcherInterface::class);
$eventDispatcher->addListener(ResponseEvent::class, new ContentLengthListener());
$eventDispatcher->addListener(EntityPersist::class, new EntityHandleListener());

$request = Request::createFromGlobals();
$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);