<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

return function ($app) {
    $app->options('/{routers:.+}', function($request,$response){
        return $response;
    });

    $app->add(function (Request $request, RequestHandler $handler){
        $origin = $request->getHeaderLine('Origin') ?: '*';
        $response = $handler->handle($request);
        $response = $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-Wth, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            //->withHeader('Access-Control-Allow-Credentials', 'true');

        //if($request->getMethod() === 'OPTIONS'){
          //  return $response->withStatus(200);
        //}
        
        //return $response;
    });
};
