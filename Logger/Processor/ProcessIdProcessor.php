<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Logger\Processor;

/**
 * The ProcessIdProcessor will add the current PID to each processed log message.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class ProcessIdProcessor
{
    public function processRecord(array $record)
    {
        // Do not add if key already exists.
        if (!isset($record['extra']['process_id'])) {

            // Always using the current PID, because PHP might fork with pcntl_fork().
            $record['extra']['process_id'] = getmypid();
        }

        return $record;
    }
}
 