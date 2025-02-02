<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Tests\Service;

use eRecht24\RechtstexteSDK\Exceptions\Exception as ERecht24Exception;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service\EndpointService;
use PHPUnit\Framework\TestCase;

final class EndPointServiceTest extends TestCase
{
    /**
     * @return EndpointService
     */
    private function getEndpointService(): EndpointService
    {
        return new EndpointService('test-api-key', 'test-plugin-key');
    }

    public function testCanBeCreatedFromString(): void
    {
        $service = $this->getEndpointService();

        $this->assertInstanceOf(EndpointService::class, $service);
    }

    public function testUseGetAsDefaultMethod(): void
    {
        $service = $this->getEndpointService();

        $this->assertSame(EndpointService::HTTP_GET, $service->getMethod());
    }

    public function testCanSetValidHttpMethod(): void
    {
        $client = $this->getEndpointService();

        $client->setMethod(EndpointService::HTTP_POST);
        $this->assertSame(EndpointService::HTTP_POST, $client->getMethod());

        $client->setMethod(EndpointService::HTTP_PUT);
        $this->assertSame(EndpointService::HTTP_PUT, $client->getMethod());

        $client->setMethod(EndpointService::HTTP_DELETE);
        $this->assertSame(EndpointService::HTTP_DELETE, $client->getMethod());

        $client->setMethod(EndpointService::HTTP_GET);
        $this->assertSame(EndpointService::HTTP_GET, $client->getMethod());
    }

    public function testCanNotSetInvalidHttpMethod(): void
    {
        $client = $this->getEndpointService();

        $this->expectException(ERecht24Exception::class);
        $client->setMethod('Not valid');
    }

    public function testUseSlashAsDefaultPath(): void
    {
        $client = $this->getEndpointService();

        $this->assertSame('/', $client->getPath());
    }

    public function testCanNotUnsetPath(): void
    {
        $client = $this->getEndpointService();
        $client->setPath('');

        $this->assertSame('/', $client->getPath());
    }

    public function testPathSlashIsAutomaticallyAdded(): void
    {
        $client = $this->getEndpointService();
        $client->setPath('test');

        $this->assertSame('/test', $client->getPath());
    }

    public function testCanMakeRequest(): void
    {
        $client = $this->getEndpointService();
        $response = $client->makeRequest('/v2/clients', EndpointService::HTTP_GET);

        $this->assertInstanceOf(
            Response::class,
            $response
        );
    }
}