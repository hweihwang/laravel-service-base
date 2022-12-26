<?php

declare(strict_types=1);

namespace Modules\Common\Transports\API\Response;

use Illuminate\Http\JsonResponse;

final class SymphonyJsonErrorResponse implements ErrorResponseInterface
{
    public function __construct(protected string $message, protected string $key, protected int $statusCode)
    {
    }

    public function response(): JsonResponse
    {
        return response()->json([
            'key' => $this->key,
            'message' => $this->message,
        ], $this->statusCode);
    }
}
