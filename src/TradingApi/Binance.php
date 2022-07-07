<?php

namespace App\TradingApi;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpClient\Response\CurlResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

// TODO: It works when api key and api secret is set, but the flow is not ready at all. I'll be back here later.
class Binance
{
    // Api key and secret key should be defined in the env file and encrypted.
    private $apiKey = '';
    private $secretKey = '';
    private $binanceApi = 'https://api.binance.com';
    private $futuresApi = 'https://fapi.binance.com';
    private $apiKeyHeaderName = 'X-MBX-APIKEY';
    private HttpClientInterface $client;
    private ManagerRegistry $doctrine;

    public function __construct(HttpClientInterface $client, ManagerRegistry $doctrine)
    {
        $this->client = $client;
        $this->doctrine = $doctrine;
    }
    public function getUserData()
    {
        $queryArray = [
            'timestamp' => round(microtime(true) * 1000),
            'symbol' => 'SOLUSDT',
        ];
        $queryString = http_build_query($queryArray);
        dump($queryString);
        $sig = hash_hmac('sha256', $queryString, $this->secretKey);
        $queryArray['signature'] = $sig;
        /** @var CurlResponse $result */
        $result = $this->client->request(Request::METHOD_GET, $this->futuresApi . '/fapi/v1/openOrders', [
            'query' => $queryArray,
            'headers' => [
                $this->apiKeyHeaderName => $this->apiKey,
            ]
        ]);
        $result1 = $this->client->request(Request::METHOD_GET, $this->futuresApi . '/fapi/v2/positionRisk', [
            'query' => $queryArray,
            'headers' => [
                $this->apiKeyHeaderName => $this->apiKey,
            ]
        ]);

        dump($result->toArray() ,$result1->toArray());die;
    }

    public function getPositions($userId)
    {
//        $apiKeys = $this
    }
}
/*
$result =
 array:1 [▼
  0 => array:21 [▼
    "orderId" => 14213641631
    "symbol" => "SOLUSDT"
    "status" => "NEW"
    "clientOrderId" => "android_6mbF18h54kST8aBXnU6R"
    "price" => "0"
    "avgPrice" => "0"
    "origQty" => "0"
    "executedQty" => "0"
    "cumQuote" => "0"
    "timeInForce" => "GTE_GTC"
    "type" => "TAKE_PROFIT_MARKET"
    "reduceOnly" => true
    "closePosition" => true
    "side" => "SELL"
    "positionSide" => "BOTH"
    "stopPrice" => "47"
    "workingType" => "MARK_PRICE"
    "priceProtect" => true
    "origType" => "TAKE_PROFIT_MARKET"
    "time" => 1656147555470
    "updateTime" => 1656147555470
  ]
]

$result1 = array:1 [▼
  0 => array:15 [▼
    "symbol" => "SOLUSDT"
    "positionAmt" => "1"
    "entryPrice" => "41.85"
    "markPrice" => "35.46000000"
    "unRealizedProfit" => "-6.39000000"
    "liquidationPrice" => "0"
    "leverage" => "10"
    "maxNotionalValue" => "1000000"
    "marginType" => "isolated"
    "isolatedMargin" => "43.59829359"
    "isAutoAddMargin" => "false"
    "positionSide" => "BOTH"
    "notional" => "35.46000000"
    "isolatedWallet" => "49.98829359"
    "updateTime" => 1656432001986
  ]
]
 */
/*
SIGNED (TRADE, USER_DATA, AND MARGIN) Endpoint security
SIGNED endpoints require an additional parameter, signature, to be sent in the query string or request body.
Endpoints use HMAC SHA256 signatures. The HMAC SHA256 signature is a keyed HMAC SHA256 operation. Use your secretKey as the key and totalParams as the value for the HMAC operation.
The signature is not case sensitive.
totalParams is defined as the query string concatenated with the request body
 */
/*
Security Type	Description
NONE	Endpoint can be accessed freely.
TRADE	Endpoint requires sending a valid API-Key and signature.
MARGIN	Endpoint requires sending a valid API-Key and signature.
USER_DATA	Endpoint requires sending a valid API-Key and signature.
USER_STREAM	Endpoint requires sending a valid API-Key.
MARKET_DATA	Endpoint requires sending a valid API-Key.
 */
