<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Tests\Model;

use eRecht24\RechtstexteSDK\Model\LegalText;
use eRecht24\RechtstexteSDK\Model\LegalText\Imprint;
use PHPUnit\Framework\TestCase;

final class LegalTextTest extends TestCase
{
    public function testCanBeCreatedFromArray(): void
    {
        $legalText = new Imprint([
            "html_de" => "Impressum",
            "html_en" => "Imprint",
            "created" => "2021-06-01",
            "modified" => "2021-06-01",
            "warnings" => "",
            "pushed" => "2021-06-01",
        ]);
        $this->assertInstanceOf(
            LegalText::class,
            $legalText
        );
    }

    public function testCanFill(): void
    {
        $legalText = new Imprint([
            "html_de" => "Impressum",
            "html_en" => "Imprint",
            "created" => "2021-06-01",
            "modified" => "2021-06-01",
            "warnings" => "",
            "pushed" => "2021-06-01",
        ]);

        $updates = [
            "html_de" => "Impressum neu",
            "html_en" => "Imprint new",
        ];

        $legalText->fill($updates);

        foreach ($updates as $key => $value)
            $this->assertSame($value, $legalText->getAttribute($key));
    }

    public function testUnsetPropertiesAreNotInitialized(): void
    {
        $attributes = [
            "html_de" => "html_de",
            "html_en" => "html_en",
        ];
        $legalText = new Imprint($attributes);

        $notExpectedKeys = array_diff(
            array_keys($legalText->getProperties()),
            array_keys($attributes)
        );

        $attributes = $legalText->getAttributes();
        foreach ($notExpectedKeys as $key)
            $this->assertArrayNotHasKey($key, $attributes);
    }

    public function testSetAttribute(): void
    {
        $legalText = new Imprint();

        $legalText->setAttribute('created', '100');

        $this->assertSame('100', $legalText->getCreatedAt());
    }

    public function testGetAttribute(): void
    {
        $legalText = new Imprint([
            "created" => 1,
        ]);

        $this->assertSame(1, $legalText->getAttribute('created'));
    }

    public function testIgnoreInvalidProperties(): void
    {
        $valid = [
            "html_de" => "Impressum",
            "html_en" => "Imprint",
            "created" => "2021-06-01",
            "modified" => "2021-06-01",
            "warnings" => "",
            "pushed" => "2021-06-01",
        ];

        $invalid = [
            'invalid_property_1' => 'invalid',
            'invalid_property_2' => 'invalid 2',
        ];

        $legalText = new Imprint(array_merge($valid, $invalid));

        foreach ($valid as $key => $value)
            $this->assertSame($value, $legalText->getAttribute($key));

        foreach ($invalid as $key => $value)
            $this->assertSame(null, $legalText->getAttribute($key));
    }
}