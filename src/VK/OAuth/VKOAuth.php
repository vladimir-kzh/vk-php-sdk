<?php

namespace VK\OAuth;

use Http\Client\Exception\TransferException;
use VK\Client\VKHttpClient;
use VK\Exceptions\VKClientException;
use VK\Exceptions\VKOAuthException;

class VKOAuth {
    protected const VERSION = '5.69';

    private const PARAM_VERSION = 'v';
    private const PARAM_CLIENT_ID = 'client_id';
    private const PARAM_REDIRECT_URI = 'redirect_uri';
    private const PARAM_GROUP_IDS = 'group_ids';
    private const PARAM_DISPLAY = 'display';
    private const PARAM_SCOPE = 'scope';
    private const PARAM_RESPONSE_TYPE = 'response_type';
    private const PARAM_STATE = 'state';
    private const PARAM_CLIENT_SECRET = 'client_secret';
    private const PARAM_CODE = 'code';
    private const PARAM_REVOKE = 'revoke';

    protected const HOST = 'https://oauth.vk.com';
    private const ENDPOINT_AUTHORIZE = '/authorize';
    private const ENDPOINT_ACCESS_TOKEN = '/access_token';

    protected const CONNECTION_TIMEOUT = 10;
    protected const HTTP_STATUS_CODE_OK = 200;

    /**
     * @var VKHttpClient
     */
    private $vkHttpClient;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $host;

    /**
     * VKOAuth constructor.
     *
     * @param VKHttpClient $vkHttpClient
     * @param string $version
     */
    public function __construct(VKHttpClient $vkHttpClient, string $version = self::VERSION) {
        $this->vkHttpClient = $vkHttpClient;
        $this->version = $version;
        $this->host = static::HOST;
    }

    /**
     * Get authorize url
     *
     * @param string $response_type
     * @param int $client_id
     * @param string $redirect_uri
     * @param string $display
     * @param int[] $scope
     * @param string $state
     * @param int[] $group_ids
     * @param bool $revoke
     * @return string
     * @see VKOAuthResponseType
     * @see VKOAuthDisplay
     * @see VKOAuthGroupScope
     * @see VKOAuthUserScope
     */
    public function getAuthorizeUrl(string $response_type, int $client_id, string $redirect_uri, string $display,
                                    ?array $scope = null, ?string $state = null, ?array $group_ids = null, bool $revoke = false): string {
        $scope_mask = 0;
        foreach ($scope as $scope_setting) {
            $scope_mask |= $scope_setting;
        }

        $params = array(
            static::PARAM_CLIENT_ID     => $client_id,
            static::PARAM_REDIRECT_URI  => $redirect_uri,
            static::PARAM_DISPLAY       => $display,
            static::PARAM_SCOPE         => $scope_mask,
            static::PARAM_STATE         => $state,
            static::PARAM_RESPONSE_TYPE => $response_type,
            static::PARAM_VERSION       => $this->version,
        );

        if ($group_ids) {
            $params[static::PARAM_GROUP_IDS] = implode(',', $group_ids);
        }

        if ($revoke) {
            $params[static::PARAM_REVOKE] = 1;
        }

        return $this->host . static::ENDPOINT_AUTHORIZE . '?' . http_build_query($params);
    }

    /**
     * @param int $client_id
     * @param string $client_secret
     * @param string $redirect_uri
     * @param string $code
     * @return mixed
     * @throws VKClientException
     * @throws VKOAuthException
     */
    public function getAccessToken(int $client_id, string $client_secret, string $redirect_uri, string $code) {
        $params = array(
            static::PARAM_CLIENT_ID     => $client_id,
            static::PARAM_CLIENT_SECRET => $client_secret,
            static::PARAM_REDIRECT_URI  => $redirect_uri,
            static::PARAM_CODE          => $code,
        );

        try {
            $response = $this->vkHttpClient->get($this->host . static::ENDPOINT_ACCESS_TOKEN, $params);
        } catch (VKClientException $e) {
            throw new VKOAuthException("OAuth error. {$e->getMessage()}");
        } catch (TransferException $e) {
            throw new VKClientException($e);
        }

        return $response;
    }

}
