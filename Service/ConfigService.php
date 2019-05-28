<?php

namespace Cacheful\Client\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class ConfigService
 * @package Cacheful\Client\Service
 */
class ConfigService
{
    const CONFIG_KEY_TRIGGER_AFTER_FLUSH = 'cacheful_client/general/trigger_after_flush';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * ConfigService constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function shouldTriggerAfterFlush()
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_KEY_TRIGGER_AFTER_FLUSH);
    }

    /**
     * @return string
     */
    public function getProjectId()
    {
        return $this->scopeConfig->getValue('cacheful_client/connection/project_id');
    }

    /**
     * @return string
     */
    public function getApiToken()
    {
        return $this->scopeConfig->getValue('cacheful_client/connection/api_token');
    }
}
