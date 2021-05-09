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
or with `Amsify42\CurlHtpp\Request` instance
```php
$curlRequest = new Amsify42\CurlHtpp\Request();
$curlRequest->setMethod('POST');
$curlRequest->setData(['name' => 'test', 'salary' => 123]);

$curlHttp = new Amsify42\CurlHttp\CurlHttp('http://www.sample.com/user/create', $curlRequest);
```
With `Amsify42\CurlHtpp\Request` we can also call these methods.
```php
$curlRequest->setMethod('PUT');
$curlRequest->setHeaders(['Authorization: Bearer sf23rsdf23fds']);
$curlRequest->setContenType('json');
$curlRequest->setData(['name' => 'test', 'salary' => 123]);
```
For headers, you can also pass array items as key values
```php
$curlRequest->setHeaders(['Authorization' => 'Bearer sf23rsdf23fds']);
```
### 3. Response
After executing the cURL through `CurlHttp`, we will get response of type `Amsify42\CurlHttp\Response`
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
For executing different methods like GET, POST, PUT and DELETE, you can also call these methods to get response with a single call.
```php
$response = CurlHttp::get('https://www.somsite.com/users');
$response = CurlHttp::post('https://www.somsite.com/user/create', ['name' => 'dummy'], ['Authorization: Bearer sdf23rsdf23'], 'json');
$response = CurlHttp::put('https://www.somsite.com/user/2', ['name' => 'dummy...edited'], ['Authorization: Bearer sdf23rsdf23'], 'json');
$response = CurlHttp::delete('https://www.somsite.com/user/2', ['Authorization: Basic sdf23rsdf23']);
```
Methods `post()`, `put()` and `delete()` expects three more optional parameters
```txt
data - expects data array or defaults to NULL
headers - expects headers array or defaults to NULL
contentType - expects either string 'json' or defaults to NULL
```