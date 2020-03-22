<?php

namespace Amsify42\CurlHttp;

use Amsify42\CurlHttp\CurlRequest;
use Amsify42\CurlHttp\CurlResponse;

class CurlHttp
{
	private $isLog 		= false;
	private $url 		= NULL;	

	private $request 	= NULL;
	private $response 	= NULL;
	private $userAgent 	= '';

	function __construct($url, CurlRequest $request=NULL)
	{
		$this->url 		= $url;
		$this->request 	= ($request)? $request: new CurlRequest();
	}

	/**
	 * Set User Agent
	 * @param string  $agent
	 * @param boolean $isGoogle
	 */
	public function setUserAgent($agent=NULL)
	{
		$this->userAgent = $agent;
		return $this;
	}

	/**
	 * Set isLog
	 * @param boolean
	 */
	public function setLog($isLog=true)
	{
		$this->isLog = $isLog;
		return $this;
	}

	/**
	 * request
	 * @return CurlRequest
	 */
	public function request()
	{
		return $this->request;
	}

	/**
	 * Set Request Method
	 * @param string $method
	 */
	public function setRequestMethod($method = 'GET')
	{
		$this->request->setMethod($method);
		return $this;
	}

	/**
	 * Set Request Headers
	 * @param array $headers
	 */
	public function setRequestHeaders($headers = [])
	{
		$this->request->setHeaders($headers);
		return $this;
	}

	/**
	 * Set Request content type
	 * @param string $type
	 */
	public function setRequestContentType($type='')
	{
		$this->request->setContenType($type);
		return $this;
	}

	/**
	 * Set Request body data
	 * @param array $data
	 */
	public function setRequestData($data = [])
	{
		$this->request->setData($data);
		return $this;
	}

	/**
	 * Execute the Http request
	 * @return string
	 */
	public function execute()
	{
		$method 	= strtolower(trim($this->request->getMethod()));
		$formSize 	= $this->request->getDataSize();
		$bodyData 	= '';
		if($formSize > 0)
		{
			$bodyData = $this->request->getBodyData();
		}

		if($this->isLog)
		{
			chLogMsg('---------Start - CurlHttp------------');
	        chLogMsg($this->request->getMethod().': '.$this->url);
	        if($bodyData)
	        {
	        	chLogMsg('Request Data: '.$bodyData);
	        }
		}

        $curl = curl_init($this->url);
		if(sizeof($this->request->getHeaders())> 0)
		{
			if($method == 'put' && $formSize > 0)
			{
				$this->request->setHeader('Content-Length: '.$this->request->contentLength());
			}
			curl_setopt($curl, CURLOPT_HTTPHEADER, $this->request->getHeaders());
		}
		if($method == 'post')
		{
			curl_setopt($curl, CURLOPT_POST, 1);
		}
		else
		{
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->request->getMethod());
		}
		if($formSize > 0)
		{
			curl_setopt($curl, CURLOPT_POSTFIELDS, $bodyData);
		}

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //to work from local insecure domain
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_BINARYTRANSFER,1);

		if($this->userAgent)
		{
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
    		curl_setopt($curl, CURLOPT_TIMEOUT, 15);
    		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);
		}

		$this->response = new CurlResponse($curl);		
		curl_close($curl);

		if($this->isLog)
		{
	        chLogMsg('Response Data: '.$this->response->getBodyData());
	        chLogMsg('---------End - CurlHttp------------');
    	}

        return $this->response;
	}

	/**
	 * response
	 * @return CurlResponse
	 */
	public function response()
	{
		return $this->response;	
	}

	/**
	 * Get Response Code
	 */
	public function getResponseCode()
	{
		return $this->response->getCode();
	}

	/**
	 * Get Response Headers
	 */
	public function getResponseHeaders()
	{
		return $this->response->getHeaders();
	}

	/**
	 * Get Response data
	 */
	public function getResponseBodyData()
	{
		return $this->response->getBodyData();
	}
}