<?php

namespace Amsify42\Tests;

use PHPUnit\Framework\TestCase;
use Amsify42\CurlHttp\CurlHttp;
use Amsify42\CurlHttp\CurlRequest;
use Amsify42\CurlHttp\CurlResponse;

final class CurlHttpTest extends TestCase
{
    public function testGetMethod()
    {
        $curlHttp = new CurlHttp('http://dummy.restapiexample.com/api/v1/employees');
        $response = $curlHttp->execute();
        $this->assertInstanceOf(CurlResponse::class, $response);
        $this->assertArrayHasKey('status', $response->json(true));
        sleep(2);
    }

    public function testPostMethod()
    {
        $curlHttp = get_curl_http('http://dummy.restapiexample.com/api/v1/create');
        $curlHttp->setRequestMethod('POST')
                 ->setRequestContentType('json')
                 ->setRequestData([
                                'name' => 'test..',
                                'salary' => 1245,
                                'age' => 30
                            ]);
        $response = $curlHttp->execute();
        $this->assertInstanceOf(CurlResponse::class, $response);
        $this->assertArrayHasKey('status', $response->json(true));
        sleep(2);
    }

    public function testPutMethod()
    {
        $curlRequest = new CurlRequest();
        $curlRequest->setMethod('PUT')
                    ->setContenType('json')
                    ->setData([
                                'name' => 'test..',
                                'salary' => 1245,
                                'age' => 30
                            ]);

        $curlHttp = get_curl_http('http://dummy.restapiexample.com/api/v1/update/28', $curlRequest);
        $response = $curlHttp->execute();
        $this->assertInstanceOf(CurlResponse::class, $response);
        $jsonData = $response->json(true);
        $this->assertArrayHasKey('status', $jsonData);
        $this->assertEquals('success', $jsonData['status']);
        sleep(2);
    }

    public function testDeleteMethod()
    {
        $curlHttp = get_curl_http('http://dummy.restapiexample.com/api/v1/delete/29');
        $curlHttp->setRequestMethod('DELETE');
        $response = $curlHttp->execute();
        $this->assertInstanceOf(CurlResponse::class, $response);
        $this->assertArrayHasKey('status', $response->json(true));
        $this->assertContains($response->arraySimple()->get('status'), ['success', 'failed']);
        sleep(2);
    }
}