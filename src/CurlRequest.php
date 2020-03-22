<?php

namespace Amsify42\CurlHttp;

class CurlRequest
{
	private $headers 	 = [];						
	private $method 	 = 'GET';
	private $data 		 = [];
	private $contentType = '';
	private $contentData = NULL;

	/**
	 * Set Http Method
	 * @param string $method
	 */
	public function setMethod($method = 'GET')
	{
		$this->method = $method;
		return $this;
	}

	/**
	 * Set Http Headers
	 * @param array $headers
	 */
	public function setHeaders($headers = [])
	{
		$this->headers = $headers;
		return $this;
	}

	/**
	 * Set Http Header
	 * @param array $header
	 */
	public function setHeader($header = '')
	{
		$this->headers[] = $header;
		return $this;
	}

	/**
	 * Set Http content type
	 * @param string $data
	 */
	public function setContenType($type = '')
	{
		$this->contentType = $type;
		return $this;
	}

	/**
	 * Set Http body data
	 * @param array $data
	 */
	public function setData($data = [])
	{
		$this->data 		= $data;
		$this->contentData 	= NULL;
		return $this;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function getHeaders()
	{
		return $this->headers;
	}

	public function getContetType()
	{
		return $this->contentType;
	}

	public function getData()
	{
		return $this->data;
	}

	public function getDataSize()
	{
		return sizeof($this->data);	
	}

	public function getBodyData()
	{
		return $this->setContentData()->contentData;
	}

	private function setContentData()
	{
		if(!$this->contentData)
		{
			if($this->contentType == 'json')
			{
				$this->contentData = json_encode($this->data, JSON_UNESCAPED_UNICODE);
			}
			else
			{
				$this->contentData = http_build_query($this->data);	
			}
		}
		return $this;
	}

	public function contentLength()
	{
		return strlen($this->contentData);
	}
}