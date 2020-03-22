# PHP CURL HTTP
This is the PHP package for making http request through cURL and getting response.

### Installation
```
$ composer require amsify42/php-curl-http
```
## Table of Contents
1. [Initialization](#1-initialization)
2. [Request](#2-request)
3. [Response](#3-response)

### 1. Initialization
For creating cURL http request, we can do like this by passing url to it.
```php
$curlHttp = new Amsify42\CurlHttp\CurlHttp('http://www.sample.com/users');
```
or with helper method
```php
$curlHttp = get_curl_http('http://www.sample.com/users');
```

### 2. Request
If the request method is not of type `GET`, we can pass this with `CurlHtpp` instance
```php
$curlHttp = new Amsify42\CurlHttp\CurlHttp('http://www.sample.com/user/create');
$curlHttp->setRequestMethod('POST');
$curlHttp->setRequestData(['name' => 'test', 'salary' => 123]);
```
or with `Amsify42\CurlHtpp\CurlRequest` instance
```php
$curlRequest = new Amsify42\CurlHtpp\CurlRequest();
$curlRequest->setMethod('POST');
$curlRequest->setData(['name' => 'test', 'salary' => 123]);

$curlHttp = new Amsify42\CurlHttp\CurlHttp('http://www.sample.com/user/create', $curlRequest);
```
With `Amsify42\CurlHtpp\CurlRequest` we can also call these methods.
```php
$curlRequest->setMethod('PUT');
$curlRequest->setHeaders(['Authorization: Bearer sf23rsdf23fds']);
$curlRequest->setContenType('json');
$curlRequest->setData(['name' => 'test', 'salary' => 123]);
```
### 3. Response
After executing the cURL through `CurlHttp`, we will get response of type `Amsify42\CurlHttp\CurlResponse`
```php
$curlHttp = get_curl_http('http://www.sample.com/users');
$response = $curlHttp->execute();
```
We can call these methods with the response
```php
/* To get the response code */
$response->getCode();
/* To get the response body data */
$response->getBodyData();
/* To get the response headers as array */
$response->getHeaders();
/* To get the json decoded data of response */
$response->json();
```