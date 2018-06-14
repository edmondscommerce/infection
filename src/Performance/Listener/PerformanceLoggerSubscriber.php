<?php
/**
 * Copyright © 2017-2018 Maks Rafalko
 *
 * License: https://opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types=1);

namespace Infection\Performance\Listener;

use Infection\EventDispatcher\EventSubscriberInterface;
use Infection\Events\ApplicationExecutionFinished;
use Infection\Events\ApplicationExecutionStarted;
use Infection\Performance\Memory\MemoryFormatter;
use Infection\Performance\Memory\MemoryUsageProvider;
use Infection\Performance\Time\TimeFormatter;
use Infection\Performance\Time\Timer;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @internal
 */
final class PerformanceLoggerSubscriber implements EventSubscriberInterface
{
    /**
     * @var Timer
     */
    private $timer;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var MemoryUsageProvider
     */
    private $memoryUsageProvider;

    /**
     * @var TimeFormatter
     */
    private $timeFormatter;

    /**
     * @var MemoryFormatter
     */
    private $memoryFormatter;

    public function __construct(
        Timer $timer,
        TimeFormatter $timeFormatter,
        MemoryUsageProvider $memoryUsageProvider,
        MemoryFormatter $memoryFormatter,
        OutputInterface $output
    ) {
        $this->timer = $timer;
        $this->timeFormatter = $timeFormatter;
        $this->output = $output;
        $this->memoryUsageProvider = $memoryUsageProvider;
        $this->memoryFormatter = $memoryFormatter;
    }

    public function getSubscribedEvents(): array
    {
        return [
            ApplicationExecutionStarted::class => [$this, 'onApplicationExecutionStarted'],
            ApplicationExecutionFinished::class => [$this, 'onApplicationExecutionFinished'],
        ];
    }

    public function onApplicationExecutionStarted()
    {
        $this->timer->start();
    }

    public function onApplicationExecutionFinished()
    {
        $time = $this->timer->stop();

        $this->output->writeln([
            '',
            sprintf(
                'Time: %s. Memory: %s',
                $this->timeFormatter->toHumanReadableString($time),
                $this->memoryFormatter->toHumanReadableString($this->memoryUsageProvider->getPeakUsage())
            ),
        ]);
    }
}
