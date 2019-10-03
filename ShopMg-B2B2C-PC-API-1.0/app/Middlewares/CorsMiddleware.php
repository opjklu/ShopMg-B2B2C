<?php

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Bean;
use Swoft\Http\Message\Middleware\MiddlewareInterface;

/**
 * 跨域解决
 * @Bean()
 */
class CorsMiddleware implements MiddlewareInterface
{

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \InvalidArgumentException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ('OPTIONS' === $request->getMethod()) {
            return $this->configResponse(\response(), $request);
        }

        $response = $handler->handle($request);

        return $this->configResponse($response, $request);
    }

    /**
     *
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function configResponse(ResponseInterface $response, ServerRequestInterface $request)
    {
        $config = \Swoft\App::getBean('config')->get('origin');

        $origin = $request->getHeader('origin');

        if (isset($origin[0]) && in_array($origin[0], $config)) {

            return $response->withHeader('Access-Control-Allow-Origin', $origin)
                ->withHeader('Access-Control-Allow-Credentials', 'true')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        }
        return $response;
    }
}