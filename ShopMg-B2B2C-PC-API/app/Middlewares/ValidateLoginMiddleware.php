<?php
declare(strict_types=1);

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Bean;
use Swoft\Http\Message\Middleware\MiddlewareInterface;
use Swoft\Session\SessionManager;

/**
 * 验证登录中间件
 *
 * @author Administrator
 * @Bean()
 */
class ValidateLoginMiddleware implements MiddlewareInterface
{

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /**
         *
         * @var SessionManager $sessionManager
         */
        $sessionManager = \Swoft\App::getBean('sessionManager');

        $session = $sessionManager->getSession();

        if (!$session->get('user_id')) {
            return response()->withContent('{"status":10001,"message":"请登录", "data":""}');
        }

        return $handler->handle($request);
    }
}