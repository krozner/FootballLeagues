<?php

namespace FlBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiEventSubscriber implements EventSubscriberInterface
{
    private function isApiRequest(Request $request)
    {
        return preg_match('/^\/api/', $request->getPathInfo());
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // all api request should return json response
        if ($this->isApiRequest($event->getRequest())) {
            $code = $event->getException() instanceof HttpExceptionInterface
                ? $event->getException()->getStatusCode()
                : 500;

            $event->setResponse(new JsonResponse([
                'code' => $code,
                'message' => $event->getException()->getMessage(),
            ]));
        }
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        // for all post & put api request json body is required
        if ($this->isApiRequest($request = $event->getRequest())) {
            if (in_array($request->getMethod(), [Request::METHOD_POST, Request::METHOD_PUT])) {
                if ($request->getContentType() != 'json' || !$request->getContent()) {
                    throw new BadRequestHttpException('Malformed JSON request body');
                }

                $data = json_decode($request->getContent(), true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new BadRequestHttpException('Invalid JSON request body: ' . json_last_error_msg());
                }

                $request->request->replace(is_array($data) ? $data : []);
            }
        }
    }


    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException',
            KernelEvents::CONTROLLER => 'onKernelController',
        );
    }
}
