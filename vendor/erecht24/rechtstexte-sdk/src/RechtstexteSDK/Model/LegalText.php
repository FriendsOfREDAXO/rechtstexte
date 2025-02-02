<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Model;

use eRecht24\RechtstexteSDK\Helper\Language as Lang;

/**
 * Class LegalText
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
abstract class LegalText extends BaseModel
{
    const TEXT_TYPE_IMPRINT = 'imprint';
    const TEXT_TYPE_PRIVACY_POLICY = 'privacy_policy';
    const TEXT_TYPE_PRIVACY_POLICY_SOCIAL_MEDIA = 'privacy_policy_social_media';

    const ALLOWED_DOCUMENT_TYPES = [
        self::TEXT_TYPE_IMPRINT,
        self::TEXT_TYPE_PRIVACY_POLICY,
        self::TEXT_TYPE_PRIVACY_POLICY_SOCIAL_MEDIA,
    ];

    const ATTRIBUTE_HTML_DE = 'html_de';
    const ATTRIBUTE_HTML_EN = 'html_en';
    const ATTRIBUTE_CREATED_AT = 'created';
    const ATTRIBUTE_MODIFIED_AT = 'modified';
    const ATTRIBUTE_WARNINGS = 'warnings';
    const ATTRIBUTE_PUSHED = 'pushed';

    /**
     * allowed properties
     *
     * @var array
     */
    protected $properties = [
        self::ATTRIBUTE_HTML_DE,
        self::ATTRIBUTE_HTML_EN,
        self::ATTRIBUTE_CREATED_AT,
        self::ATTRIBUTE_MODIFIED_AT,
        self::ATTRIBUTE_WARNINGS,
        self::ATTRIBUTE_PUSHED,
    ];

    /**
     * @var string
     */
    protected $type;

    /**
     * Checks if $type is a valid document type
     *
     * @param string $type
     * @return bool
     */
    public static function isValidDocumentType(string $type): bool
    {
        return in_array($type, self::ALLOWED_DOCUMENT_TYPES);
    }

    /**
     * Provide legal text type
     *
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_CREATED_AT);
    }

    /**
     * @return string|null
     */
    public function getModifiedAt(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_MODIFIED_AT);
    }

    /**
     * @param string $lang
     * @return string|null
     */
    public function getHtml(string $lang = Lang::EN_EN): ?string
    {
        switch (strtolower($lang)) {
            case Lang::DE_DE:
                $html = $this->getAttribute(self::ATTRIBUTE_HTML_DE);
                break;

            default:
                $html = $this->getAttribute(self::ATTRIBUTE_HTML_EN);
        }

        return $html;
    }

    /**
     * @return string|null
     */
    public function getHtmlDE(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_HTML_DE);
    }

    /**
     * @return string|null
     */
    public function getHtmlEN(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_HTML_EN);
    }

    /**
     * @param string $html
     * @param string $lang
     * @return LegalText
     */
    public function setHtml(string $html, string $lang = Lang::EN_EN): LegalText
    {
        switch (strtolower($lang)) {
            case Lang::DE_DE:
                $this->setAttribute(self::ATTRIBUTE_HTML_DE, $html);
                break;

            default:
                $this->setAttribute(self::ATTRIBUTE_HTML_EN, $html);
        }

        return $this;
    }

    /**
     * @param string $html
     * @return LegalText
     */
    public function setHtmlDE(string $html): LegalText
    {
        $this->setAttribute(self::ATTRIBUTE_HTML_DE, $html);

        return $this;
    }

    /**
     * @param string $html
     * @return LegalText
     */
    public function setHtmlEN(string $html): LegalText
    {
        $this->setAttribute(self::ATTRIBUTE_HTML_EN, $html);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWarnings(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_WARNINGS);
    }

    /**
     * @param string $warnings
     * @return LegalText
     */
    public function setWarnings(string $warnings): LegalText
    {
        $this->setAttribute(self::ATTRIBUTE_WARNINGS, $warnings);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPushed(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_PUSHED);
    }

    /**
     * @param string $pushed
     * @return LegalText
     */
    public function setPushed(string $pushed): LegalText
    {
        $this->setAttribute(self::ATTRIBUTE_PUSHED, $pushed);

        return $this;
    }
}