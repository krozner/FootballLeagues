<?php

namespace FlBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class BaseApiController extends Controller
{
    private function serialize($data)
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $this->get("jms_serializer")->serialize($data, 'json', $context);
    }

    protected function createCollectionResponse($data)
    {
        if ($data instanceof ArrayCollection) {
            $content = $this->serialize($data->toArray(), 'json');

            $response = new JsonResponse($content, 200, [], true);
            return $response;
        }

        throw new \RuntimeException("Serialize case not supported");
    }

    protected function createResponse($entity)
    {
        return new JsonResponse($this->serialize($entity), 200, [], true);
    }
}
