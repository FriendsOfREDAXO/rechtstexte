<?php

namespace eRecht24\RechtstexteSDK\Interfaces;

use eRecht24\RechtstexteSDK\Model\Response;

interface EndpointInterface
{
    /**
     * @param string $url
     * @param string $method
     * @param array|null $postData
     * @return Response
     */
    public function makeRequest(
        string $url,
        string $method,
        ?array $postData = null
    ): Response;

    /**
     * @return string
     */
    public function getApiKey(): string;

    /**
     * @return string
     */
    public function getFullUrl(): string;

    /**
     * Set HTTP method for cURL
     *
     * @param string $method
     * @return EndpointInterface
     */
    public function setMethod(string $method): EndpointInterface;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @param string $path
     * @return EndpointInterface
     */
    public function setPath(string $path): EndpointInterface;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @param array|null $postFields
     * @return EndpointInterface
     */
    public function setPostFields(?array $postFields): EndpointInterface;

    /**
     * @return ?array
     */
    public function getPostFields(): ?array;

    /**
     * @return EndpointInterface
     */
    public function reset(): EndpointInterface;
}