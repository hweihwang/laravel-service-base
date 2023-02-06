<?php

declare(strict_types=1);

namespace Frameworks\Laravel;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Validation\ValidationException;
use Modules\Common\Exceptions\AbstractException;
use Modules\Common\Exceptions\DefaultException;
use Modules\Common\Transports\API\Concerns\APIFoundationTrait;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;
use Webmozart\Assert\InvalidArgumentException as AssertException;

final class ExceptionHandler extends Handler
{
    use APIFoundationTrait;

    protected $dontReport = [
        AbstractException::class,
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ValidationException::class,
    ];

    public function render($request, Throwable $e)
    {
        if ($e instanceof AuthenticationException) {
            return $this->error(
                __('Unauthenticated!'),
                'UNAUTHENTICATED',
                401
            );
        }

        if ($e instanceof AuthorizationException) {
            return $this->error(
                __('Unauthorized!'),
                'UNAUTHORIZED',
                401
            );
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->error(
                __('Method not allowed!'),
                'METHOD_NOT_ALLOWED',
                405
            );
        }

        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return $this->error(
                __('Resource not found!'),
                'NOT_FOUND',
                404
            );
        }

        if ($e instanceof RouteNotFoundException) {
            return $this->error(
                __('Route not found!'),
                'NOT_FOUND',
                404
            );
        }

        //Backwards compatibility
        if ($e instanceof ValidationException) {
            return $this->error(
                __('Validation failed!'),
                'VALIDATION',
                422
            );
        }

        //Handle assert exceptions, be careful not to expose any sensitive information here
        if ($e instanceof AssertException) {
            return $this->error(
                __($e->getMessage()),
                'VALIDATION',
                422
            );
        }

        if ($e instanceof AbstractException) {
            return $e->render();
        }

        return (new DefaultException())->render();
    }
}
