<?php

namespace Mi\Framework;

class Request
{
    private static $instance = null;
    // what does a request look like
    // it has => url, method, req headers, query params, body,...

    /**
     * @var string request url
     */
    private string $url;

    /**
     * @var string request method
     */
    private ?string $method;

    /**
     * @var array request headers
     */
    private ?array $requestHeaders = array();

    /**
     * @var string request body
     */
    private ?array $requestBody = array();

    /**
     * @var string request query parameters in GET case
     */
    private ?array $queryParams = array();

    /**
     * @method getter for request url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @method getter for request url
     */
    public function getRequestBody()
    {
        return $this->requestBody;
    }

    /**
     * @method getter for request url
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * @method getter for request method
     */
    public function getRequestMethod()
    {
        if (self::$instance && $this->method) {
            return $this->method;
        }
        $method = strtoupper($_SERVER['REQUEST_METHOD']);

        if ($method === 'POST') {
            $headers = $this->getRequestHeaders();
            if (isset($headers['X-HTTP-Method-Override']) && in_array($headers['X-HTTP-Method-Override'], array('PUT', 'PATCH', 'DELETE'))) {
                $this->method = $headers['X-HTTP-Method-Override'];
            }
        }

        return $method;
    }

    /**
     * @method getter for request headers
     */
    public function getRequestHeaders()
    {
        if ($this->requestHeaders) {
            return $this->requestHeaders;
        }
        $headers = array();

        // If getallheaders() is available, use that
        if (function_exists('getallheaders')) {
            $headers = getallheaders();

            // getallheaders() can return false if something went wrong
            if ($headers !== false) {
                return $headers;
            }
        }

        // Method getallheaders() not available or went wrong: manually extract 'm
        foreach ($_SERVER as $name => $value) {
            if ((substr($name, 0, 5) == 'HTTP_') || ($name == 'CONTENT_TYPE') || ($name == 'CONTENT_LENGTH')) {
                $headers[str_replace(array(' ', 'Http'), array('-', 'HTTP'), ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }

        return $headers;
    }

        /**
     * @method constructor to create Request 
     */
    private function __construct()
    {
        $this->url = Router::normalize(parse_url($_SERVER['REQUEST_URI'])['path']);
        $this->method = $this->getRequestMethod();
        $this->requestHeaders = $this->getRequestHeaders();
        // $this->requestBody = $requestBody; // TODO:there is http_get_request_body
        // $this->queryParams = $queryParams; // TODO:
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Request();
        }

        return self::$instance;
    }
}
