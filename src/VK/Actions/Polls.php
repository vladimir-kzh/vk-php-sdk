<?php

namespace VK\Actions;

use VK\Actions\Enums\PollsGetVotersNameCase;
use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiPollsAccessException;
use VK\Exceptions\Api\VKApiPollsAnswerIdException;
use VK\Exceptions\Api\VKApiPollsPollIdException;
use VK\Exceptions\VKClientException;

class Polls {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Polls constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns detailed information about a poll by its ID.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the poll. Use a negative value to designate a
     *        community ID.
     *      - boolean is_board: '1' – poll is in a board, '0' – poll is on a wall. '0' by default.
     *      - integer poll_id: Poll ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiPollsAccessException Access to poll denied
     *
     */
    public function getById(array $params = array()) {
        return $this->http->post('polls.getById', $params);
    }

    /**
     * Adds the current user's vote to the selected answer in the poll.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the poll. Use a negative value to designate a
     *        community ID.
     *      - integer poll_id: Poll ID.
     *      - integer answer_id: Answer ID.
     *      - boolean is_board:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiPollsAccessException Access to poll denied
     * @throws VKApiPollsAnswerIdException Invalid answer id
     * @throws VKApiPollsPollIdException Invalid poll id
     *
     */
    public function addVote(array $params = array()) {
        return $this->http->post('polls.addVote', $params);
    }

    /**
     * Deletes the current user's vote from the selected answer in the poll.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the poll. Use a negative value to designate a
     *        community ID.
     *      - integer poll_id: Poll ID.
     *      - integer answer_id: Answer ID.
     *      - boolean is_board:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiPollsAccessException Access to poll denied
     * @throws VKApiPollsAnswerIdException Invalid answer id
     * @throws VKApiPollsPollIdException Invalid poll id
     *
     */
    public function deleteVote(array $params = array()) {
        return $this->http->post('polls.deleteVote', $params);
    }

    /**
     * Returns a list of IDs of users who selected specific answers in the poll.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the poll. Use a negative value to designate a
     *        community ID.
     *      - integer poll_id: Poll ID.
     *      - array answer_ids: Answer IDs.
     *      - boolean is_board:
     *      - boolean friends_only: '1' — to return only current user's friends, '0' — to return all users
     *        (default),
     *      - integer offset: Offset needed to return a specific subset of voters. '0' — (default)
     *      - integer count: Number of user IDs to return (if the 'friends_only' parameter is not set, maximum
     *        '1000', otherwise '10'). '100' — (default)
     *      - array fields: Profile fields to return. Sample values: 'nickname', 'screen_name', 'sex', 'bdate
     *        (birthdate)', 'city', 'country', 'timezone', 'photo', 'photo_medium', 'photo_big', 'has_mobile', 'rate',
     *        'contacts', 'education', 'online', 'counters'.
     *      - PollsGetVotersNameCase name_case: Case for declension of user name and surname: , 'nom' —
     *        nominative (default) , 'gen' — genitive , 'dat' — dative , 'acc' — accusative , 'ins' — instrumental
     *        , 'abl' — prepositional
     * @see PollsGetVotersNameCase
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiPollsAccessException Access to poll denied
     * @throws VKApiPollsAnswerIdException Invalid answer id
     * @throws VKApiPollsPollIdException Invalid poll id
     *
     */
    public function getVoters(array $params = array()) {
        return $this->http->post('polls.getVoters', $params);
    }

    /**
     * Creates polls that can be attached to the users' or communities' posts.
     *
     *
     * @param $params array
     *      - string question: question text
     *      - boolean is_anonymous: '1' – anonymous poll, participants list is hidden,, '0' – public poll,
     *        participants list is available,, Default value is '0'.
     *      - integer owner_id: If a poll will be added to a communty it is required to send a negative group
     *        identifier. Current user by default.
     *      - string add_answers: available answers list, for example: " ["yes","no","maybe"]", There can be from 1
     *        to 10 answers.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function create(array $params = array()) {
        return $this->http->post('polls.create', $params);
    }

    /**
     * Edits created polls
     *
     *
     * @param $params array
     *      - integer owner_id: poll owner id
     *      - integer poll_id: edited poll's id
     *      - string question: new question text
     *      - string add_answers: answers list, for example: , "["yes","no","maybe"]"
     *      - string edit_answers: object containing answers that need to be edited,, key – answer id, value –
     *        new answer text. Example: {"382967099":"option1", "382967103":"option2"}"
     *      - string delete_answers: list of answer ids to be deleted. For example: "[382967099, 382967103]"
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function edit(array $params = array()) {
        return $this->http->post('polls.edit', $params);
    }
}
