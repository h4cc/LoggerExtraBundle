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
* Adding log handlers to monolog by dynamic configuration.
* ... ?

