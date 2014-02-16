<?php
use MinCoinTools\MinCoin;

class MinCoinTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * The test fixture
     * @var MinCoin
     */
    protected $mincoin;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $http;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->mincoin = new MinCoin();
        $this->http = $this->getMock('MinCoinTools\IHttp');
        $this->mincoin->setHttp($this->http);
    }

    /**
     * @covers MinCoinTools\MinCoin::getRecent
     */
    public function testGetRecent()
    {
        $this->mincoin->setSsl(true);
        $this->http
            ->expects($this->once())
            ->method("setUrl")
            ->with($this->equalTo("https://api.mincointools.net/statistics/recent"))
            ->will($this->returnSelf());
        $this->http
            ->expects($this->once())
            ->method("request")
            ->will($this->returnValue('{"difficulty":4.46021132,"block_count":331102,"hash_rate":542036173,"price_usd":0.52,"price_btc":0.00086082,"trading_mnc":36646,"trading_btc":31,"time_per_block":35.341666676274,"difficulty_next":7.5721578625962,"coins_total":1589564,"market_cap":826573.28,"date":"2014-02-16T16:31:04-05:00"}'));
        $response = $this->mincoin->getRecent();
        $this->assertArrayHasKey(
            "difficulty",
            $response
        );
    }

    /**
     * @covers MinCoinTools\MinCoin::getStats
     */
    public function testGetStats()
    {
        $this->http
            ->expects($this->once())
            ->method("setUrl")
            ->with($this->equalTo("http://api.mincointools.net/statistics/range?limit=2&offset=0"))
            ->will($this->returnSelf());
        $this->http
            ->expects($this->once())
            ->method("request")
            ->will($this->returnValue('[{"difficulty":4.46021132,"block_count":331102,"hash_rate":542036173,"price_usd":0.54,"price_btc":0.0008996,"trading_mnc":36714,"trading_btc":31,"time_per_block":35.341666676274,"difficulty_next":7.5721578625962,"coins_total":1589564,"market_cap":858364.56,"date":"2014-02-16T16:32:04-05:00"},{"difficulty":4.46021132,"block_count":331102,"hash_rate":542036173,"price_usd":0.52,"price_btc":0.00086082,"trading_mnc":36646,"trading_btc":31,"time_per_block":35.341666676274,"difficulty_next":7.5721578625962,"coins_total":1589564,"market_cap":826573.28,"date":"2014-02-16T16:31:04-05:00"}]'));
        $response = $this->mincoin->getStats(2);
        $this->assertCount(2, $response);
        $this->assertArrayHasKey(
                "difficulty",
                $response[0]
        );
    }

    /**
     * @covers MinCoinTools\MinCoin::getBlocks
     */
    public function testGetBlocks()
    {
        $this->mincoin->setSsl(true);
        $this->http
            ->expects($this->once())
            ->method("setUrl")
            ->with($this->equalTo("https://api.mincointools.net/blocks?limit=2&offset=0"))
            ->will($this->returnSelf());
        $this->http
            ->expects($this->once())
            ->method("request")
            ->will($this->returnValue('[{"height":"331103","hash":"56C3EE843411A8023050C26728BEF5DE3B4773894E0E3774EDBDA74A7FEE78FD","hash_prev":"F24C52614F39FE7EE00F8598CCA5E194F3123A08F3B712A123E0FF920C4A3732","hash_next":"0000000000000000000000000000000000000000000000000000000000000000","version":"1.00","size":"9830","merkleroot":"3035646538633836373836303932326461366631616262663632343437663339","time":"1392586311","nonce":"262744064","bits":"1C396540","difficulty":"4.46021132","num_transactions":"11","value_out":"1305.91715995"},{"height":"331102","hash":"F24C52614F39FE7EE00F8598CCA5E194F3123A08F3B712A123E0FF920C4A3732","hash_prev":"020398D2D63E08EE16669B06E1350A53475A96AF1CE017221230716FF281BBC6","hash_next":"0000000000000000000000000000000000000000000000000000000000000000","version":"1.00","size":"431","merkleroot":"3566623536343030366436666337393932343638356230386630366364666332","time":"1392586055","nonce":"2587690240","bits":"1C396540","difficulty":"4.46021132","num_transactions":"2","value_out":"2.79255857"}]'));
        $response = $this->mincoin->getBlocks(2);
        $this->assertCount(2, $response);
        $this->assertArrayHasKey(
                "height",
                $response[0]
        );
    }

    /**
     * @covers MinCoinTools\MinCoin::getBlock
     */
    public function testGetBlock()
    {
        $this->http
            ->expects($this->once())
            ->method("setUrl")
            ->with($this->equalTo("http://api.mincointools.net/block/56957D85DF3AD96D8519CF44C5E9020EC5E7466055A0E65DA2E8B677C1C82344"))
            ->will($this->returnSelf());
        $this->http
            ->expects($this->once())
            ->method("request")
            ->will($this->returnValue('{"height":"331100","hash":"56957D85DF3AD96D8519CF44C5E9020EC5E7466055A0E65DA2E8B677C1C82344","hash_prev":"504D1EE0C0FEDB746790EC964465567D394763A8E8AB08ECC6CA62C20188846A","hash_next":"020398D2D63E08EE16669B06E1350A53475A96AF1CE017221230716FF281BBC6","version":"1.00","size":"205","merkleroot":"3739653435663337313830356638373539643066353861613338616136306137","time":"1392585886","nonce":"3672661248","bits":"1C396540","difficulty":"4.46021132","num_transactions":"1","value_out":"2.00000000","transactions":[{"id":"79E45F371805F8759D0F58AA38AA60A73D931E5080883C134E301B4063EFF8FB","version":"1.00","locktime":"0","time":"1392585886","value_out":"2.00000000","num_ins":"1","num_outs":"1","in":[{"sequence":"0","coinbase":"035c0d05062f503253482f04942c015308f8000ad2160000000d2f7374726174756d506f6f6c2f"}],"out":[{"value":"2.00000000","n":"0","req_sigs":"1","type":"pubkeyhash","script_pub_key":{"asm":"OP_DUP OP_HASH160 50b8cb13a324720b0d30fc31012e88699e69d07f OP_EQUALVERIFY OP_CHECKSIG","hex":"76a91450b8cb13a324720b0d30fc31012e88699e69d07f88ac"},"addresses":["MFFyfSMhT64bVtBw4AVybPH8wvn2VDRUyk"]}]}]}'));
        $response = $this->mincoin->getBlock("56957D85DF3AD96D8519CF44C5E9020EC5E7466055A0E65DA2E8B677C1C82344");
        $this->assertArrayHasKey(
                "height",
                $response
        );
    }

    /**
     * @covers MinCoinTools\MinCoin::getTransactions
     */
    public function testGetTransactions()
    {
        $this->mincoin->setSsl(true);
        $this->http
            ->expects($this->once())
            ->method("setUrl")
            ->with($this->equalTo("https://api.mincointools.net/transactions?limit=2&offset=0"))
            ->will($this->returnSelf());
        $this->http
            ->expects($this->once())
            ->method("request")
            ->will($this->returnValue('[{"id":"3D5AD5351F80008B3E7A2DBE4752FA27508B5207A9F4CF0116663E51818161D7","block_height":"331104","version":"1.00","locktime":"0","time":"1392586472","value_out":"2.10000000","num_ins":"1","num_outs":"1"},{"id":"D80C7355B09076129AA9C79678394256FF2708235A7E8B55089955F618895692","block_height":"331103","version":"1.00","locktime":"0","time":"1392586311","value_out":"57.30000000","num_ins":"1","num_outs":"2"}]'));
        $response = $this->mincoin->getTransactions(2);
        $this->assertCount(2, $response);
        $this->assertArrayHasKey(
                "block_height",
                $response[0]
        );
    }

    /**
     * @covers MinCoinTools\MinCoin::getTransaction
     */
    public function testGetTransaction()
    {
        $this->http
            ->expects($this->once())
            ->method("setUrl")
            ->with($this->equalTo("http://api.mincointools.net/transaction/3D5AD5351F80008B3E7A2DBE4752FA27508B5207A9F4CF0116663E51818161D7"))
            ->will($this->returnSelf());
        $this->http
            ->expects($this->once())
            ->method("request")
            ->will($this->returnValue('{"id":"3D5AD5351F80008B3E7A2DBE4752FA27508B5207A9F4CF0116663E51818161D7","block_height":"331104","version":"1.00","locktime":"0","time":"1392586472","value_out":"2.10000000","num_ins":"1","num_outs":"1","in":[{"sequence":"0","coinbase":"03600d05062f503253482f04f92e015308f80177ec000000000d2f7374726174756d506f6f6c2f"}],"out":[{"value":"2.10000000","n":"0","req_sigs":"1","type":"pubkeyhash","script_pub_key":{"asm":"OP_DUP OP_HASH160 40513c6b15141bf8e1ed32c5f2190ea4aa9071cd OP_EQUALVERIFY OP_CHECKSIG","hex":"76a91440513c6b15141bf8e1ed32c5f2190ea4aa9071cd88ac"},"addresses":["MDmEo5qTxLRR2EMkC2MyHTC8M4Qgb3W6JF"]}]}'));
        $response = $this->mincoin->getTransaction("3D5AD5351F80008B3E7A2DBE4752FA27508B5207A9F4CF0116663E51818161D7");
        $this->assertArrayHasKey(
                "block_height",
                $response
        );
    }
}
