<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Logger;

use Symfony\Component\HttpFoundation\Request;

/**
 * RequestLogger Interface.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
interface RequestLogger
{
    /**
     * Creating one or more log entries for the given Request
     *
     * @param Request $request
     * @return null
     */
    public function logRequest(Request $request);
}
 