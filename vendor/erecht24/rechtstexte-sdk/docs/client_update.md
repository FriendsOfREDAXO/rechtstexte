# Create new project client
To update an existing project client you need at least the `client_id`.
After you updated a client, you will receive a new secret for it.

## Prepare the updated data for the client
There are two possible ways to fill up the client data.
```php
$updatedClientData = (new Client())
    ->setClientId(1792)                     // (required)
    ->setPushUri('https://test.de/push')
    ->setPushMethod('POST')
    ->setAuthorMail('test@test.de');
```

```php
$updatedClientData = new Client([
    'client_id' => 1792,                    // (required)
    'push_uri' => 'https://test.de/push',
    'push_method' => 'POST',
    'author_mail' => 'test@test.de',
]);
```
We recommend using the first method.

## Request the service handler
With the [API handler](./api_handler.md) and `$updatedClientData` you are now able to initialize and request the api.
```php
// update project client
$client = $apiHandler->updateClient($updatedClientData);
```

## Post request processing
**Note: After you updated a project client, you have to store the new secret in your database. It will be used to validate push notifications.**

```php
$secret = $client->getSecret();
```

## Full script example
```php
use eRecht24\RechtstexteSDK\ApiHandler;
use eRecht24\RechtstexteSDK\Model\Client;

// initialize api handler
$apiHandler = new ApiHandler('YOUR-API-KEY', 'YOUR-PLUGIN-KEY');

// initialize the updated client data
$updatedClientData = (new Client())
    ->setClientId(1792)                     // (required)
    ->setPushUri('https://test.de/push')
    ->setPushMethod('POST')
    ->setAuthorMail('test@test.de');

try {
    // update project client
    $client = $apiHandler->updateClient($newClient);

    if ($apiHandler->isLastResponseSuccess()) {
        $secret = $client->getSecret();
        // update new value in storage
    }

} catch (Exception $e) {
    // as you need, log or rethrow here
}
```
