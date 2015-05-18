<?php

namespace MatM\Bundle\TypeAheadBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MatMTypeAheadBundle extends Bundle
{
	/**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return __NAMESPACE__;
    }
    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return strtr(__DIR__, '\\', '/');
    }
}
