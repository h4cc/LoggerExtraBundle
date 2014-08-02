<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Logger\Provider\Request;

use Silpion\LoggerExtraBundle\Logger\Provider\RequestIdProvider;

/**
 * Provider for a enriched request id.
 *
 * Influenced by http://docs.mongodb.org/manual/reference/object-id/
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class EnrichedRequestIdProvider implements RequestIdProvider
{
    /** @var string */
    private $uniqId;

    public function __construct()
    {
        $this->uniqId = $this->createMongoDbLikeId(time(), php_uname('n'), posix_getpid(), 0);
    }

    /**
     * Returns the request id.
     *
     * @return string
     */
    public function getRequestId()
    {
        return $this->uniqId;
    }

    private function createMongoDbLikeId($timestamp, $hostname, $processId, $id)
    {
        // Building binary data.
        $bin = sprintf(
            "%s%s%s%s",
            pack('N', $timestamp),
            substr(md5($hostname), 0, 3),
            pack('n', $processId),
            substr(pack('N', $id), 1, 3)
        );

        // Convert binary to hex.
        $result = '';
        for ($i = 0; $i < 12; $i++) {
            $result .= sprintf("%02x", ord($bin[$i]));
        }

        return $result;
    }
}
 