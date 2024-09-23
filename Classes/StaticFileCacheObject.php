<?php

declare(strict_types=1);

namespace SFC\Staticfilecache;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Generic object for Static File Cache incl. Logging.
 */
abstract class StaticFileCacheObject implements SingletonInterface, LoggerAwareInterface
{
    // @todo remove this "all object stuff"
    use LoggerAwareTrait;
}
