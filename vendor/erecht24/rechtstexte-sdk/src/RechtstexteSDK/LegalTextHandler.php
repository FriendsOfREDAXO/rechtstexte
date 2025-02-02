<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK;

use eRecht24\RechtstexteSDK\Exceptions\Exception;
use eRecht24\RechtstexteSDK\Helper\Helper;
use eRecht24\RechtstexteSDK\Model\LegalText;
use eRecht24\RechtstexteSDK\Model\LegalText\Imprint;
use eRecht24\RechtstexteSDK\Model\LegalText\PrivacyPolicy;
use eRecht24\RechtstexteSDK\Model\LegalText\PrivacyPolicySocialMedia;

/**
 * Wrapper class for legal text types
 */
class LegalTextHandler extends ApiHandler
{
    /**
     * @var Imprint|PrivacyPolicy|PrivacyPolicySocialMedia|LegalText
     */
    protected $document;

    /**
     * LegalTextHandler constructor.
     *
     * @param string $apiKey
     * @param string $documentType
     * @param string|null $pluginKey
     * @throws Exception
     */
    public function __construct(string $apiKey, string $documentType, ?string $pluginKey = null)
    {
        parent::__construct($apiKey, $pluginKey);

        switch ($documentType) {
            case Helper::PUSH_TYPE_IMPRINT:
            case LegalText::TEXT_TYPE_IMPRINT:
                /* @var Imprint */
                $this->document = new Imprint();
                break;

            case Helper::PUSH_TYPE_PRIVACY_POLICY:
            case LegalText::TEXT_TYPE_PRIVACY_POLICY:
                /* @var PrivacyPolicy */
                $this->document = new PrivacyPolicy();
                break;

            case Helper::PUSH_TYPE_PRIVACY_POLICY_SOCIAL_MEDIA:
            case LegalText::TEXT_TYPE_PRIVACY_POLICY_SOCIAL_MEDIA:
                /* @var PrivacyPolicySocialMedia */
                $this->document = new PrivacyPolicySocialMedia();
                break;

            default:
                throw new Exception('Invalid legal text type.');
        }
    }

    /**
     * Provides eRecht24 legal document import
     *
     * @return LegalText|null $response
     * @throws Exception
     */
    public function importDocument(): ?LegalText
    {
        switch ($this->document->getType()) {
            case LegalText::TEXT_TYPE_IMPRINT:
                $this->document = $this->getImprint();
                break;

            case LegalText::TEXT_TYPE_PRIVACY_POLICY:
                $this->document = $this->getPrivacyPolicy();
                break;

            case LegalText::TEXT_TYPE_PRIVACY_POLICY_SOCIAL_MEDIA:
                $this->document = $this->getPrivacyPolicySocialMedia();
                break;
        }

        return $this->document;
    }

    /**
     * @return LegalText
     */
    public function getDocument(): LegalText
    {
        return $this->document;
    }
}
