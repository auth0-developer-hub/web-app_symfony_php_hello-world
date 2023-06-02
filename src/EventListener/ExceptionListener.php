<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Controller\TraceableControllerResolver;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ExceptionListener
{
    private HttpKernel $kernel;
    private RequestStack $requestStack;
    private TraceableControllerResolver $resolver;

    public function __construct(HttpKernel $kernel, RequestStack $requestStack, TraceableControllerResolver $controllerResolver)
    {
        $this->kernel = $kernel;
        $this->requestStack = $requestStack;
        $this->resolver = $controllerResolver;
    }

    public function onKernelException(ExceptionEvent  $event)
    {
        $exception  =  $event->getThrowable();

        $message = 'Internal Server Error';
        $statusCode = 500;

        if ($exception instanceof NotFoundHttpException) {
            $message = 'Not Found';
            $statusCode = 404;
        }

        $subRequest = $this->requestStack->getCurrentRequest()->duplicate([], null, [
            '_controller' => $this->getErrorController(),
            'message' => $message,
            'statusCode' => $statusCode
        ]);

        $event->setResponse($this->kernel->handle($subRequest, HttpKernelInterface::MAIN_REQUEST));
    }

    private function getErrorController()
    {
        $request = new Request();
        $request->attributes->set('_controller', '\App\Controller\ErrorController::showErrorPage');

        return $this->resolver->getController($request);
    }
}
