# Create new project client
To register a new project client you need at least `push_uri` and `push_method`.
After you created a new client, you will receive its `secret` and `client_id`.
You can register up to 3 clients per project.

## Prepare the api data for the new client
There are two possible ways to fill up the new client data.
```php
$newClient = (new Client())
    ->setPushUri('https://test.de/push')        // (required) valid url
    ->setPushMethod('POST')                     // (required) either "POST" or "GET"
    ->setCms('WORDPRESS')                       // (optional)
    ->setCmsVersion('5.7.1')                    // (optional)
    ->setPluginName('erecht24/rechtstexte-wp')  // (optional)
    ->setAuthorMail('test@test.de');            // (optional)
```

```php
$newClient = new Client([
    'push_uri' => 'https://test.de/push',       // (required) valid url
    'push_method' => 'POST',                    // (required) either "POST" or "GET"
    'cms' => 'WORDPRESS',                       // (optional)
    'cms_version' => '5.7.1',                   // (optional)
    'plugin_name' => 'erecht24/rechtstexte-wp', // (optional)
    'author_mail' => 'test@test.de',            // (optional)
]);
```
We recommend using the first method.

## Request the service handler
With the [API handler](./api_handler.md) and `$newClient` you are now able to initialize and request the api.
```php
// register client to project
$client = $apiHandler->createClient($newClient);
```

## Post request processing
**Note: After you created a new client, you have to store the secret in your database. It will be used to validate push notifications.**

```php
$secret = $client->getSecret();
$client_id = $service->getClientId();
```

## Full script example
```php
use eRecht24\RechtstexteSDK\ApiHandler;
use eRecht24\RechtstexteSDK\Model\Client;

// initialize api handler
$apiHandler = new ApiHandler('YOUR-API-KEY', 'YOUR-PLUGIN-KEY');

// initialize the new client
$newClient = (new Client())
    ->setPushUri('https://test.de/push')        // (required) valid url
    ->setPushMethod('POST')                     // (required) either "POST" or "GET"
    ->setCms('WORDPRESS')                       // (optional)
    ->setCmsVersion('5.7.1')                    // (optional)
    ->setPluginName('erecht24/rechtstexte-wp')  // (optional)
    ->setAuthorMail('test@test.de');            // (optional)

try {
    // register client to project
    $client = $apiHandler->createClient($newClient);

    if ($apiHandler->isLastResponseSuccess()) {
        $secret = $client->getSecret();
        // store value to storage
        
        $client_id = $client->getClientId();
        // processing if needed  
    }

} catch (Exception $e) {
    // as you need, log or rethrow here
}
```
