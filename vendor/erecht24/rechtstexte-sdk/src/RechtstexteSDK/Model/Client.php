<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Model;

/**
 * Class Client
 * @package eRecht24\RechtstexteSDK
 *
 * @property int client_id
 * @property int project_id
 * @property string push_method
 * @property string push_uri
 * @property string cms
 * @property string cms_version
 * @property string plugin_name
 * @property string author_mail
 * @property string created_at
 * @property string updated_at
 */
class Client extends BaseModel
{
    const ATTRIBUTE_CLIENT_ID = 'client_id';
    const ATTRIBUTE_PROJECT_ID = 'project_id';
    const ATTRIBUTE_PUSH_METHOD = 'push_method';
    const ATTRIBUTE_PUSH_URI = 'push_uri';
    const ATTRIBUTE_CMS = 'cms';
    const ATTRIBUTE_CMS_VERSION = 'cms_version';
    const ATTRIBUTE_PLUGIN_NAME = 'plugin_name';
    const ATTRIBUTE_AUTHOR_MAIL = 'author_mail';
    const ATTRIBUTE_CREATED_AT = 'created_at';
    const ATTRIBUTE_UPDATED_AT = 'updated_at';

    /**
     * @var array
     */
    protected $properties = [
        self::ATTRIBUTE_CLIENT_ID,
        self::ATTRIBUTE_PROJECT_ID,
        self::ATTRIBUTE_PUSH_METHOD,
        self::ATTRIBUTE_PUSH_URI,
        self::ATTRIBUTE_CMS,
        self::ATTRIBUTE_CMS_VERSION,
        self::ATTRIBUTE_PLUGIN_NAME,
        self::ATTRIBUTE_AUTHOR_MAIL,
        self::ATTRIBUTE_CREATED_AT,
        self::ATTRIBUTE_UPDATED_AT,
    ];

    /**
     * @var string
     */
    protected $secret;

    /**
     * @return string|null
     */
    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * @param string|null $secret
     * @return Client
     */
    public function setSecret(?string $secret): Client
    {
        $this->secret = (string) $secret;

        return $this;
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
    public function getUpdatedAt(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_UPDATED_AT);
    }

    /**
     * @return int|null
     */
    public function getClientId(): ?int
    {
        return $this->getAttribute(self::ATTRIBUTE_CLIENT_ID);
    }

    /**
     * @param int|null $clientId
     * @return Client
     */
    public function setClientId(?int $clientId): Client
    {
        $this->setAttribute(self::ATTRIBUTE_CLIENT_ID, (int) $clientId);

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProjectId(): ?int
    {
        return $this->getAttribute(self::ATTRIBUTE_PROJECT_ID);
    }

    /**
     * @param int $projectId
     * @return Client
     */
    public function setProjectId(int $projectId): Client
    {
        $this->setAttribute(self::ATTRIBUTE_PROJECT_ID, $projectId);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPushMethod(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_PUSH_METHOD);
    }

    /**
     * @param string $pushMethod
     * @return Client
     */
    public function setPushMethod(string $pushMethod): Client
    {
        $this->setAttribute(self::ATTRIBUTE_PUSH_METHOD, $pushMethod);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPushUri(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_PUSH_URI);
    }

    /**
     * @param string $pushUri
     * @return Client
     */
    public function setPushUri(string $pushUri): Client
    {
        $this->setAttribute(self::ATTRIBUTE_PUSH_URI, $pushUri);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCms(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_CMS);
    }

    /**
     * @param string $cms
     * @return Client
     */
    public function setCms(string $cms): Client
    {
        $this->setAttribute(self::ATTRIBUTE_CMS, $cms);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCmsVersion(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_CMS_VERSION);
    }

    /**
     * @param string $cmsVersion
     * @return Client
     */
    public function setCmsVersion(string $cmsVersion): Client
    {
        $this->setAttribute(self::ATTRIBUTE_CMS_VERSION, $cmsVersion);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPluginName(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_PLUGIN_NAME);
    }

    /**
     * @param string $pluginName
     * @return Client
     */
    public function setPluginName(string $pluginName): Client
    {
        $this->setAttribute(self::ATTRIBUTE_PLUGIN_NAME, $pluginName);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthorMail(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_AUTHOR_MAIL);
    }

    /**
     * @param string $authorMail
     * @return Client
     */
    public function setAuthorMail(string $authorMail): Client
    {
        $this->setAttribute(self::ATTRIBUTE_AUTHOR_MAIL, $authorMail);

        return $this;
    }
}