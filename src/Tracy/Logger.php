<?php

declare(strict_types=1);

namespace Contributte\NewRelic\Tracy;

use Tracy\Debugger;
use Tracy\ILogger;

class Logger implements ILogger
{

	/**
	 * @var \Tracy\ILogger
	 */
	private $oldLogger;

	/**
	 * @var string[]
	 */
	private $logLevels;

	/**
	 * @param array $logLevels
	 */
	public function __construct(array $logLevels)
	{
		$this->oldLogger = Debugger::getLogger();
		$this->logLevels = $logLevels;
	}

	/**
	 * @param string|array $message
	 * @param string $priority
	 * @return string logged error filename
	 */
	public function log($message, $priority = null)
	{
		$exceptionFile = $this->oldLogger->log($message, $priority);

		if (in_array($priority, $this->logLevels)) {
			if (is_array($message)) {
				$message = implode(' ', $message);
			}

			newrelic_notice_error($message);
		}

		return $exceptionFile;
	}

}
