<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Tests\Model;

use eRecht24\RechtstexteSDK\Model\Client;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    public function testCanBeCreatedFromArray(): void
    {
        $client = new Client([
            "client_id" => 1,
            "project_id" => 2,
            "push_method" => "GET",
            "push_uri" => "https://www.test.de",
            "cms" => "WORDPRESS",
            "cms_version" => "1.0.0",
            "plugin_name" => "custom_plugin",
            "author_mail" => "author@example.com",
            "created_at" => "2021-06-01",
            "updated_at" => "2021-06-01",
        ]);

        $this->assertInstanceOf(
            Client::class,
            $client
        );
    }

    public function testCanFill(): void
    {
        $client = new Client([
            "client_id" => 1,
            "project_id" => 2,
            "push_method" => "GET",
            "push_uri" => "https://www.test.de",
            "cms" => "WORDPRESS",
            "cms_version" => "1.0.0",
            "plugin_name" => "custom_plugin",
            "author_mail" => "author@example.com",
            "created_at" => "2021-06-01",
            "updated_at" => "2021-06-01",
        ]);

        $updates = [
            "cms" => "JOOMLA",
            "cms_version" => "2.0.0",
        ];

        $client->fill($updates);

        foreach ($updates as $key => $value)
            $this->assertSame($value, $client->getAttribute($key));
    }

    public function testUnsetPropertiesAreIgnoredInitially(): void
    {
        $client = new Client([
            "client_id" => 1,
            "project_id" => 2,
        ]);

        $expected = [
            "client_id" => 1,
            "project_id" => 2,
        ];

        $attributes = $client->getAttributes();

        $this->assertSame($expected, $attributes);
    }

    public function testSetAttribute(): void
    {
        $client = new Client([
            "client_id" => 1,
            "project_id" => 2,
        ]);

        $client->setClientId(100);

        $this->assertSame(100, $client->getClientId());
    }

    public function testGetAttribute(): void
    {
        $client = new Client([
            "client_id" => 1,
            "project_id" => 2,
        ]);

        $this->assertSame(1, $client->getClientId());
    }

    public function testIgnoreInvalidProperties(): void
    {
        $valid = [
            "client_id" => 1,
            "project_id" => 2,
            "push_method" => "GET",
            "push_uri" => "https://www.test.de",
            "cms" => "WORDPRESS",
            "cms_version" => "1.0.0",
            "plugin_name" => "custom_plugin",
            "author_mail" => "author@example.com",
            "created_at" => "2021-06-01",
            "updated_at" => "2021-06-01",
        ];

        $invalid = [
            'invalid_property_1' => 'invalid',
            'invalid_property_2' => 'invalid 2',
        ];

        $client = new Client(array_merge($valid, $invalid));

        foreach ($valid as $key => $value)
            $this->assertSame($value, $client->getAttribute($key));

        foreach ($invalid as $key => $value)
            $this->assertSame(null, $client->getAttribute($key));
    }
}