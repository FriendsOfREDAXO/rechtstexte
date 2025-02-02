<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Tests;

use eRecht24\RechtstexteSDK\LegalTextHandler;
use eRecht24\RechtstexteSDK\Model\LegalText;
use PHPUnit\Framework\TestCase;

final class LegalTextHandlerTest extends TestCase
{
    public function testCanBeCreatedWithoutPluginKey(): void
    {
        foreach (LegalText::ALLOWED_DOCUMENT_TYPES as $documentType) {
            $legalTextHandler = new LegalTextHandler('test-api-key', $documentType);
            $this->assertInstanceOf(LegalTextHandler::class, $legalTextHandler);
        }
    }
}