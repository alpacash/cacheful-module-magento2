<?php

namespace Cacheful\Client\Console\Command;

use Cacheful\Client\Service\TriggerProcessService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TriggerCommand
 * @package Cacheful\Client\Console\Command
 */
class TriggerCommand extends Command
{
    /**
     * @var \Magento\Framework\App\State
     */
    protected $state;

    /**
     * @var \Pon\BikeFinanceLease\Service\Queue\QueueProcessorService
     */
    protected $queueProcessor;

    /**
     * @var \Cacheful\Client\Service\TriggerProcessService
     */
    protected $triggerProcessService;

    /**
     * ProcessQueue constructor.
     *
     * @param \Cacheful\Client\Service\TriggerProcessService $triggerProcessService
     */
    public function __construct(
        TriggerProcessService $triggerProcessService
    ) {
        parent::__construct();

        $this->triggerProcessService = $triggerProcessService;
    }

    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('cacheful:execute');
        $this->setDescription('Trigger cache warm-up process.');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     * @throws \Exception
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->triggerProcessService->execute();
    }
}
