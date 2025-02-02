<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Model;

use eRecht24\RechtstexteSDK\Exceptions\Exception;
use eRecht24\RechtstexteSDK\Helper\Language as Lang;

/**
 * Class Response
 * @package eRecht24\RechtstexteSDK
 *
 * @property int code
 * @property string body
 */
class Response extends BaseResponse
{
    const ATTRIBUTE_CODE = 'code';
    const ATTRIBUTE_BODY = 'body';

    /**
     * allowed properties
     *
     * @var array
     */
    protected $properties = [
        self::ATTRIBUTE_CODE,
        self::ATTRIBUTE_BODY,
    ];

    /**
     * Function provides body data as array
     *
     * @return null|array
     */
    public function getBodyDataAsArray(): ?array
    {
        try {
            $bodyData = json_decode($this->getBody(), true);
        } catch (\Exception $e) {
            $bodyData = null;
        }

        return $bodyData;
    }

    /**
     * Function provides specific body data by key
     *
     * @param string $key
     * @return mixed
     */
    public function getBodyDataByKey(string $key)
    {
        $bodyData = $this->getBodyDataAsArray();

        if (is_null($bodyData))
            return null;

        if (!array_key_exists($key, $bodyData))
            return null;

        return $bodyData[$key];
    }

    /**
     * Checks if request was successful
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return ($this->getCode() < self::HTTP_BAD_REQUEST);
    }

    /**
     * Checks if request was not successful
     *
     * @return bool
     */
    public function isError(): bool
    {
        return !$this->isSuccess();
    }

    /**
     * Get message by language
     *
     * @param string $lang
     * @return string|null
     */
    public function getMessage(string $lang = Lang::EN_EN): ?string
    {
        switch (strtolower($lang)) {
            case Lang::DE_DE:
                $message = $this->getBodyDataByKey('message_de');
                break;

            default:
                $message = $this->getBodyDataByKey('message');
        }

        return $message;
    }

    /**
     * Get error message if failed response
     *
     * @param string $lang
     * @return string|null
     */
    public function getErrorMessage(string $lang = Lang::EN_EN): ?string
    {
        $message = null;

        if (!$this->isSuccess()) {
            $message = $this->getMessage($lang);
        }

        return $message;
    }

    /**
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->getAttribute(self::ATTRIBUTE_CODE);
    }

    /**
     * @param int $code
     * @return Response
     */
    public function setCode(int $code): Response
    {
        $this->setAttribute(self::ATTRIBUTE_CODE, $code);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->getAttribute(self::ATTRIBUTE_BODY);
    }

    /**
     * @param string $body
     * @return Response
     */
    public function setBody(string $body): Response
    {
        $this->setAttribute(self::ATTRIBUTE_BODY, $body);

        return $this;
    }
}