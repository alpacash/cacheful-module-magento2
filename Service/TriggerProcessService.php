<?php

namespace Cacheful\Client\Service;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

/**
 * Class TriggerProcessService
 * @package Cacheful\Client\Service
 */
class TriggerProcessService
{
    const REQUEST_URI = 'https://cacheful.app/api/projects/%s/process';

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \Cacheful\Client\Service\ConfigService
     */
    protected $configService;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * TriggerProcessService constructor.
     *
     * @param \Cacheful\Client\Service\ConfigService $configService
     * @param \Psr\Log\LoggerInterface               $logger
     */
    public function __construct(
        ConfigService $configService,
        LoggerInterface $logger
    ) {
        $this->client = new Client();
        $this->configService = $configService;
        $this->logger = $logger;
    }

    /**
     * Execute process trigger.
     *
     * @return bool
     */
    public function execute()
    {
        $projectId = $this->configService->getProjectId();
        $token = $this->configService->getApiToken();

        if (empty($projectId) || empty($token)) {
            return false;
        }

        $requestUrl = sprintf(self::REQUEST_URI, $projectId);

        try {
            $this->client->request('POST', $requestUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept'        => 'application/json',
                ]
            ]);

            return true;
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            $this->logger->error($e->getMessage());

            return false;
        }
    }
}
