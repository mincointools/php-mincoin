<?php
namespace MinCoinTools;

/**
 * Interface to the MinCoinTools API.
 */
class MinCoin
{
    /**
     * The API base url
     */
    const URL_API = "api.mincointools.net";

    /**
     * Used to make the request to the api
     * @var IHttp
     */
    protected $http;

    /**
     * Whether to make API requests using ssl
     * @var bool
     */
    protected $ssl = false;

    /**
     * Sets whether to make API requests using SSL
     *
     * @param  bool $ssl Whether to use ssl
     * @return $this
     */
    public function setSsl($ssl)
    {
        $this->ssl = (bool)$ssl;
        return $this;
    }

    /**
     * Sets the IHttp instance used to make API requests
     *
     * @param  IHttp $http An IHttp instance
     * @return $this
     */
    public function setHttp(IHttp $http)
    {
        $this->http = $http;
        return $this;
    }

    /**
     * @return array
     */
    public function getRecent()
    {
        return $this->request("statistics/recent");
    }

    /**
     *
     * @param  int $limit The number of statistics to return
     * @param  int $offset The limit offset
     * @return array
     */
    public function getStats($limit = 100, $offset = 0)
    {
        $limit  = (int)$limit;
        $offset = (int)$offset;
        return $this->request("statistics/range?limit={$limit}&offset={$offset}");
    }

    /**
     *
     * @param  int $limit The number of statistics to return
     * @param  int $offset The limit offset
     * @return array
     */
    public function getBlocks($limit = 100, $offset = 0)
    {
        $limit  = (int)$limit;
        $offset = (int)$offset;
        return $this->request("blocks?limit={$limit}&offset={$offset}");
    }

    /**
     *
     * @param  string $block_hash The hash of the block to return
     * @return array
     */
    public function getBlock($block_hash)
    {
        $block_hash = urlencode($block_hash);
        return $this->request("block/{$block_hash}");
    }

    /**
     *
     * @param  int $limit The number of statistics to return
     * @param  int $offset The limit offset
     * @return array
     */
    public function getTransactions($limit = 100, $offset = 0)
    {
        $limit  = (int)$limit;
        $offset = (int)$offset;
        return $this->request("transactions?limit={$limit}&offset={$offset}");
    }

    /**
     *
     * @param  string $txid The id of the transaction to return
     * @return array
     */
    public function getTransaction($txid)
    {
        $txid = urlencode($txid);
        return $this->request("transaction/{$txid}");
    }

    /**
     * Makes a request to the given API end point
     *
     * @param  string $end_point The API end point
     * @return array|null
     */
    protected function request($end_point)
    {
        $end_point = "/" . ltrim($end_point, "/");
        $url  = $this->ssl ? "https://" : "http://";
        $url .= self::URL_API . $end_point;

        $this->http->setUrl($url);
        $response = $this->http->request();
        if ($response) {
            return json_decode($response, true);
        } else {
            return null;
        }
    }
} 