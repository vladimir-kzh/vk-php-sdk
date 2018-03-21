<?php

namespace VK\Actions;

use VK\Actions\Enums\MessagesGetChatNameCase;
use VK\Actions\Enums\MessagesGetChatUsersNameCase;
use VK\Actions\Enums\MessagesGetHistoryAttachmentsMediaType;
use VK\Actions\Enums\MessagesGetHistoryRev;
use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiFloodException;
use VK\Exceptions\Api\VKApiLimitsException;
use VK\Exceptions\Api\VKApiMessagesDenySendException;
use VK\Exceptions\Api\VKApiMessagesForwardAmountExceededException;
use VK\Exceptions\Api\VKApiMessagesForwardException;
use VK\Exceptions\Api\VKApiMessagesPrivacyException;
use VK\Exceptions\Api\VKApiMessagesUserBlockedException;
use VK\Exceptions\Api\VKApiPhotoChangedException;
use VK\Exceptions\Api\VKApiUploadException;
use VK\Exceptions\VKClientException;

class Messages {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Messages constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns a list of the current user's incoming or outgoing private messages.
     *
     *
     * @param $params array
     *      - boolean out: '1' — to return outgoing messages, '0' — to return incoming messages (default)
     *      - integer offset: Offset needed to return a specific subset of messages.
     *      - integer count: Number of messages to return.
     *      - integer filter: 8 - important messages
     *      - integer time_offset: Maximum time since a message was sent, in seconds. To return messages without a
     *        time limitation, set as '0'.
     *      - integer preview_length: Number of characters after which to truncate a previewed message. To preview
     *        the full message, specify '0'. "NOTE: Messages are not truncated by default. Messages are truncated by
     *        words."
     *      - integer last_message_id: ID of the message received before the message that will be returned last
     *        (provided that no more than 'count' messages were received before it, otherwise 'offset' parameter shall be
     *        used).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('messages.get', $params);
    }

    /**
     * Returns a list of the current user's conversations.
     *
     *
     * @param $params array
     *      - integer offset: Offset needed to return a specific subset of conversations.
     *      - integer count: Number of conversations to return.
     *      - integer start_message_id: ID of the message from what to return dialogs.
     *      - integer preview_length: Number of characters after which to truncate a previewed message. To preview
     *        the full message, specify '0'. "NOTE: Messages are not truncated by default. Messages are truncated by
     *        words."
     *      - boolean unread: '1' — return conversations with unread messages only.
     *      - boolean important: '1' — return important conversations only.
     *      - boolean unanswered: '1' — return unanswered conversations only.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getDialogs(array $params = array()) {
        return $this->http->post('messages.getDialogs', $params);
    }

    /**
     * Returns messages by their IDs.
     *
     *
     * @param $params array
     *      - array message_ids: Message IDs.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getById(array $params = array()) {
        return $this->http->post('messages.getById', $params);
    }

    /**
     * Returns a list of the current user's private messages that match search criteria.
     *
     *
     * @param $params array
     *      - string q: Search query string.
     *      - integer peer_id: Destination ID. "For user: 'User ID', e.g. '12345'. For chat: '2000000000' +
     *        'chat_id', e.g. '2000000001'. For community: '- community ID', e.g. '-12345'. "
     *      - integer date: Date to search message before in Unixtime.
     *      - integer preview_length: Number of characters after which to truncate a previewed message. To preview
     *        the full message, specify '0'. "NOTE: Messages are not truncated by default. Messages are truncated by
     *        words."
     *      - integer offset: Offset needed to return a specific subset of messages.
     *      - integer count: Number of messages to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function search(array $params = array()) {
        return $this->http->post('messages.search', $params);
    }

    /**
     * Returns message history for the specified user or group chat.
     *
     *
     * @param $params array
     *      - integer offset: Offset needed to return a specific subset of messages.
     *      - integer count: Number of messages to return.
     *      - integer user_id: ID of the user whose message history you want to return.
     *      - integer peer_id:
     *      - integer start_message_id: Starting message ID from which to return history.
     *      - MessagesGetHistoryRev rev: Sort order: '1' — return messages in chronological order. '0' — return
     *        messages in reverse chronological order.
     * @see MessagesGetHistoryRev
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getHistory(array $params = array()) {
        return $this->http->post('messages.getHistory', $params);
    }

    /**
     * Returns media files from the dialog or group chat.
     *
     *
     * @param $params array
     *      - integer peer_id: Peer ID. ", For group chat: '2000000000 + chat ID' , , For community: '-community
     *        ID'"
     *      - MessagesGetHistoryAttachmentsMediaType media_type: Type of media files to return: *'photo',,
     *        *'video',, *'audio',, *'doc',, *'link'.,*'market'.,*'wall'.,*'share'
     * @see MessagesGetHistoryAttachmentsMediaType
     *      - string start_from: Message ID to start return results from.
     *      - integer count: Number of objects to return.
     *      - boolean photo_sizes: '1' — to return photo sizes in a
     *      - array fields: Additional profile [vk.com/dev/fields|fields] to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getHistoryAttachments(array $params = array()) {
        return $this->http->post('messages.getHistoryAttachments', $params);
    }

    /**
     * Sends a message.
     *
     *
     * @param $params array
     *      - integer user_id: User ID (by default — current user).
     *      - integer random_id: Unique identifier to avoid resending the message.
     *      - integer peer_id: Destination ID. "For user: 'User ID', e.g. '12345'. For chat: '2000000000' +
     *        'chat_id', e.g. '2000000001'. For community: '- community ID', e.g. '-12345'. "
     *      - string domain: User's short address (for example, 'illarionov').
     *      - integer chat_id: ID of conversation the message will relate to.
     *      - array user_ids: IDs of message recipients (if new conversation shall be started).
     *      - string message: (Required if 'attachments' is not set.) Text of the message.
     *      - number lat: Geographical latitude of a check-in, in degrees (from -90 to 90).
     *      - number long: Geographical longitude of a check-in, in degrees (from -180 to 180).
     *      - string attachment: (Required if 'message' is not set.) List of objects attached to the message,
     *        separated by commas, in the following format: "<owner_id>_<media_id>", '' — Type of media attachment:
     *        'photo' — photo, 'video' — video, 'audio' — audio, 'doc' — document, 'wall' — wall post,
     *        '<owner_id>' — ID of the media attachment owner. '<media_id>' — media attachment ID. Example:
     *        "photo100172_166443618"
     *      - string forward_messages: ID of forwarded messages, separated with a comma. Listed messages of the
     *        sender will be shown in the message body at the recipient's. Example: "123,431,544"
     *      - integer sticker_id: Sticker id.
     *      - boolean notification: '1' if the message is a notification (for community messages).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiMessagesUserBlockedException Can't send messages for users from blacklist
     * @throws VKApiMessagesDenySendException Can't send messages for users without dialogs
     * @throws VKApiMessagesPrivacyException Can't send messages to this user due to their privacy settings
     * @throws VKApiMessagesForwardAmountExceededException Too many forwarded messages
     * @throws VKApiMessagesForwardException Can't forward these messages
     *
     */
    public function send(array $params = array()) {
        return $this->http->post('messages.send', $params);
    }

    /**
     * Deletes one or more messages.
     *
     *
     * @param $params array
     *      - array message_ids: Message IDs.
     *      - boolean spam: '1' — to mark message as spam.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function delete(array $params = array()) {
        return $this->http->post('messages.delete', $params);
    }

    /**
     * Deletes all private messages in a conversation.
     *
     *
     * @param $params array
     *      - string user_id: User ID. To clear a chat history use 'chat_id'
     *      - integer peer_id: Destination ID. "For user: 'User ID', e.g. '12345'. For chat: '2000000000' +
     *        'chat_id', e.g. '2000000001'. For community: '- community ID', e.g. '-12345'. "
     *      - integer offset: Offset needed to return a specific subset of messages.
     *      - integer count: Number of messages to delete. "NOTE: If the number of messages exceeds the maximum,
     *        the method shall be called several times."
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function deleteDialog(array $params = array()) {
        return $this->http->post('messages.deleteDialog', $params);
    }

    /**
     * Restores a deleted message.
     *
     *
     * @param $params array
     *      - integer message_id: ID of a previously-deleted message to restore.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function restore(array $params = array()) {
        return $this->http->post('messages.restore', $params);
    }

    /**
     * Marks messages as read.
     *
     *
     * @param $params array
     *      - array message_ids: IDs of messages to mark as read.
     *      - string peer_id: Destination ID. "For user: 'User ID', e.g. '12345'. For chat: '2000000000' +
     *        'chat_id', e.g. '2000000001'. For community: '- community ID', e.g. '-12345'. "
     *      - integer start_message_id: Message ID to start from.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function markAsRead(array $params = array()) {
        return $this->http->post('messages.markAsRead', $params);
    }

    /**
     * Marks and unmarks messages as important (starred).
     *
     *
     * @param $params array
     *      - array message_ids: IDs of messages to mark as important.
     *      - boolean important: '1' — to add a star (mark as important), '0' — to remove the star
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function markAsImportant(array $params = array()) {
        return $this->http->post('messages.markAsImportant', $params);
    }

    /**
     * Marks and unmarks dialogs as important.
     *
     *
     * @param $params array
     *      - array peer_id: IDs of messages to mark as important.
     *      - boolean important: '1' — to add a star (mark as important), '0' — to remove the star
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function markAsImportantDialog(array $params = array()) {
        return $this->http->post('messages.markAsImportantDialog', $params);
    }

    /**
     * Marks and unmarks dialogs as unanswered.
     *
     *
     * @param $params array
     *      - array peer_id: IDs of messages to mark as important.
     *      - boolean important: '1' — to add a star (mark as important), '0' — to remove the star
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function markAsUnansweredDialog(array $params = array()) {
        return $this->http->post('messages.markAsUnansweredDialog', $params);
    }

    /**
     * Returns data required for connection to a Long Poll server.
     *
     *
     * @param $params array
     *      - integer lp_version: Long poll version
     *      - boolean need_pts: '1' — to return the 'pts' field, needed for the
     *        [vk.com/dev/messages.getLongPollHistory|messages.getLongPollHistory] method.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getLongPollServer(array $params = array()) {
        return $this->http->post('messages.getLongPollServer', $params);
    }

    /**
     * Returns updates in user's private messages.
     *
     *
     * @param $params array
     *      - integer ts: Last value of the 'ts' parameter returned from the Long Poll server or by using
     *        [vk.com/dev/messages.getLongPollHistory|messages.getLongPollHistory] method.
     *      - integer pts: Lsat value of 'pts' parameter returned from the Long Poll server or by using
     *        [vk.com/dev/messages.getLongPollHistory|messages.getLongPollHistory] method.
     *      - integer preview_length: Number of characters after which to truncate a previewed message. To preview
     *        the full message, specify '0'. "NOTE: Messages are not truncated by default. Messages are truncated by
     *        words."
     *      - boolean onlines: '1' — to return history with online users only.
     *      - array fields: Additional profile [vk.com/dev/fields|fields] to return.
     *      - integer events_limit: Maximum number of events to return.
     *      - integer msgs_limit: Maximum number of messages to return.
     *      - integer max_msg_id: Maximum ID of the message among existing ones in the local copy. Both messages
     *        received with API methods (for example, , ), and data received from a Long Poll server (events with code 4)
     *        are taken into account.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getLongPollHistory(array $params = array()) {
        return $this->http->post('messages.getLongPollHistory', $params);
    }

    /**
     * Returns information about a chat.
     *
     *
     * @param $params array
     *      - integer chat_id: Chat ID.
     *      - array chat_ids: Chat IDs.
     *      - array fields: Profile fields to return.
     *      - MessagesGetChatNameCase name_case: Case for declension of user name and surname: 'nom' — nominative
     *        (default), 'gen' — genitive , 'dat' — dative, 'acc' — accusative , 'ins' — instrumental , 'abl' —
     *        prepositional
     * @see MessagesGetChatNameCase
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getChat(array $params = array()) {
        return $this->http->post('messages.getChat', $params);
    }

    /**
     * Creates a chat with several participants.
     *
     *
     * @param $params array
     *      - array user_ids: IDs of the users to be added to the chat.
     *      - string title: Chat title.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiFloodException Flood control
     *
     */
    public function createChat(array $params = array()) {
        return $this->http->post('messages.createChat', $params);
    }

    /**
     * Edits the title of a chat.
     *
     *
     * @param $params array
     *      - integer chat_id: Chat ID.
     *      - string title: New title of the chat.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function editChat(array $params = array()) {
        return $this->http->post('messages.editChat', $params);
    }

    /**
     * Returns a list of IDs of users participating in a chat.
     *
     *
     * @param $params array
     *      - integer chat_id: Chat ID.
     *      - array chat_ids: Chat IDs.
     *      - array fields: Profile fields to return.
     *      - MessagesGetChatUsersNameCase name_case: Case for declension of user name and surname: 'nom' —
     *        nominative (default), 'gen' — genitive, 'dat' — dative, 'acc' — accusative, 'ins' — instrumental,
     *        'abl' — prepositional
     * @see MessagesGetChatUsersNameCase
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getChatUsers(array $params = array()) {
        return $this->http->post('messages.getChatUsers', $params);
    }

    /**
     * Changes the status of a user as typing in a conversation.
     *
     *
     * @param $params array
     *      - string user_id: User ID.
     *      - string type: 'typing' — user has started to type.
     *      - integer peer_id: Destination ID. "For user: 'User ID', e.g. '12345'. For chat: '2000000000' +
     *        'chat_id', e.g. '2000000001'. For community: '- community ID', e.g. '-12345'. "
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function setActivity(array $params = array()) {
        return $this->http->post('messages.setActivity', $params);
    }

    /**
     * Returns a list of the current user's conversations that match search criteria.
     *
     *
     * @param $params array
     *      - string q: Search query string.
     *      - integer limit: Maximum number of results.
     *      - array fields: Profile fields to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function searchDialogs(array $params = array()) {
        return $this->http->post('messages.searchDialogs', $params);
    }

    /**
     * Adds a new user to a chat.
     *
     *
     * @param $params array
     *      - integer chat_id: Chat ID.
     *      - integer user_id: ID of the user to be added to the chat.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiLimitsException Out of limits
     *
     */
    public function addChatUser(array $params = array()) {
        return $this->http->post('messages.addChatUser', $params);
    }

    /**
     * Allows the current user to leave a chat or, if the current user started the chat, allows the user to remove
     * another user from the chat.
     *
     *
     * @param $params array
     *      - integer chat_id: Chat ID.
     *      - string user_id: ID of the user to be removed from the chat.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function removeChatUser(array $params = array()) {
        return $this->http->post('messages.removeChatUser', $params);
    }

    /**
     * Returns a user's current status and date of last activity.
     *
     *
     * @param $params array
     *      - integer user_id: User ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getLastActivity(array $params = array()) {
        return $this->http->post('messages.getLastActivity', $params);
    }

    /**
     * Sets a previously-uploaded picture as the cover picture of a chat.
     *
     *
     * @param $params array
     *      - string file: Upload URL from the 'response' field returned by the
     *        [vk.com/dev/photos.getChatUploadServer|photos.getChatUploadServer] method upon successfully uploading an
     *        image.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiUploadException Upload error
     * @throws VKApiPhotoChangedException Original photo was changed
     *
     */
    public function setChatPhoto(array $params = array()) {
        return $this->http->post('messages.setChatPhoto', $params);
    }

    /**
     * Deletes a chat's cover picture.
     *
     *
     * @param $params array
     *      - integer chat_id: Chat ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function deleteChatPhoto(array $params = array()) {
        return $this->http->post('messages.deleteChatPhoto', $params);
    }

    /**
     * Denies sending message from community to the current user.
     *
     *
     * @param $params array
     *      - integer group_id: Group ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function denyMessagesFromGroup(array $params = array()) {
        return $this->http->post('messages.denyMessagesFromGroup', $params);
    }

    /**
     * Allows sending messages from community to the current user.
     *
     *
     * @param $params array
     *      - integer group_id: Group ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function allowMessagesFromGroup(array $params = array()) {
        return $this->http->post('messages.allowMessagesFromGroup', $params);
    }

    /**
     * Returns information whether sending messages from the community to current user is allowed.
     *
     *
     * @param $params array
     *      - integer group_id: Group ID.
     *      - integer user_id: User ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function isMessagesFromGroupAllowed(array $params = array()) {
        return $this->http->post('messages.isMessagesFromGroupAllowed', $params);
    }
}
