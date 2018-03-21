<?php

namespace VK\Actions;

use VK\Client\VKHttpClient;
use VK\Exceptions\Api\VKApiAccessCommentException;
use VK\Exceptions\Api\VKApiAccessNoteCommentException;
use VK\Exceptions\Api\VKApiAccessNoteException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiParamNoteIdException;
use VK\Exceptions\VKClientException;

class Notes {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Notes constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns a list of notes created by a user.
     *
     *
     * @param $params array
     *      - array note_ids: Note IDs.
     *      - integer user_id: Note owner ID.
     *      - integer count: Number of notes to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamNoteIdException Note not found
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('notes.get', $params);
    }

    /**
     * Returns a note by its ID.
     *
     *
     * @param $params array
     *      - integer note_id: Note ID.
     *      - integer owner_id: Note owner ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessNoteException Access to note denied
     * @throws VKApiParamNoteIdException Note not found
     *
     */
    public function getById(array $params = array()) {
        return $this->http->post('notes.getById', $params);
    }

    /**
     * Creates a new note for the current user.
     *
     *
     * @param $params array
     *      - string title: Note title.
     *      - string text: Note text.
     *      - array privacy_view:
     *      - array privacy_comment:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function add(array $params = array()) {
        return $this->http->post('notes.add', $params);
    }

    /**
     * Edits a note of the current user.
     *
     *
     * @param $params array
     *      - integer note_id: Note ID.
     *      - string title: Note title.
     *      - string text: Note text.
     *      - array privacy_view:
     *      - array privacy_comment:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamNoteIdException Note not found
     *
     */
    public function edit(array $params = array()) {
        return $this->http->post('notes.edit', $params);
    }

    /**
     * Deletes a note of the current user.
     *
     *
     * @param $params array
     *      - integer note_id: Note ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamNoteIdException Note not found
     *
     */
    public function delete(array $params = array()) {
        return $this->http->post('notes.delete', $params);
    }

    /**
     * Returns a list of comments on a note.
     *
     *
     * @param $params array
     *      - integer note_id: Note ID.
     *      - integer owner_id: Note owner ID.
     *      - integer count: Number of comments to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessNoteException Access to note denied
     *
     */
    public function getComments(array $params = array()) {
        return $this->http->post('notes.getComments', $params);
    }

    /**
     * Adds a new comment on a note.
     *
     *
     * @param $params array
     *      - integer note_id: Note ID.
     *      - integer owner_id: Note owner ID.
     *      - integer reply_to: ID of the user to whom the reply is addressed (if the comment is a reply to another
     *        comment).
     *      - string message: Comment text.
     *      - string guid:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessNoteException Access to note denied
     * @throws VKApiAccessNoteCommentException You can't comment this note
     *
     */
    public function createComment(array $params = array()) {
        return $this->http->post('notes.createComment', $params);
    }

    /**
     * Edits a comment on a note.
     *
     *
     * @param $params array
     *      - integer comment_id: Comment ID.
     *      - integer owner_id: Note owner ID.
     *      - string message: New comment text.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessCommentException Access to comment denied
     *
     */
    public function editComment(array $params = array()) {
        return $this->http->post('notes.editComment', $params);
    }

    /**
     * Deletes a comment on a note.
     *
     *
     * @param $params array
     *      - integer comment_id: Comment ID.
     *      - integer owner_id: Note owner ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessNoteException Access to note denied
     * @throws VKApiAccessCommentException Access to comment denied
     *
     */
    public function deleteComment(array $params = array()) {
        return $this->http->post('notes.deleteComment', $params);
    }

    /**
     * Restores a deleted comment on a note.
     *
     *
     * @param $params array
     *      - integer comment_id: Comment ID.
     *      - integer owner_id: Note owner ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessCommentException Access to comment denied
     *
     */
    public function restoreComment(array $params = array()) {
        return $this->http->post('notes.restoreComment', $params);
    }
}
