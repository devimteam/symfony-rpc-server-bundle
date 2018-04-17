<?php

namespace Devim\RpcServerBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class JsonRpcMethod
{
    /** @var string */
    public $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}