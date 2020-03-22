<?php

namespace Amsify42\CurlHttp;

use Amsify42\PHPVarsData\Data\ArraySimple;

class CurlResponse
{
    private $headers    = [];
    private $bodyData   = NULL;
    private $jsonData   = NULL;
    private $arraySimple= NULL;
    private $info       = [];

    function __construct($curl)
    {
        $response       = curl_exec($curl);
        $this->info     = curl_getinfo($curl);
        $headerSize     = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $this->bodyData = trim(substr($response, $headerSize));
        $this->setHeaders(substr($response, 0, $headerSize));
    }

    private function setHeaders($headersStr)
    {
        $hsStr = trim($headersStr);
        if($hsStr)
        {
            $hsArr = explode("\n", $hsStr);
            if(sizeof($hsArr)> 0)
            {
                foreach($hsArr as $hsk => $hsAr)
                {
                    $val = trim($hsAr);
                    if($val)
                    {
                        $valArr = explode(': ', $val);
                        if(sizeof($valArr)> 1)
                        {
                            $this->headers[trim($valArr[0])] = trim($valArr[1]);
                        }
                    }
                }
            }
        }
    }

    public function getInfo($key='')
    {
        return ($key)? (isset($this->info[$key])? $this->info[$key]: ''): $this->info;
    }

    public function getCode()
    {
        return $this->info['http_code'];
    }

    public function getRedirectURL()
    {
        return $this->info['redirect_url'];
    }

    public function getBodyData()
    {
        return $this->bodyData;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getHeader($key)
    {
        return isset($this->headers[$key])? $this->headers[$key]: NULL;
    }

    public function json($asArray=false)
    {
        $this->setJson($asArray);
        return $this->jsonData;
    }

    public function arraySimple()
    {
        $this->setArraySimple();
        return $this->arraySimple;
    }

    private function setArraySimple()
    {
        $this->setJson(true);
        if(!$this->arraySimple)
        {
            $this->arraySimple = new ArraySimple($this->jsonData);
        }
    }

    private function setJson($asArray=false)
    {
        if(!$this->jsonData)
        {
            $this->jsonData = json_decode($this->bodyData, $asArray);
        }
    }
}