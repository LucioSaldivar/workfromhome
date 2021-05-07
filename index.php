<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use SocialApp\Controllers\SocialMedias;
use SocialApp\Controllers\GetSocialMedia;
use SocialApp\Repositories\SocialMediaRepository;
use SocialApp\Model\SocialMediaModel;
use SocialApp\Processors\SocialMediaModelFactory;
use SocialApp\views\ModelView\SocialMediaBlock;
use SocialApp\views\ListView\SocialMediaAll;
use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use function DI\create;
use function DI\get;
use function FastRoute\simpleDispatcher;

require_once './vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(true);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions(
    [
        'Response' => create(Response::class)->constructor(),
        'SocialMediaModel' => create(SocialMediaModel::class)->constructor(),
        'SocialMediaModelFactory' => create(SocialMediaModelFactory::class)->constructor(get('SocialMediaModel')),
        'SocialMediaRepository' => create(SocialMediaRepository::class)->constructor(get('SocialMediaModelFactory')),
        'SocialMediaBlock' => create(SocialMediaBlock::class),
        'SocialMediaAll' => create(SocialMediaAll::class)->constructor(),

        SocialMedias::class => create(SocialMedias::class)
            ->constructor(get('Response'),get('SocialMediaRepository'), get('SocialMediaAll')),
        GetSocialMedia::class => create(GetSocialMedia::class)
            ->constructor(get('Response'), get('SocialMediaRepository'), get('SocialMediaBlock')),
    ]
);

$container = $containerBuilder->build();

$routes = simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/social', SocialMedias::class);
    $r->addRoute('GET', '/social/{id:\d+}', GetSocialMedia::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler
    ->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();
return $emitter->emit($response);