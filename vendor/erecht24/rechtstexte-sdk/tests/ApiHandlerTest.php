<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Tests;

use eRecht24\RechtstexteSDK\ApiHandler;
use eRecht24\RechtstexteSDK\Exceptions\Exception as ERecht24Exception;
use eRecht24\RechtstexteSDK\Helper\Language as Lang;
use eRecht24\RechtstexteSDK\Model\Response;
use PHPUnit\Framework\TestCase;

final class ApiHandlerTest extends TestCase
{
    public function testCanBeCreatedFromString(): void
    {
        $client = new ApiHandler('test-api-key', 'test-plugin-key');

        $this->assertInstanceOf(ApiHandler::class, $client);
    }

    public function testLastErrorCodeAndMessage(): void
    {
        $client = new ApiHandler('test-api-key', 'test-plugin-key');
        $client->getClientList();

        // getting client list without login should fail with 401 status code
        $this->assertEquals($client->getLastErrorCode(), 401);
        $this->assertEquals($client->getLastErrorMessage(), "Invalid key for the eRecht24 API.");
        $this->assertEquals($client->getLastErrorMessage(Lang::DE_DE), "Ungültiger Schlüssel für die eRecht24 API.");
    }
}