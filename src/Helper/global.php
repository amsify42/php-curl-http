<?php

function get_curl_http($url, \Amsify42\CurlHttp\Request $curlRequest=NULL)
{
    return new Amsify42\CurlHttp\CurlHttp($url, $curlRequest);
}

if(!defined('printMessage'))
{
    function chLogMsg($message='')
    {
        echo "\n\n";
        if($message)
        {
            echo $message;
            echo "\n\n";
        }
    }
}