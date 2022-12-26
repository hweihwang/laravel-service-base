<?php

namespace Modules\Common\Interceptors;

use Ecotone\Messaging\Attribute\Interceptor\After;
use Ecotone\Messaging\Attribute\Interceptor\Before;
use Modules\Common\Exceptions\DefaultException;
use Modules\Common\ValueObjects\AbstractValueObject;

final class LockableCommandInterceptorHooks
{
    /**
     * @throws DefaultException
     */
    #[Before]
    public function before(AbstractValueObject $command, LockableCommandInterceptor $interceptor): void
    {
        $interceptor->hashedCommand = $interceptor->hasher->hash($command);

        if ($interceptor->locker->isLocked($interceptor->hashedCommand)) {
            $class = $this->getLockableClassName($command);

            throw new DefaultException(
                "Seems like you have just made a [$class] which is the same as you or someone else did. Please wait for it to be completed!"
            );
        }

        $interceptor->locker->lock($interceptor->hashedCommand);
    }

    #[After]
    public function after(LockableCommandInterceptor $interceptor): void
    {
        $interceptor->locker->unlock($interceptor->hashedCommand);
        $interceptor->locker->lock($interceptor->hashedCommand, $interceptor->delayIntercept);
    }

    private function getLockableClassName(AbstractValueObject $payload): string
    {
        return trim(implode(' ', preg_split('/(?=[A-Z])/', class_basename(get_class($payload)))));
    }
}
