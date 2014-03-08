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
use Symfony\Component\HttpFoundation\Response;

/**
 * ResponseLogger Interface.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
interface ResponseLogger
{
    /**
     * Creating one or more log entries for the Response and Request.     *
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param Request $request
     * @return null
     */
    public function logResponse(Response $response, Request $request);
}
 