<?php
namespace MinCoinTools;

/**
 * Used to make HTTP requests
 */
class Http
    implements IHttp
{
    /**
     * The request url
     * @var string
     */
    protected $url;

    /**
     * The request timeout
     * @var int
     */
    protected $timeout = 5;

    /**
     * Whether to make the request using ssl
     * @var bool
     */
    protected $ssl = false;

    /**
     * The user agent header value
     * @var string
     */
    protected $user_agent = "MinCoinTools API";

    /**
     * Constructor
     *
     * @param string $url The request url
     */
    public function __construct($url = null)
    {
        if (null !== $url) {
            $this->setUrl($url);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setUrl($url)
    {
        $this->url = (string)$url;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl($url)
    {
        return $this->url;
    }

    /**
     * {@inheritDoc}
     */
    public function setTimeout($timeout)
    {
        $this->timeout = (int)$timeout;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * {@inheritDoc}
     */
    public function setUserAgent($user_agent)
    {
        $this->user_agent = (string)$user_agent;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserAgent()
    {
        return $this->user_agent;
    }

    /**
     * {@inheritDoc}
     */
    public function request(&$status_code = null)
    {
        if (!$this->url) {
            throw new HttpException("The request URL has not been set.");
        }

        $error = null;
        $curl  = curl_init($this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->user_agent);
        $data        = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (!$data) {
            $error = curl_error($curl);
        }
        curl_close($curl);
        if ($error) {
            throw new HttpException($error);
        }

        return $data;
    }
}