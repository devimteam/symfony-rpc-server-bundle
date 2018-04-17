<?php

namespace Devim\RpcServerBundle;

use Devim\RpcServerBundle\Annotation\JsonRpcApi;
use Devim\RpcServerBundle\Annotation\JsonRpcMethod;
use Doctrine\Common\Annotations\Reader;

class JsonRpcDiscovery
{
    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * @var array
     */
    private $classes;

    /**
     * @var array
     */
    private $cache = [];

    /**
     * JsonRpcDiscovery constructor.
     * @param Reader $annotationReader
     * @param array $classes
     */
    public function __construct(Reader $annotationReader, array $classes)
    {
        $this->annotationReader = $annotationReader;
        $this->classes = $classes;
    }

    /**
     * @param string $requestBody
     * @return array
     */
    public function resolve(string $requestBody)
    {
        $requestBodyArr = json_decode($requestBody, true);
        $rpcMethod = $requestBodyArr['method'];

        if (0 == count($this->cache) && 0 < count($this->classes)) {
            list($namespace, $action) = explode('.', $rpcMethod);

            foreach ($this->classes as $class) {
                $classReflection = new \ReflectionClass($class);
                $rpcApiAnn = $this->annotationReader->getClassAnnotation($classReflection, JsonRpcApi::class);
                /** @var JsonRpcApi $rpcApiAnn */
                if (null == $rpcApiAnn) {
                    continue;
                }
                if ($rpcApiAnn->getNamespace() !== $namespace) {
                    continue;
                }
//                echo $class; die;
                //

                foreach ($classReflection->getMethods() as $method) {
                    $rpcMethodAnn = $this->annotationReader->getMethodAnnotation($method, JsonRpcMethod::class);
                    /** @var JsonRpcMethod $rpcMethodAnn */
                    if (null == $rpcMethodAnn) {
                        continue;
                    }
                    if (
                        (strlen($rpcMethodAnn->getName()) > 0 && $rpcMethodAnn->getName() === $action)
                        || $method->getName() === $action
                    ) {
                        $this->cache[$rpcMethod] = [$classReflection, $method];
                    }
                }
            }
        }

//        var_dump($this->cache);die;

        return $this->cache[$rpcMethod];
    }
}