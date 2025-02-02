<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK;

use eRecht24\RechtstexteSDK\Exceptions\Exception;
use eRecht24\RechtstexteSDK\Helper\Helper;
use eRecht24\RechtstexteSDK\Helper\Language as Lang;
use eRecht24\RechtstexteSDK\Interfaces\ApiInterface;
use eRecht24\RechtstexteSDK\Interfaces\EndpointInterface;
use eRecht24\RechtstexteSDK\Model\Collection;
use eRecht24\RechtstexteSDK\Model\LegalText\Imprint;
use eRecht24\RechtstexteSDK\Model\LegalText\PrivacyPolicy;
use eRecht24\RechtstexteSDK\Model\LegalText\PrivacyPolicySocialMedia;
use eRecht24\RechtstexteSDK\Service\EndpointService;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Model\Response;

class ApiHandler implements ApiInterface
{
    /**
     * @var EndpointService
     */
    private $endpointService;

    /**
     * @var Response
     */
    protected $response;

    /**
     * ApiHandler constructor.
     *
     * @param string $apiKey
     * @param string|null $pluginKey
     * @throws Exception
     */
    public function __construct(string $apiKey, ?string $pluginKey = null)
    {
        if (is_null($pluginKey)) {
            if (false !== getenv('ERECHT24_PLUGIN_KEY')) {
                $pluginKey = getenv('ERECHT24_PLUGIN_KEY');
            } elseif (defined('ERECHT24_PLUGIN_KEY')) {
                $pluginKey = ERECHT24_PLUGIN_KEY;
            } else {
                $pluginKey = "";
            }
        }

        $this->endpointService = new EndpointService($apiKey, $pluginKey);
    }

    /**
     * @return EndpointInterface
     */
    public function getEndpointService(): EndpointInterface
    {
        return $this->endpointService;
    }

    /**
     * Provide response
     *
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * Provide response HTTP code
     *
     * @return int|null
     */
    public function getResponseCode(): ?int
    {
        if ($this->response instanceof Response) {
            $this->response->getCode();
        }

        return null;
    }

    /**
     * Provide response body
     *
     * @return string|null
     */
    public function getResponseBody(): ?string
    {
        if ($this->response instanceof Response) {
            $this->response->getBody();
        }

        return null;
    }

    /**
     * Provide response body as array
     *
     * @return array|null
     */
    public function getResponseBodyAsArray(): ?array
    {
        if ($this->response instanceof Response) {
            $this->response->getBodyDataAsArray();
        }

        return null;
    }

    /**
     * Provide status of last response
     *
     * @return bool|null
     */
    public function isLastResponseSuccess(): ?bool
    {
        if ($this->response instanceof Response) {
            return $this->response->isSuccess();
        }

        return null;
    }

    /**
     * Provide last error code
     *
     * @return int|null
     */
    public function getLastErrorCode(): ?int
    {
        if (false === $this->isLastResponseSuccess()) {
            return $this->response->getCode();
        }

        return null;
    }

    /**
     * Provide last error message
     *
     * @param string $lang
     * @return string|null
     */
    public function getLastErrorMessage(string $lang = Lang::EN_EN): ?string
    {
        if ($this->response instanceof Response) {
            return $this->response->getErrorMessage($lang);
        }

        return null;
    }

    /**
     * @return ApiInterface
     */
    public function reset(): ApiInterface
    {
        $this->response = null;

        return $this;
    }

    /**
     * ClientCreateService
     *
     * @param Client $client
     * @return Client
     * @throws Exception
     */
    public function createClient(Client $client): Client
    {
        $this->reset();

        $this->response = $this->endpointService->executeService(
            EndpointService::API_ENDPOINT_CLIENT_CREATE,
            [],
            $client->getAttributes()
        );

        if ($this->response->isSuccess()) {
            $client->setSecret($this->response->getBodyDataByKey('secret'));
            $client->setClientId($this->response->getBodyDataByKey('client_id'));
        }

        return $client;
    }

    /**
     * ClientUpdateService
     *
     * @param Client $client
     * @return Client
     * @throws Exception
     */
    public function updateClient(Client $client): Client
    {
        $this->reset();

        $this->response = $this->endpointService->executeService(
            EndpointService::API_ENDPOINT_CLIENT_UPDATE,
            [$client->getClientId()],
            $client->getAttributes()
        );

        if ($this->response->isSuccess()) {
            $client->setSecret($this->response->getBodyDataByKey('secret'));
        }

        return $client;
    }

    /**
     * ClientDeleteService
     *
     * @param Client|int $client
     * @return bool
     * @throws Exception
     */
    public function deleteClient($client): bool
    {
        $this->reset();

        if ($client instanceof Client) {
            $this->response = $this->endpointService->executeService(
                EndpointService::API_ENDPOINT_CLIENT_DELETE,
                [$client->getClientId()]
            );
        } else {
            $this->response = $this->endpointService->executeService(
                EndpointService::API_ENDPOINT_CLIENT_DELETE,
                [$client]
            );
        }


        return $this->response->isSuccess();
    }

    /**
     * ClientListService
     *
     * @return Collection
     * @throws Exception
     */
    public function getClientList(): Collection
    {
        $this->reset();

        $this->response = $this->endpointService->executeService(EndpointService::API_ENDPOINT_CLIENT_LIST);

        $result = new Collection();
        if ($this->response->isSuccess()) {
            foreach ($this->response->getBodyDataAsArray() as $clientData) {
                $result->add(new Client($clientData));
            }

        }

        return $result;
    }

    /**
     * ImprintGetService
     *
     * @return Imprint
     * @throws Exception
     */
    public function getImprint(): Imprint
    {
        $this->reset();

        $this->response = $this->endpointService->executeService(EndpointService::API_ENDPOINT_IMPRINT_GET);

        if ($this->response->isSuccess()) {
            return new Imprint($this->response->getBodyDataAsArray());
        }

        return new Imprint();
    }

    /**
     * PrivacyPolicyGetService
     *
     * @return PrivacyPolicy
     * @throws Exception
     */
    public function getPrivacyPolicy(): PrivacyPolicy
    {
        $this->reset();

        $this->response = $this->endpointService->executeService(EndpointService::API_ENDPOINT_PRIVATE_POLICY_GET);

        if ($this->response->isSuccess()) {
            return new PrivacyPolicy($this->response->getBodyDataAsArray());
        }

        return new PrivacyPolicy();
    }

    /**
     * PrivacyPolicySocialMediaGetService
     *
     * @return PrivacyPolicySocialMedia
     * @throws Exception
     */
    public function getPrivacyPolicySocialMedia(): PrivacyPolicySocialMedia
    {
        $this->reset();

        $this->response = $this->endpointService->executeService(EndpointService::API_ENDPOINT_PRIVATE_POLICY_SOCIAL_GET);

        if ($this->response->isSuccess()) {
            return new PrivacyPolicySocialMedia($this->response->getBodyDataAsArray());
        }

        return new PrivacyPolicySocialMedia();
    }

    /**
     * MessageGetService
     *
     * @param string $lang
     * @return null|string
     * @throws Exception
     */
    public function getMessage(string $lang = Lang::EN_EN): ?string
    {
        $this->reset();

        $this->response = $this->endpointService->executeService(EndpointService::API_ENDPOINT_MESSAGE_GET);

        if ($this->response->isSuccess()) {
            return $this->response->getMessage($lang);
        }

        return null;
    }

    /**
     * TestPushService
     *
     * @param int $clientId
     * @param string $type
     * @return bool
     * @throws Exception
     */
    public function fireTestPush(int $clientId, string $type = 'ping'): bool
    {
        $this->reset();

        $this->response = $this->endpointService->executeService(
            EndpointService::API_ENDPOINT_TEST_PUSH,
            [$clientId],
            ['type' => $type]
        );

        return $this->response->isSuccess();
    }
}