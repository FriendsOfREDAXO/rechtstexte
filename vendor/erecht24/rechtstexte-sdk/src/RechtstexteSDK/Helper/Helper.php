<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Helper;

abstract class Helper
{
    const PUSH_TYPE_PING = 'ping';
    const PUSH_TYPE_IMPRINT = 'imprint';
    const PUSH_TYPE_PRIVACY_POLICY = 'privacyPolicy';
    const PUSH_TYPE_PRIVACY_POLICY_SOCIAL_MEDIA = 'privacyPolicySocialMedia';

    const ALLOWED_PUSH_TYPES = [
        self::PUSH_TYPE_PING,
        self::PUSH_TYPE_IMPRINT,
        self::PUSH_TYPE_PRIVACY_POLICY,
        self::PUSH_TYPE_PRIVACY_POLICY_SOCIAL_MEDIA,
    ];

    const ERECHT24_PUSH_PARAM_SECRET = 'erecht24_secret';
    const ERECHT24_PUSH_PARAM_TYPE = 'erecht24_type';

    const PING_RESPONSE = [
        'code'    => 200,
        'message' => 'pong'
    ];

    /**
     * Convert a value to studly caps case.
     *
     * @param string $value
     * @return string
     */
    public static function studly(string $value): string
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return str_replace(' ', '', $value);
    }

    /**
     * Checks if $type is a valid push type
     *
     * @param string $type
     * @return bool
     */
    public static function isValidPushType(string $type): bool
    {
        return in_array($type, self::ALLOWED_PUSH_TYPES);
    }

    /**
     * Checks if $type is a valid push type
     *
     * @return array
     */
    public static function getPingResponse(): array
    {
        return self::PING_RESPONSE;
    }

    /**
     * Checks if $type is a valid push type
     *
     * @return string
     */
    public static function getPingResponseAsJson(): string
    {
        return json_encode(self::PING_RESPONSE);
    }
}