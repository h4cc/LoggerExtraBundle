LoggerExtraBundle
=================

Symfony2 Bundle for Logging related functionality.

I could not find a bundle that could provide the following (simple) extra functionality for logging / debugging a Symfony2 Application.


Ideas for features
------------------

* Adding a unique RequestId to the logs of each request.
* Adding a unique SessionId, based on the session of the current user/authentification.
* Adding a Request Logger, that will collect basic informations about the current request.
* Adding a Response Listener, that will collect basic informations about the returned response.
* Adding arbitrary information to all logs by configuration.
* Adding log handlers to monolog by dynamic configuration.
* ... ?


References
----------

Funny enought a example for adding a request id is in a [Symfony2 Cookbook](http://symfony.com/doc/current/cookbook/logging/monolog.html#adding-some-extra-data-in-the-log-messages), but not available in a bundle.
