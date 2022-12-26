<?php

namespace Modules\Product\Services;

use Modules\Common\Exceptions\DefaultException;
use Modules\Common\Exceptions\Reporters\ExceptionReporter;
use Modules\Common\Services\ServiceInterface;
use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Repositories\ProductRepositoryInterface;
use Throwable;

final readonly class ProductDeleteService implements ServiceInterface
{
    public function __construct(private ProductRepositoryInterface $repository)
    {
    }
    
    /**
     * @throws DefaultException
     */
    public function execute(AbstractValueObject $dto): void
    {
        $ids = $dto->getIds();
        
        if (!is_array($ids) || [] === $ids) {
            throw new DefaultException('Invalid data');
        }
        
        $willBeRemoved = [];
        
        $rawProducts = $this->repository->getByIds($ids);
        
        foreach ($rawProducts as $rawProduct) {
            try {
                $willBeRemoved[] = $this->repository->getModel()::fromArray($rawProduct);
            } catch (Throwable $e) {
                (new ExceptionReporter())->report($e);
                
                continue;
            }
        }
        
        $this->repository->bulkDestroy(collect($willBeRemoved));
    }
}
