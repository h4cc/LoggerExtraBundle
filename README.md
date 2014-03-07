LoggerExtraBundle
=================

Symfony2 Bundle for Logging related functionality. This bundle can give you these features:

* Add a unique RequestId to each message of the current request.
* Add a unique SessionId to each message dependent on current session id.
* Add arbitrary "key: value" pairs to each message of the current request.


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
```

Ideas for features
------------------

* (Adding a unique RequestId to the logs of each request. IMPLEMENTED)
* (Adding a unique SessionId, based on the session of the current user/authentification. IMPLEMENTED)
* (Adding arbitrary information to all logs by configuration. IMPLEMENTED)
* Adding a Request Logger, that will collect basic informations about the current request.
* Adding a Response Listener, that will collect basic informations about the returned response.
* Adding log handlers to monolog by dynamic configuration.
* ... ?


References
----------

Funny enough a example for adding a RequestId is in a [Symfony2 Cookbook](http://symfony.com/doc/current/cookbook/logging/monolog.html#adding-some-extra-data-in-the-log-messages), but not available in a bundle till now.
