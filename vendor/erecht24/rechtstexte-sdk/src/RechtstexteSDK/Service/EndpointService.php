<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Service;

use eRecht24\RechtstexteSDK\Interfaces\EndpointInterface;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Exceptions\Exception;

class EndpointService implements EndpointInterface
{
    const HTTP_GET = "GET";
    const HTTP_POST = "POST";
    const HTTP_PUT = "PUT";
    const HTTP_DELETE = "DELETE";

    const API_SCHEME = "https";
    const API_HOST = "api.e-recht24.de";

    const API_ENDPOINT_PREFIX = '/v2';
    const API_ENDPOINT_CLIENTS = self::API_ENDPOINT_PREFIX . '/clients';
    const API_ENDPOINT_CLIENT_CREATE = 'client_create';
    const API_ENDPOINT_CLIENT_UPDATE = 'client_update';
    const API_ENDPOINT_CLIENT_DELETE = 'client_delete';
    const API_ENDPOINT_CLIENT_LIST = 'client_list';
    const API_ENDPOINT_IMPRINT_GET = 'imprint_get';
    const API_ENDPOINT_PRIVATE_POLICY_GET = 'private_policy_get';
    const API_ENDPOINT_PRIVATE_POLICY_SOCIAL_GET = 'private_policy_social_get';
    const API_ENDPOINT_MESSAGE_GET = 'message_get';
    const API_ENDPOINT_TEST_PUSH = 'test_push';

    const API_ENDPOINT_DEFINITION_METHOD = 'method';
    const API_ENDPOINT_DEFINITION_PATH = 'path';
    const API_ENDPOINTS = [
        self::API_ENDPOINT_CLIENT_CREATE => [
            self::API_ENDPOINT_DEFINITION_METHOD => self::HTTP_POST,
            self::API_ENDPOINT_DEFINITION_PATH => self::API_ENDPOINT_CLIENTS,
        ],
        self::API_ENDPOINT_CLIENT_UPDATE => [
            self::API_ENDPOINT_DEFINITION_METHOD => self::HTTP_PUT,
            self::API_ENDPOINT_DEFINITION_PATH => self::API_ENDPOINT_CLIENTS . '/%s',
        ],
        self::API_ENDPOINT_CLIENT_DELETE => [
            self::API_ENDPOINT_DEFINITION_METHOD => self::HTTP_DELETE,
            self::API_ENDPOINT_DEFINITION_PATH => self::API_ENDPOINT_CLIENTS . '/%s',
        ],
        self::API_ENDPOINT_CLIENT_LIST => [
            self::API_ENDPOINT_DEFINITION_METHOD => self::HTTP_GET,
            self::API_ENDPOINT_DEFINITION_PATH => self::API_ENDPOINT_CLIENTS,
        ],
        self::API_ENDPOINT_IMPRINT_GET => [
            self::API_ENDPOINT_DEFINITION_METHOD => self::HTTP_GET,
            self::API_ENDPOINT_DEFINITION_PATH => self::API_ENDPOINT_PREFIX . '/imprint',
        ],
        self::API_ENDPOINT_PRIVATE_POLICY_GET => [
            self::API_ENDPOINT_DEFINITION_METHOD => self::HTTP_GET,
            self::API_ENDPOINT_DEFINITION_PATH => self::API_ENDPOINT_PREFIX . '/privacyPolicy',
        ],
        self::API_ENDPOINT_PRIVATE_POLICY_SOCIAL_GET => [
            self::API_ENDPOINT_DEFINITION_METHOD => self::HTTP_GET,
            self::API_ENDPOINT_DEFINITION_PATH => self::API_ENDPOINT_PREFIX . '/privacyPolicySocialMedia',
        ],
        self::API_ENDPOINT_MESSAGE_GET => [
            self::API_ENDPOINT_DEFINITION_METHOD => self::HTTP_GET,
            self::API_ENDPOINT_DEFINITION_PATH => self::API_ENDPOINT_PREFIX . '/message',
        ],
        self::API_ENDPOINT_TEST_PUSH => [
            self::API_ENDPOINT_DEFINITION_METHOD => self::HTTP_POST,
            self::API_ENDPOINT_DEFINITION_PATH => self::API_ENDPOINT_CLIENTS . '/%s/testPush',
        ],
    ];

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $pluginKey;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $postFields;

    /**
     * EndpointService constructor.
     *
     * @param string $apiKey
     * @param string $pluginKey
     * @throws Exception
     */
    public function __construct(string $apiKey, string $pluginKey)
    {
        $this->checkBasicFunctions();

        $this->apiKey = $apiKey;
        $this->pluginKey = $pluginKey;
    }

    /**
     * Check functions/extensions needed
     *
     * @throws Exception
     */
    private function checkBasicFunctions()
    {
        if (!function_exists("curl_init") ||
            !function_exists("curl_setopt") ||
            !function_exists("curl_exec") ||
            !function_exists("curl_close"))
            throw new Exception('Required cURL Functions does not exist');
    }

    /**
     * Execute service request
     *
     * @param string $endPointId
     * @param array|null $urlParams
     * @param array|null $postFields
     * @return Response
     * @throws Exception
     */
    public function executeService(
        string $endPointId,
        ?array $urlParams = [],
        ?array $postFields = null
    ): Response
    {
        if (!array_key_exists($endPointId, self::API_ENDPOINTS))
            throw new Exception('invalid service id', 500);

        $endPointData = self::API_ENDPOINTS[$endPointId];
        $this->setPath(vsprintf($endPointData[self::API_ENDPOINT_DEFINITION_PATH], $urlParams))
            ->setMethod($endPointData[self::API_ENDPOINT_DEFINITION_METHOD])
            ->setPostFields($postFields);

        return $this->makeRequest(
            $this->getFullUrl(),
            $this->getMethod(),
            $this->getPostFields()
        );
    }

    /**
     * make cURL request
     *
     * @param string $url
     * @param string $method
     * @param array|null $postData
     * @return Response
     * @throws Exception
     */
    public function makeRequest(
        string $url,
        string $method,
        ?array $postData = null
    ): Response
    {
        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'cache-control: no-cache',
                'content-type: application/json',
                sprintf('eRecht24-api-key: %s', $this->getApiKey()),
                sprintf('eRecht24-plugin-key: %s', $this->getPluginKey())
            ]);

            if (!empty($postData))
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

            $response = curl_exec($ch);
            $httpCode = intval(curl_getinfo($ch, CURLINFO_HTTP_CODE));

            // close curl resource to free up system resources
            curl_close($ch);

        } catch (\Exception $e) {
            throw new Exception(
                sprintf('Unable to make Request. %s', $e->getMessage()),
                500,
                $e
            );
        }

        return new Response([
            'code' => $httpCode,
            'body' => $response
        ]);
    }

    /**
     * Provide API key for authorisation
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Provide plugin key for authorisation
     *
     * @return string
     */
    public function getPluginKey(): string
    {
        return $this->pluginKey;
    }

    /**
     * Provides full url for cURL
     *
     * @return string
     */
    public function getFullUrl(): string
    {
        if (function_exists('http_build_url'))
            return http_build_url(self::API_HOST, [
                "scheme" => self::API_SCHEME,
                "host" => self::API_HOST,
                "path" => $this->getPath(),
            ]);

        return sprintf('%s://%s%s',
            self::API_SCHEME,
            self::API_HOST,
            $this->getPath()
        );
    }

    /**
     * Set HTTP method for cURL
     *
     * @param string $method
     * @return EndpointInterface
     * @throws Exception
     */
    public function setMethod(string $method): EndpointInterface
    {
        if (!in_array($method, [self::HTTP_GET, self::HTTP_POST, self::HTTP_PUT, self::HTTP_DELETE]))
            throw new Exception('Invalid HTTP method specified.');

        $this->method = $method;

        return $this;
    }

    /**
     * Provide HTTP method for cURL
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method ?: self::HTTP_GET;
    }

    /**
     * Set path for url generation
     *
     * @param string $path
     * @return EndpointInterface
     */
    public function setPath(string $path): EndpointInterface
    {
        if (0 === strpos($path, '/')) {
            $this->path = $path;
        } else {
            $this->path = '/' . $path;
        }

        return $this;
    }

    /**
     * Provide path for url generation
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path ?: '/';
    }

    /**
     * Set post fields for Request
     *
     * @param array|null $postFields
     * @return EndpointInterface
     */
    public function setPostFields(?array $postFields): EndpointInterface
    {
        $this->postFields = $postFields;

        return $this;
    }

    /**
     * Provide post fields for request
     *
     * @return ?array
     */
    public function getPostFields(): ?array
    {
        return $this->postFields;
    }

    /**
     * @return EndpointInterface
     */
    public function reset(): EndpointInterface
    {
        $this->path = null;
        $this->method = null;
        $this->postFields = [];

        return $this;
    }
}