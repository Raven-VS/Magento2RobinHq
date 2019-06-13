<?php

use Magento\Framework\HTTP\PhpEnvironment\Request;
use Psr\Http\Message\RequestInterface;

/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

class RequestFactory
{
    public function createPsrRequest(Request $magentoRequest): RequestInterface
    {
        
    }
}