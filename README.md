php-mincoin
===========

PHP classes used to make requests to the MinCoinTools API. See the documentation at http://api.mincointools.net for the full documentation.


Examples
--------
```php
$mincoin = new MinCoinTools\MinCoin();

// Get list of recently created blocks.
$blocks  = $mincoin->getBlocks(10);
var_dump($blocks);

// Get information on a single block.
$block = $mincoin->getBlock($blocks[0]["hash"]);
var_dump($block);

// Get statistics.
$stats = $mincoin->getStats(10);
var_dump($stats);

// Get the most recent statistics.
$recent = $mincoin->getRecent();
var_dump($recent);

// Get recent transactions.
$transactions = $mincoin->getTransactions(10);
var_dump($transactions);

// Get information on a single transaction.
$transaction = $mincoin->getTransaction($transactions[0]["id"]);
var_dump($transaction);
```

Requirements
------------
* PHP 5.4 or greater
* cURL PHP extension


Installing
----------
Install using Git by adding the classes to your project.

`git clone git@github.com:mincointools/php-mincoin.git`

Install using Composer by adding the project to your composer.json.

`"mincointools/php-mincoin" : "dev-master"`


License
-------
This content is released under the MIT License. See the included LICENSE for more information.