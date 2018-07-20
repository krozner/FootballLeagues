<?php

declare(strict_types=1);

namespace FlBundle\Service;

use JMS\Serializer\Serializer;

class ApiResponse
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    private function serialize($data)
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $this->serializer->serialize($data, 'json', $context);
    }

    public function create($content): JsonResponse
    {
        if ($content instanceof ArrayCollection) {
            $content = $content->toArray();
        } elseif ($content instanceof HttpExceptionInterface) {
            $content = [
                'code'    => $content->getStatusCode(),
                'message' => $content->getMessage(),
            ];
        }

        new JsonResponse($this->serialize($content), 200, [], true);
    }
}
