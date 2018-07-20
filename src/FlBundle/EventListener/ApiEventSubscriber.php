<?php

declare(strict_types=1);

namespace FlBundle\EventListener;

use FlBundle\Service\ApiResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiEventSubscriber implements EventSubscriberInterface
{
    private $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    private function isApiRequest(Request $request)
    {
        return preg_match('/^\/api/', $request->getPathInfo());
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // all api request should return json response
        if ($this->isApiRequest($event->getRequest())) {
            $event->setResponse($this->response->create($event->getException()));
        }
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        /**
         * for all post & put api request json body is required
         *  - usually covered by FOSRestBundle
         */
        if ($this->isApiRequest($request = $event->getRequest())) {
            if (in_array($request->getMethod(), [Request::METHOD_POST, Request::METHOD_PUT])) {
                if ($request->getContentType() != 'json' || ! $request->getContent()) {
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
        return [
            KernelEvents::EXCEPTION  => 'onKernelException',
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
