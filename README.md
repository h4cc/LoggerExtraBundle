LoggerExtraBundle
=================

[![Build Status](https://travis-ci.org/h4cc/LoggerExtraBundle.png?branch=master)](https://travis-ci.org/h4cc/LoggerExtraBundle)
[![Latest Stable Version](https://poser.pugx.org/silpion/logger-extra-bundle/v/stable.png)](https://packagist.org/packages/silpion/logger-extra-bundle)
[![License](https://poser.pugx.org/silpion/logger-extra-bundle/license.png)](https://packagist.org/packages/silpion/logger-extra-bundle)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/h4cc/LoggerExtraBundle/badges/quality-score.png?s=b72d47d970efc18d3bda7fa8cafb50572f075d77)](https://scrutinizer-ci.com/g/h4cc/LoggerExtraBundle/)
[![Code Coverage](https://scrutinizer-ci.com/g/h4cc/LoggerExtraBundle/badges/coverage.png?s=e4481b53f54f85b768fcc5f8cce170f53e6faf30)](https://scrutinizer-ci.com/g/h4cc/LoggerExtraBundle/)
[![HHVM Status](http://hhvm.h4cc.de/badge/silpion/logger-extra-bundle.png)](http://hhvm.h4cc.de/package/silpion/logger-extra-bundle)
[![Dependency Status](https://www.versioneye.com/php/silpion:logger-extra-bundle/dev-master/badge.png)](https://www.versioneye.com/php/silpion:logger-extra-bundle/dev-master)
[![Project Status](http://stillmaintained.com/h4cc/LoggerExtraBundle.png)](http://stillmaintained.com/h4cc/LoggerExtraBundle)

Symfony2 Bundle for Logging related functionality. This bundle can give you these features:

* Add a unique RequestId to each message of the current request.
* Add a unique SessionId to each message dependent on current session id.
* Add arbitrary "key: value" pairs to each message of the current request.
* Create a log entry on a MASTER Request.
* Create a log entry on a Response.

There is also a Stack Middleware for logging Requests and Responses:
[silpion/stack-logger](https://github.com/h4cc/StackLogger)

Installation
------------------

Using Composer:

```
php composer.phar require silpion/logger-extra-bundle
```

Also add SilpionLoggerExtraBundle to your AppKernel:

```
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            ...
            new Silpion\LoggerExtraBundle\SilpionLoggerExtraBundle(),
        );
        ...
    }
}
```

Configuration
------------------

By default, this bundle will not do anything!
Every feature has to be enabled on its own.

Example configuration:
```
silpion_logger_extra:

    # If a random request_id should be added to the [extra] section of each log message.
    request_id:           true

    # If a salted SHA1 of the session_id should be added to the [extra] section of each log message.
    session_id:           true

    # A list of "key: value" entries that will be set in the [extra] section of each log message (Overwrites existing keys!).
    additions:
        server_id: 42

    logger:

        # Will create a log entry on each incoming request.
        on_request:           true

        # Will create a log entry on each outgoing response.
        on_response:          true
```


Usage
-----------------

If you want to use the current RequestId or SessionId somewhere in your application, see this code:

```
$requestId = $this->get('silpion_logger_extra')->getRequestId();
$sessionId = $this->get('silpion_logger_extra')->getSessionId();
```


References
----------

Funny enough a example for adding a RequestId is in a [Symfony2 Cookbook](http://symfony.com/doc/current/cookbook/logging/monolog.html#adding-some-extra-data-in-the-log-messages), but not available in a bundle till now.
