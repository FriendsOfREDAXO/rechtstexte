<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Tests\Model;

use eRecht24\RechtstexteSDK\Model\Response;
use PHPUnit\Framework\TestCase;

final class ResponseTest extends TestCase
{
    public function testCanBeCreatedFromArray(): void
    {
        $response = new Response([
            "code" => 200,
            "body" => "",
        ]);
        $this->assertInstanceOf(
            Response::class,
            $response
        );
    }

    public function testCanFill(): void
    {
        $response = new Response([
            "code" => 200,
            "body" => "",
        ]);

        $updates = [
            "code" => 300,
            "body" => "Body",
        ];

        $response->fill($updates);

        foreach ($updates as $key => $value)
            $this->assertSame($value, $response->getAttribute($key));
    }

    public function testUnsetPropertiesAreNotInitialized(): void
    {
        $attributes = [
            "code" => 200,
        ];
        $response = new Response($attributes);

        $notExpectedKeys = array_diff(
            array_keys($response->getProperties()),
            array_keys($attributes)
        );

        $attributes = $response->getAttributes();
        foreach ($notExpectedKeys as $key)
            $this->assertArrayNotHasKey($key, $attributes);
    }

    public function testSetAttribute(): void
    {
        $response = new Response([
            "code" => 200,
            "body" => "",
        ]);

        $response->setCode(100);

        $this->assertSame(100, $response->getCode());
    }

    public function testGetAttribute(): void
    {
        $response = new Response([
            "code" => 200,
            "body" => "",
        ]);

        $this->assertSame("", $response->getBody());
    }

    public function testIgnoreInvalidProperties(): void
    {
        $valid = [
            "code" => 200,
            "body" => "",
        ];

        $invalid = [
            'invalid_property_1' => 'invalid',
            'invalid_property_2' => 'invalid 2',
        ];

        $response = new Response(array_merge($valid, $invalid));

        foreach ($valid as $key => $value)
            $this->assertSame($value, $response->getAttribute($key));

        foreach ($invalid as $key => $value)
            $this->assertSame(null, $response->getAttribute($key));
    }

    public function testIsSuccessWorks(): void
    {
        $response = new Response([
            "code" => 200,
            "body" => "",
        ]);

        $this->assertSame(true, $response->isSuccess());

        $response->setCode(404);
        $this->assertSame(false, $response->isSuccess());
    }

    public function testGetBodyDataByKeyWorks(): void
    {
        $response = new Response([
            "code" => 200,
            "body" => json_encode([
                "secret" => "TestSecret",
                "client_id" => 123
            ]),
        ]);

        $this->assertSame('TestSecret', $response->getBodyDataByKey('secret'));
        $this->assertSame(123, $response->getBodyDataByKey('client_id'));
        $this->assertSame(null, $response->getBodyDataByKey('invalid'));
    }

    public function testGetBodyDataAsArrayWorks(): void
    {
        $response = new Response([
            "code" => 200,
            "body" => "",
        ]);

        $this->assertSame(null, $response->getBodyDataAsArray());

        $newData = ["test" => "testValue"];
        $response->setBody(json_encode($newData));
        $this->assertSame($newData, $response->getBodyDataAsArray());
    }
}