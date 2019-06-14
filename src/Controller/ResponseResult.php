<?php

use Magento\Framework\Controller\ResultInterface;

/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

class ResponseResult implements ResultInterface
{

    /**
     * @param int $httpCode
     * @return $this
     */
    public function setHttpResponseCode($httpCode)
    {
        // TODO: Implement setHttpResponseCode() method.
    }

    /**
     * Set a header
     *
     * If $replace is true, replaces any headers already defined with that
     * $name.
     *
     * @param string $name
     * @param string $value
     * @param boolean $replace
     * @return $this
     */
    public function setHeader($name, $value, $replace = false)
    {
        // TODO: Implement setHeader() method.
    }

    /**
     * Render result and set to response
     *
     * @param \Magento\Framework\App\ResponseInterface $response
     * @return $this
     */
    public function renderResult(\Magento\Framework\App\ResponseInterface $response)
    {
        // TODO: Implement renderResult() method.
    }
}