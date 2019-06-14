<?php

namespace Emico\RobinHq\Model;

use Emico\RobinHqLib\Config\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

class Config implements ConfigInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $config;

    /**
     * Config constructor.
     * @param ScopeConfigInterface $config
     */
    public function __construct(ScopeConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return (string) $this->config->getValue('robinhq/api/key', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getApiSecret(): string
    {
        return (string) $this->config->getValue('robinhq/api/secret', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getApiUri(): string
    {
        return (string) $this->config->getValue('robinhq/api/url', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getApiServerKey(): string
    {
        return (string) $this->config->getValue('robinhq/api/server_key', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getApiServerSecret(): string
    {
        return (string) $this->config->getValue('robinhq/api/server_secret', ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return bool
     */
    public function isApiEnabled(): bool
    {
        return (bool) $this->config->getValue('robinhq/api/server_enabled', ScopeInterface::SCOPE_STORE);
    }
}