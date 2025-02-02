<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Model\LegalText;

use eRecht24\RechtstexteSDK\Model\LegalText;

/**
 * Class PrivacyPolicySocialMedia
 * @package eRecht24\RechtstexteSDK
 *
 * @property string html_de
 * @property string html_en
 * @property string created
 * @property string modified
 * @property string warnings
 * @property string pushed
 *
 * @property string type
 */
class PrivacyPolicySocialMedia extends LegalText
{
    const PUSH_ID = 'privacyPolicySocialMedia';

    /**
     * @var string
     */
    protected $type = self::TEXT_TYPE_PRIVACY_POLICY_SOCIAL_MEDIA;
}