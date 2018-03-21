<?php

namespace VK\Actions;

use VK\Actions\Enums\PagesSaveAccessEdit;
use VK\Actions\Enums\PagesSaveAccessView;
use VK\Client\VKHttpClient;
use VK\Exceptions\Api\VKApiAccessPageException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiParamPageIdException;
use VK\Exceptions\Api\VKApiParamTitleException;
use VK\Exceptions\VKClientException;

class Pages {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Pages constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns information about a wiki page.
     *
     *
     * @param $params array
     *      - integer owner_id: Page owner ID.
     *      - integer page_id: Wiki page ID.
     *      - boolean global: '1' — to return information about a global wiki page
     *      - boolean site_preview: '1' — resulting wiki page is a preview for the attached link
     *      - string title: Wiki page title.
     *      - boolean need_source:
     *      - boolean need_html: '1' — to return the page as HTML,
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('pages.get', $params);
    }

    /**
     * Saves the text of a wiki page.
     *
     *
     * @param $params array
     *      - string text: Text of the wiki page in wiki-format.
     *      - integer page_id: Wiki page ID. The 'title' parameter can be passed instead of 'pid'.
     *      - integer group_id: ID of the community that owns the wiki page.
     *      - integer user_id:
     *      - string title: Wiki page title.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessPageException Access to page denied
     * @throws VKApiParamPageIdException Page not found
     * @throws VKApiParamTitleException Invalid title
     *
     */
    public function save(array $params = array()) {
        return $this->http->post('pages.save', $params);
    }

    /**
     * Saves modified read and edit access settings for a wiki page.
     *
     *
     * @param $params array
     *      - integer page_id: Wiki page ID.
     *      - integer group_id: ID of the community that owns the wiki page.
     *      - integer user_id:
     *      - PagesSaveAccessView view: Who can view the wiki page: '1' — only community members, '2' — all
     *        users can view the page, '0' — only community managers
     * @see PagesSaveAccessView
     *      - PagesSaveAccessEdit edit: Who can edit the wiki page: '1' — only community members, '2' — all
     *        users can edit the page, '0' — only community managers
     * @see PagesSaveAccessEdit
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessPageException Access to page denied
     * @throws VKApiParamPageIdException Page not found
     *
     */
    public function saveAccess(array $params = array()) {
        return $this->http->post('pages.saveAccess', $params);
    }

    /**
     * Returns a list of all previous versions of a wiki page.
     *
     *
     * @param $params array
     *      - integer page_id: Wiki page ID.
     *      - integer group_id: ID of the community that owns the wiki page.
     *      - integer user_id:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessPageException Access to page denied
     * @throws VKApiParamPageIdException Page not found
     *
     */
    public function getHistory(array $params = array()) {
        return $this->http->post('pages.getHistory', $params);
    }

    /**
     * Returns a list of wiki pages in a group.
     *
     *
     * @param $params array
     *      - integer group_id: ID of the community that owns the wiki page.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessPageException Access to page denied
     *
     */
    public function getTitles(array $params = array()) {
        return $this->http->post('pages.getTitles', $params);
    }

    /**
     * Returns the text of one of the previous versions of a wiki page.
     *
     *
     * @param $params array
     *      - integer version_id:
     *      - integer group_id: ID of the community that owns the wiki page.
     *      - integer user_id:
     *      - boolean need_html: '1' — to return the page as HTML
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessPageException Access to page denied
     *
     */
    public function getVersion(array $params = array()) {
        return $this->http->post('pages.getVersion', $params);
    }

    /**
     * Returns HTML representation of the wiki markup.
     *
     *
     * @param $params array
     *      - string text: Text of the wiki page.
     *      - integer group_id: ID of the group in the context of which this markup is interpreted.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function parseWiki(array $params = array()) {
        return $this->http->post('pages.parseWiki', $params);
    }

    /**
     * Allows to clear the cache of particular 'external' pages which may be attached to VK posts.
     *
     *
     * @param $params array
     *      - string url: Address of the page where you need to refesh the cached version
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function clearCache(array $params = array()) {
        return $this->http->post('pages.clearCache', $params);
    }
}
