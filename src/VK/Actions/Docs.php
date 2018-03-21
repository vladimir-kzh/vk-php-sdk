<?php

namespace VK\Actions;

use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiParamDocAccessException;
use VK\Exceptions\Api\VKApiParamDocDeleteAccessException;
use VK\Exceptions\Api\VKApiParamDocIdException;
use VK\Exceptions\Api\VKApiParamDocTitleException;
use VK\Exceptions\Api\VKApiSaveFileException;
use VK\Exceptions\VKClientException;

class Docs {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Docs constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns detailed information about user or community documents.
     *
     *
     * @param $params array
     *      - integer count: Number of documents to return. By default, all documents.
     *      - integer offset: Offset needed to return a specific subset of documents.
     *      - integer owner_id: ID of the user or community that owns the documents. Use a negative value to
     *        designate a community ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('docs.get', $params);
    }

    /**
     * Returns information about documents by their IDs.
     *
     *
     * @param $params array
     *      - array docs: Document IDs. Example: , "66748_91488,66748_91455",
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getById(array $params = array()) {
        return $this->http->post('docs.getById', $params);
    }

    /**
     * Returns the server address for document upload.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID (if the document will be uploaded to the community).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getUploadServer(array $params = array()) {
        return $this->http->post('docs.getUploadServer', $params);
    }

    /**
     * Returns the server address for document upload onto a user's or community's wall.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID (if the document will be uploaded to the community).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getWallUploadServer(array $params = array()) {
        return $this->http->post('docs.getWallUploadServer', $params);
    }

    /**
     * Saves a document after [vk.com/dev/upload_files_2|uploading it to a server].
     *
     *
     * @param $params array
     *      - string file: This parameter is returned when the file is [vk.com/dev/upload_files_2|uploaded to the
     *        server].
     *      - string title: Document title.
     *      - string tags: Document tags.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiSaveFileException Couldn't save file
     *
     */
    public function save(array $params = array()) {
        return $this->http->post('docs.save', $params);
    }

    /**
     * Deletes a user or community document.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the document. Use a negative value to
     *        designate a community ID.
     *      - integer doc_id: Document ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamDocDeleteAccessException Access to document deleting is denied
     * @throws VKApiParamDocIdException Invalid document id
     *
     */
    public function delete(array $params = array()) {
        return $this->http->post('docs.delete', $params);
    }

    /**
     * Copies a document to a user's or community's document list.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the document. Use a negative value to
     *        designate a community ID.
     *      - integer doc_id: Document ID.
     *      - string access_key: Access key. This parameter is required if 'access_key' was returned with the
     *        document's data.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function add(array $params = array()) {
        return $this->http->post('docs.add', $params);
    }

    /**
     * Returns documents types available for current user.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the documents. Use a negative value to
     *        designate a community ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getTypes(array $params = array()) {
        return $this->http->post('docs.getTypes', $params);
    }

    /**
     * Returns a list of documents matching the search criteria.
     *
     *
     * @param $params array
     *      - string q: Search query string.
     *      - boolean search_own:
     *      - integer count: Number of results to return.
     *      - integer offset: Offset needed to return a specific subset of results.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function search(array $params = array()) {
        return $this->http->post('docs.search', $params);
    }

    /**
     * Edits a document.
     *
     *
     * @param $params array
     *      - integer owner_id: User ID or community ID. Use a negative value to designate a community ID.
     *      - integer doc_id: Document ID.
     *      - string title: Document title.
     *      - array tags: Document tags.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamDocAccessException Access to document is denied
     * @throws VKApiParamDocIdException Invalid document id
     * @throws VKApiParamDocTitleException Invalid document title
     *
     */
    public function edit(array $params = array()) {
        return $this->http->post('docs.edit', $params);
    }
}
