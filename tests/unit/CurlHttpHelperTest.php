<?php

namespace Amsify42\Tests;

use PHPUnit\Framework\TestCase;
use Amsify42\CurlHttp\CurlHttp;
use Amsify42\CurlHttp\Request;
use Amsify42\CurlHttp\Response;

final class CurlHttpHelperTest extends TestCase
{

    private $localAPIPath = 'http://localhost/amsify42/php-curl-http/tests/sampleapi.php';

    public function testGetMethod()
    {
        $response = CurlHttp::get($this->localAPIPath);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayHasKey('data', $response->json(true));
        sleep(1);
    }

    public function testPostMethod()
    {
        $reqData = [
                    'name' => 'test'
                ];
        $response = CurlHttp::post($this->localAPIPath, $reqData, NULL);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayHasKey('status', $response->json(true)); 

        $jsonRes  = $response->json(true);
        $jsonData = ($jsonRes && isset($jsonRes['data']))? $jsonRes['data']: [];
        $this->assertArrayHasKey('name', $jsonData);
        $this->assertEquals('test', isset($jsonData['name'])? $jsonData['name']: '');
        sleep(1);
    }

    public function testPutMethod()
    {
        $reqData = [
                    'id'     => 1,
                    'name'   => 'test..edited'
                ];
        $response = CurlHttp::put($this->localAPIPath, $reqData, NULL, 'json');
        $this->assertInstanceOf(Response::class, $response);
        $jsonRes  = $response->json(true);
        $jsonData = ($jsonRes && isset($jsonRes['data']))? $jsonRes['data']: [];
        $this->assertArrayHasKey('name', $jsonData);
        $this->assertEquals('test..edited', isset($jsonData['name'])? $jsonData['name']: '');
        sleep(1);
    }

    public function testDeleteMethod()
    {
        $response = CurlHttp::delete($this->localAPIPath, ['id' => 2], NULL, 'json');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayHasKey('status', $response->json(true));
        sleep(1);
    }  
}