<?php

namespace Amsify42\Tests;

use PHPUnit\Framework\TestCase;
use Amsify42\CurlHttp\CurlHttp;
use Amsify42\CurlHttp\Request;
use Amsify42\CurlHttp\Response;

final class CurlHttpHelperTest extends TestCase
{
    public function testGetMethod()
    {
        $response = CurlHttp::get('https://dummy.restapiexample.com/api/v1/employees');
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
        $response = CurlHttp::post('http://dummy.restapiexample.com/api/v1/create', $reqData, NULL, 'json');
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
        $response = CurlHttp::put('http://dummy.restapiexample.com/api/v1/update/21', $reqData, NULL, 'json');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayHasKey('name', $response->json(true));
        sleep(3);
    }

    public function testDeleteMethod()
    {
        $response = CurlHttp::delete('http://dummy.restapiexample.com/api/v1/delete/21');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayHasKey('status', $response->json(true));
        sleep(3);
    }  
}