<?php

$providers = [
    \App\Providers\EventServiceProvider::class,
];

foreach ($providers as $provider) {
    $provider = $container->get($provider);

    $provider->register();
}
