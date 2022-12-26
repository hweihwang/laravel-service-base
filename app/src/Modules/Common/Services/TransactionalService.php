<?php

declare(strict_types=1);

namespace Modules\Common\Services;

use Modules\Common\Services\Session\TransactionalSessionInterface;
use Modules\Common\ValueObjects\AbstractValueObject;

abstract class TransactionalService implements ServiceInterface
{
    public function __construct(
        private readonly ServiceInterface $service,
        private readonly TransactionalSessionInterface $session
    ) {
    }

    public function execute(AbstractValueObject $dto)
    {
        $operation = fn () => $this->service->execute($dto);

        return $this->session->executeAtomically($operation);
    }
}
