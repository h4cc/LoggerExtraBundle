<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Logger\Provider;

/**
 * Interface for providing a request based id.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
interface RequestIdProvider
{
    /**
     * Returns the request id.
     *
     * @return string
     */
    public function getRequestId();
}
 