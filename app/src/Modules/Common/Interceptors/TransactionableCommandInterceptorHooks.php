<?php

namespace Modules\Common\Interceptors;

use Ecotone\Messaging\Attribute\Interceptor\Around;
use Ecotone\Messaging\Handler\Processor\MethodInvoker\MethodInvocation;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Common\Exceptions\Reporters\ExceptionReporter;

final class TransactionableCommandInterceptorHooks
{
    #[Around]
    public function around(MethodInvocation $methodInvocation, TransactionableCommandInterceptor $interceptor)
    {
        DB::beginTransaction();
        try {
            $result = $methodInvocation->proceed();

            DB::commit();

            return $result;
        } catch (Exception $e) {
            DB::rollback();

            (new ExceptionReporter())->report($e);

            throw $interceptor->exception;
        }
    }
}
