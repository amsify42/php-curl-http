<?php

namespace Amsify42\Tests;

use PHPUnit\Framework\TestCase;
use Amsify42\CurlHttp\CurlHttp;
use Amsify42\CurlHttp\Request;
use Amsify42\CurlHttp\Response;

final class CurlHttpTest extends TestCase
{
    public function testGetMethod()
    {
        $curlHttp = new CurlHttp('https://dummy.restapiexample.com/api/v1/employees');
        $response = $curlHttp->execute();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayHasKey('data', $response->json(true));
        sleep(3);
    }

    public function testPostMethod()
    {
        $reqData = [
                    'name' => 'test',
                    'salary' => 3000
                ];

        $curlHttp = get_curl_http('http://dummy.restapiexample.com/api/v1/create');
        $curlHttp->setRequestMethod('POST')
                 ->setRequestContentType('json')
                 ->setRequestData($reqData);
        $response = $curlHttp->execute();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayHasKey('status', $response->json(true));
        sleep(3);
    }

    public function testPutMethod()
    {
        $reqData = [
                    'name' => 'test..edited',
                    'salary' => 30000
                ];

        $curlRequest = new Request();
        $curlRequest->setMethod('PUT')
                    ->setContenType('json')
                    ->setData($reqData);

        $curlHttp = get_curl_http('http://dummy.restapiexample.com/api/v1/update/21', $curlRequest);
        $response = $curlHttp->execute();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayHasKey('status', $response->json(true));
        sleep(3);
    }

    public function testDeleteMethod()
    {
        $curlHttp = get_curl_http('http://dummy.restapiexample.com/api/v1/delete/21');
        $curlHttp->setRequestMethod('DELETE');
        $response = $curlHttp->execute();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayHasKey('status', $response->json(true));
        sleep(3);
    }
}