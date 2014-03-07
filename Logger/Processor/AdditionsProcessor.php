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
 * The AdditionsProcessor will add the given entries to each log message.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class AdditionsProcessor
{
    private $entries;

    public function __construct(array $entries)
    {
        $this->entries = $entries;
    }

    public function processRecord(array $record)
    {
        foreach ($this->entries as $key => $value) {
            $record['extra'][$key] = $value;
        }

        return $record;
    }
}
 