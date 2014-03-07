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
 * Provider for a unique id.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class UniqRequestIdProvider implements RequestIdProvider
{
    /** @var string */
    private $uniqId;

    public function __construct()
    {
        // TODO: Maybe we could use a real UUID implementation here.
        $this->uniqId = sha1(uniqid('', true));
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
}
 