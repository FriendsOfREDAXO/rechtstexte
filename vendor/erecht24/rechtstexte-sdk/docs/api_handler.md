# The API handler class
In order to minimize dependencies, our api handler provides all functions on top of the [cURL Library](https://www.php.net/manual/en/book.curl.php).

## The service
Get the main service handler with your `api_key` and `plugin_key`.
```php
use eRecht24\RechtstexteSDK\ApiHandler;

// initialize api handler
$apiHandler = new ApiHandler('YOUR-API-KEY', 'YOUR-PLUGIN-KEY');
```

## The interface
The API handler implements the following interface.
```php
interface ApiInterface
{
    /**
     * @return EndpointInterface
     */
    public function getEndpointService(): EndpointInterface;

    /**
     * @return Response
     */
    public function getResponse(): Response;

    /**
     * @return int|null
     */
    public function getResponseCode(): ?int;

    /**
     * @return string|null
     */
    public function getResponseBody(): ?string;

    /**
     * @return array|null
     */
    public function getResponseBodyAsArray(): ?array;

    /**
     * @return bool|null
     */
    public function isLastResponseSuccess(): ?bool;

    /**
     * @return int|null
     */
    public function getLastErrorCode(): ?int;

    /**
     * @param string $lang
     * @return string|null
     */
    public function getLastErrorMessage(string $lang = Lang::EN_EN): ?string;

    /**
     * @return ApiInterface
     */
    public function reset(): ApiInterface;

    /**
     * Register a new client with your project
     *
     * @param Client $client
     * @return Client
     */
    public function createClient(Client $client): Client;

    /**
     * Update the any client information
     *
     * @param Client $client
     * @return Client
     */
    public function updateClient(Client $client): Client;

    /**
     * Remove a client from your project
     *
     * @param Client|int $client
     * @return bool
     */
    public function deleteClient($client): bool;

    /**
     * Get the clients related to your project
     *
     * @return Collection
     */
    public function getClientList(): Collection;

    /**
     * Get the actual imprint text (all languages) for your project
     *
     * @return Imprint
     */
    public function getImprint(): Imprint;

    /**
     * Get the actual privacy policy text (all languages) for your project
     *
     * @return PrivacyPolicy
     */
    public function getPrivacyPolicy(): PrivacyPolicy;

    /**
     * Get the actual privacy policy social media text (all languages) for your project
     *
     * @return PrivacyPolicySocialMedia
     */
    public function getPrivacyPolicySocialMedia(): PrivacyPolicySocialMedia;

    /**
     * Get a message from the server
     *
     * @param string $lang
     * @return null|string
     */
    public function getMessage(string $lang = Lang::EN_EN): ?string;

    /**
     * Trigger the server to push a notification (default ping)
     * to your client for testing intention
     *
     * @param int $clientId
     * @param string $type
     * @return bool
     */
    public function fireTestPush(int $clientId, string $type = 'ping'): bool;
}
```

## Troubleshooting
In case of an error there are multiple methods an properties for further processing.

### Check if response was not successful
```php
if (!$apiHandler->isLastResponseSuccess()) {
    // do stuff in case of success
}
```

### Get last response
```php
/* @var \eRecht24\RechtstexteSDK\Model\Response $response */
$response = $apiHandler->getResponse();
```

### Get last response status code
```php
/* @var \eRecht24\RechtstexteSDK\Model\Response $response */
$statusCode = $apiHandler->getResponseCode();
```

### Get last response body as array
```php
/* @var \eRecht24\RechtstexteSDK\Model\Response $response */
$bodyAsArray = $apiHandler->getResponseBodyAsArray();
```

### Retrieve last response raw body
```php
/* @var \eRecht24\RechtstexteSDK\Model\Response $response */
$body = $apiHandler->getResponseBody();
```

### Get error message from failed response
```php
if (!$apiHandler->isLastResponseSuccess()) {
    // get error message (default en)
    $errorMessage = $apiHandler->getLastErrorMessage();
    // get DE error message
    $errorMessage = $apiHandler->getLastErrorMessage('de');
}
```
