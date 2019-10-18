<?php

namespace Cacheful\Client\Observer;

use Cacheful\Client\Service\ConfigService;
use Cacheful\Client\Service\TriggerProcessService;
use GuzzleHttp\Exception\GuzzleException;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class TriggerCacheWarmupObserver
 * @package Cacheful\Client\Observer
 */
class TriggerCacheWarmUpObserver implements ObserverInterface
{
    /**
     * @var \Cacheful\Client\Service\TriggerProcessService
     */
    protected $triggerProcessService;

    /**
     * @var \Cacheful\Client\Service\ConfigService
     */
    protected $configService;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * TriggerCacheWarmUpObserver constructor.
     *
     * @param \Cacheful\Client\Service\TriggerProcessService $triggerProcessService
     * @param \Cacheful\Client\Service\ConfigService         $configService
     * @param \Magento\Framework\Message\ManagerInterface    $messageManager
     */
    public function __construct(
        TriggerProcessService $triggerProcessService,
        ConfigService $configService,
        ManagerInterface $messageManager
    ) {
        $this->triggerProcessService = $triggerProcessService;
        $this->configService = $configService;
        $this->messageManager = $messageManager;
    }

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        if (\php_sapi_name() === 'cli' || ! $this->configService->shouldTriggerAfterFlush()) {
            return;
        }

        try {
            $this->triggerProcessService->execute();
            $this->messageManager->addSuccessMessage("Successfully triggered cache warm-up!");
        } catch (\Exception | GuzzleException $e) {
            $this->messageManager->addErrorMessage("Something went wrong while triggering the cache warm-up.");
        }
    }
}
