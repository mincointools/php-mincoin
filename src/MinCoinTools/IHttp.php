<?php
namespace MinCoinTools;

/**
 * Interface for classes which make HTTP requests
 */
interface IHttp
{
    /**
     * Sets the request url
     *
     * @param  string $url
     * @return $this
     */
    public function setUrl($url);

    /**
     * Returns the request url
     *
     * @param  string $url
     * @return string
     */
    public function getUrl($url);

    /**
     * Sets the request timeout in seconds
     *
     * @param  int $timeout
     * @return $this
     */
    public function setTimeout($timeout);

    /**
     * Returns the request timeout in seconds
     *
     * @return int
     */
    public function getTimeout();

    /**
     * Sets the user agent header value
     *
     * @param  string $user_agent
     * @return $this
     */
    public function setUserAgent($user_agent);

    /**
     * Returns the user agent header value
     *
     * @return string
     */
    public function getUserAgent();

    /**
     * Makes the http request and returns the response
     *
     * @throws HttpException When an error occures
     * @param  int $status_code Gets set to the response http status code
     * @return string
     */
    public function request(&$status_code = null);
} 