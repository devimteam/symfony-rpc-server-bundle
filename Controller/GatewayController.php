<?php

namespace Devim\RpcServerBundle\Controller;

use Devim\RpcServerBundle\JsonRpcDiscovery;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GatewayController implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /** @var JsonRpcDiscovery */
    private $jsonRpcDiscovery;

    /**
     * GatewayController constructor.
     * @param JsonRpcDiscovery $jsonRpcDiscovery
     */
    public function __construct(JsonRpcDiscovery $jsonRpcDiscovery)
    {
        $this->jsonRpcDiscovery = $jsonRpcDiscovery;
    }

    public function handler(Request $request)
    {
        $content = $request->getContent();

        /** @var \ReflectionClass $classRefl */
        /** @var \ReflectionMethod $methodRefl */
        list($classRefl, $methodRefl) = $this->jsonRpcDiscovery->resolve($content);
        $controller = $this->container->get($classRefl->getName());

        $response = $methodRefl->invokeArgs($controller, json_decode($content, true)['params']);

        if (is_array($response)) {
            $response = new JsonResponse($response);
        }

        return $response;

//        return new Response(null !== $this->jsonRpcDiscovery ? 'Hello!' : 'Zhopa!');
    }
}