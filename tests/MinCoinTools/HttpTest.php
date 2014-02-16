<?php
use MinCoinTools\Http;

class HttpTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @covers MinCoinTools\Http::request
     */
    public function testRequest()
    {
        $http = new Http("http://google.com");
        $this->assertNotEmpty($http->request($status_code));
        $this->assertEquals(301, $status_code);

        $http = new Http("https://google.com");
        $this->assertNotEmpty($http->request($status_code));
        $this->assertEquals(301, $status_code);
    }

    /**
     * @covers MinCoinTools\Http::request
     * @expectedException MinCoinTools\HttpException
     */
    public function testRequest_Exception()
    {
        $http = new Http("ht://google.com");
        $http->request();
    }
}
