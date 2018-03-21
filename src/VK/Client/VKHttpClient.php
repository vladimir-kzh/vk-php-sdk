<?php

namespace VK\Client;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Http\Message\UriFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use VK\Exceptions\Api\ExceptionMapper;
use VK\Exceptions\VKClientException;
use VK\Exceptions\VKLongPollException;

class VKHttpClient
{
    const API_VERSION = '5.73';
    protected const API_METHOD_URL = 'https://api.vk.com/method/';

    const PARAM_VERSION = 'v';
    const PARAM_ACCESS_TOKEN = 'access_token';
    const PARAM_LANG = 'lang';

    protected const HTTP_POST = 'POST';
    protected const HTTP_GET = 'GET';

    protected const HTTP_STATUS_CODE_OK = 200;

    private const KEY_ERROR = 'error';
    private const KEY_RESPONSE = 'response';
    private const KEY_FAILED = 'failed';

    protected $http;
    protected $requestFactory;
    protected $uriFactory;

    protected $baseUri;

    protected $accessToken;
    protected $version;
    protected $lang;

    public function __construct(
        HttpClient $httpClient,
        RequestFactory $requestFactory,
        UriFactory $uriFactory,
        string $accessToken = null,
        string $version = self::API_VERSION,
        string $lang = null
    )
    {
        $this->http = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory;

        $this->accessToken = $accessToken;
        $this->version = $version;
        $this->lang = $lang;
        $this->baseUri = $this->uriFactory->createUri(static::API_METHOD_URL);
    }

    protected function send(string $httpMethod, string $url, array $params = [])
    {
        $params = $this->formatParams($params);

        $body = null;
        if ($httpMethod === static::HTTP_POST) {
            $body = http_build_query($params);
            $params = [];
        }

        $request = $this->requestFactory->createRequest(
            $httpMethod,
            $this->resolveUri($url, $params),
            [],
            $body
        );
        $response = $this->http->sendRequest($request);

        return $this->parseResponse($response);
    }

    protected function formatParams(array $params)
    {
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $params[$key] = implode(',', $value);
            } else if (is_bool($value)) {
                $params[$key] = $value ? 1 : 0;
            }
        }

        $params = array_filter($params, function ($item) {
            return !($item === null || $item === '');
        });

        $params = array_merge(array_filter([
            static::PARAM_ACCESS_TOKEN => $this->accessToken,
            static::PARAM_VERSION => $this->version,
            static::PARAM_LANG => $this->lang,
        ]), $params);

        return $params;
    }

    protected function resolveUri(string $url, array $params): UriInterface
    {
        $uri = $this->uriFactory->createUri($url);

        if ($uri->getHost() === '') {
            $uri = $uri->withHost($this->baseUri->getHost())
                ->withScheme($this->baseUri->getScheme())
                ->withPort($this->baseUri->getPort())
                ->withPath($this->baseUri->getPath() . $uri->getPath());
        }

        $query = $uri->getQuery();
        if ($query) {
            $uriParams = [];
            parse_str($uri->getQuery(), $uriParams);
            $params = array_merge($uriParams, $params);
        }

        if (!empty($params)) {
            $query = http_build_query($params);
            $uri = $uri->withQuery($query);
        }

        return $uri;
    }

    protected function parseResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() != static::HTTP_STATUS_CODE_OK) {
            throw new VKClientException("Invalid http status: {$response->getStatusCode()}");
        }

        $body = $response->getBody()->getContents();

        $decodeBody = json_decode($body, true);
        if (!$decodeBody || !is_array($decodeBody)) {
            $decodeBody = [];
        }

        if (isset($decodeBody[static::KEY_ERROR])) {
            $error = $decodeBody[static::KEY_ERROR];
            $api_error = new VKApiError($error);
            throw ExceptionMapper::parse($api_error);
        } elseif (isset($decodeBody[static::KEY_FAILED])) {
            throw VKLongPollException::make($decodeBody);
        }

        if (isset($decodeBody[static::KEY_RESPONSE])) {
            return $decodeBody[static::KEY_RESPONSE];
        } else {
            return $decodeBody;
        }
    }

    public function post(string $url, array $data = [])
    {
        return $this->send(static::HTTP_POST, $url, $data);
    }

    public function get(string $url, array $params = [])
    {
        return $this->send(static::HTTP_GET, $url, $params);
    }
}
