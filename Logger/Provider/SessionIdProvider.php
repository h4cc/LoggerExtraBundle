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
 * Provider for session based id.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
interface SessionIdProvider
{
    /**
     * Returns the session id.
     * If there is not session id yet, NULL must be returned.
     *
     * @return string|null
     */
    public function getSessionId();
}
 