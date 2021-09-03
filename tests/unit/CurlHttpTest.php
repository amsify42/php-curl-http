<?php

namespace Amsify42\Tests;

use PHPUnit\Framework\TestCase;
use Amsify42\CurlHttp\CurlHttp;
use Amsify42\CurlHttp\Request;
use Amsify42\CurlHttp\Response;

final class CurlHttpTest extends TestCase
{
    private $localAPIPath = 'http://localhost/amsify42/php-curl-http/tests/sampleapi.php';

    public function testGetMethod()
    {
        $curlHttp = new CurlHttp($this->localAPIPath);
        $response = $curlHttp->execute();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayHasKey('data', $response->json(true));
        sleep(1);
    }

    public function testPostMethod()
    {
        $reqData = [
                    'name' => 'test'
                ];

        $curlHttp = get_curl_http($this->localAPIPath);
        $curlHttp->setRequestMethod('POST')
                 ->setRequestContentType('json')
                 ->setRequestData($reqData);
        $response = $curlHttp->execute();
        $this->assertInstanceOf(Response::class, $response);
        $jsonRes = $response->json(true);
        $this->assertArrayHasKey('status', $jsonRes);
        $jsonData = ($jsonRes && isset($jsonRes['data']))? $jsonRes['data']: [];
        $this->assertArrayHasKey('name', $jsonData);
        $this->assertEquals('test', isset($jsonData['name'])? $jsonData['name']: '');

        sleep(1);
    }

    public function testPutMethod()
    {
        $reqData = [
                    'id'   => 1,
                    'name' => 'test..edited'
                ];

        $curlRequest = new Request();
        $curlRequest->setMethod('PUT')
                    ->setHeaders(['Content-Type' => 'application/json'])
                    ->setData($reqData);

        $curlHttp = get_curl_http($this->localAPIPath, $curlRequest);
        $response = $curlHttp->execute();
        $this->assertInstanceOf(Response::class, $response);
        $jsonRes  = $response->json(true);
        $this->assertArrayHasKey('status', $jsonRes);

        $jsonData = ($jsonRes && isset($jsonRes['data']))? $jsonRes['data']: [];
        $this->assertArrayHasKey('name', $jsonData);
        $this->assertEquals('test..edited', isset($jsonData['name'])? $jsonData['name']: '');

        sleep(1);
    }

    public function testDeleteMethod()
    {
        $curlHttp = get_curl_http($this->localAPIPath);
        $curlHttp->setRequestMethod('DELETE')->setRequestData(['id' => 1]);
        $response = $curlHttp->execute();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayHasKey('status', $response->json(true));
        sleep(1);
    }
}