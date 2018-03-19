<?php

namespace Devim\RpcServerBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class JsonRpcApi
{
    /** @var string */
    public $namespace;

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }
}