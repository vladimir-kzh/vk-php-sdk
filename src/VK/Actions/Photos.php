<?php

namespace VK\Actions;

use VK\Actions\Enums\PhotosGetAlbumId;
use VK\Actions\Enums\PhotosGetCommentsSort;
use VK\Actions\Enums\PhotosReportCommentReason;
use VK\Actions\Enums\PhotosReportReason;
use VK\Client\VKHttpClient;
use VK\Exceptions\Api\VKApiAlbumsLimitException;
use VK\Exceptions\Api\VKApiBlockedException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiParamAlbumIdException;
use VK\Exceptions\Api\VKApiParamHashException;
use VK\Exceptions\Api\VKApiParamPhotoException;
use VK\Exceptions\Api\VKApiParamPhotosException;
use VK\Exceptions\Api\VKApiParamServerException;
use VK\Exceptions\VKClientException;

class Photos {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Photos constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Creates an empty photo album.
     *
     *
     * @param $params array
     *      - string title: Album title.
     *      - integer group_id: ID of the community in which the album will be created.
     *      - string description: Album description.
     *      - array privacy_view:
     *      - array privacy_comment:
     *      - boolean upload_by_admins_only:
     *      - boolean comments_disabled:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAlbumsLimitException Albums number limit is reached
     *
     */
    public function createAlbum(array $params = array()) {
        return $this->http->post('photos.createAlbum', $params);
    }

    /**
     * Edits information about a photo album.
     *
     *
     * @param $params array
     *      - integer album_id: ID of the photo album to be edited.
     *      - string title: New album title.
     *      - string description: New album description.
     *      - integer owner_id: ID of the user or community that owns the album.
     *      - array privacy_view:
     *      - array privacy_comment:
     *      - boolean upload_by_admins_only:
     *      - boolean comments_disabled:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamAlbumIdException Invalid album id
     *
     */
    public function editAlbum(array $params = array()) {
        return $this->http->post('photos.editAlbum', $params);
    }

    /**
     * Returns a list of a user's or community's photo albums.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the albums.
     *      - array album_ids: Album IDs.
     *      - integer offset: Offset needed to return a specific subset of albums.
     *      - integer count: Number of albums to return.
     *      - boolean need_system: '1' — to return system albums with negative IDs
     *      - boolean need_covers: '1' — to return an additional 'thumb_src' field, '0' — (default)
     *      - boolean photo_sizes: '1' — to return photo sizes in a
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getAlbums(array $params = array()) {
        return $this->http->post('photos.getAlbums', $params);
    }

    /**
     * Returns a list of a user's or community's photos.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photos. Use a negative value to designate
     *        a community ID.
     *      - PhotosGetAlbumId album_id: Photo album ID. To return information about photos from service albums,
     *        use the following string values: 'profile, wall, saved'.
     * @see PhotosGetAlbumId
     *      - array photo_ids: Photo IDs.
     *      - boolean rev: Sort order: '1' — reverse chronological, '0' — chronological
     *      - boolean extended: '1' — to return additional 'likes', 'comments', and 'tags' fields, '0' —
     *        (default)
     *      - string feed_type: Type of feed obtained in 'feed' field of the method.
     *      - integer feed: unixtime, that can be obtained with [vk.com/dev/newsfeed.get|newsfeed.get] method in
     *        date field to get all photos uploaded by the user on a specific day, or photos the user has been tagged on.
     *        Also, 'uid' parameter of the user the event happened with shall be specified.
     *      - boolean photo_sizes: '1' — to return photo sizes in a [vk.com/dev/photo_sizes|special format]
     *      - integer offset:
     *      - integer count:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function get(array $params = array()) {
        return $this->http->post('photos.get', $params);
    }

    /**
     * Returns the number of photo albums belonging to a user or community.
     *
     *
     * @param $params array
     *      - integer user_id: User ID.
     *      - integer group_id: Community ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getAlbumsCount(array $params = array()) {
        return $this->http->post('photos.getAlbumsCount', $params);
    }

    /**
     * Returns information about photos by their IDs.
     *
     *
     * @param $params array
     *      - array photos: IDs separated with a comma, that are IDs of users who posted photos and IDs of photos
     *        themselves with an underscore character between such IDs. To get information about a photo in the group
     *        album, you shall specify group ID instead of user ID. Example: "1_129207899,6492_135055734, ,
     *        -20629724_271945303"
     *      - boolean extended: '1' — to return additional fields, '0' — (default)
     *      - boolean photo_sizes: '1' — to return photo sizes in a
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getById(array $params = array()) {
        return $this->http->post('photos.getById', $params);
    }

    /**
     * Returns the server address for photo upload.
     *
     *
     * @param $params array
     *      - integer album_id: Album ID.
     *      - integer group_id: ID of community that owns the album (if the photo will be uploaded to a community
     *        album).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getUploadServer(array $params = array()) {
        return $this->http->post('photos.getUploadServer', $params);
    }

    /**
     * Returns the server address for owner cover upload.
     *
     *
     * @param $params array
     *      - integer group_id: ID of community that owns the album (if the photo will be uploaded to a community
     *        album).
     *      - integer crop_x: X coordinate of the left-upper corner
     *      - integer crop_y: Y coordinate of the left-upper corner
     *      - integer crop_x2: X coordinate of the right-bottom corner
     *      - integer crop_y2: Y coordinate of the right-bottom corner
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getOwnerCoverPhotoUploadServer(array $params = array()) {
        return $this->http->post('photos.getOwnerCoverPhotoUploadServer', $params);
    }

    /**
     * Returns an upload server address for a profile or community photo.
     *
     *
     * @param $params array
     *      - integer owner_id: identifier of a community or current user. "Note that community id must be
     *        negative. 'owner_id=1' – user, 'owner_id=-1' – community, "
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getOwnerPhotoUploadServer(array $params = array()) {
        return $this->http->post('photos.getOwnerPhotoUploadServer', $params);
    }

    /**
     * Returns an upload link for chat cover pictures.
     *
     *
     * @param $params array
     *      - integer chat_id: ID of the chat for which you want to upload a cover photo.
     *      - integer crop_x:
     *      - integer crop_y:
     *      - integer crop_width: Width (in pixels) of the photo after cropping.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getChatUploadServer(array $params = array()) {
        return $this->http->post('photos.getChatUploadServer', $params);
    }

    /**
     * Returns the server address for market photo upload.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - boolean main_photo: '1' if you want to upload the main item photo.
     *      - integer crop_x: X coordinate of the crop left upper corner.
     *      - integer crop_y: Y coordinate of the crop left upper corner.
     *      - integer crop_width: Width of the cropped photo in px.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getMarketUploadServer(array $params = array()) {
        return $this->http->post('photos.getMarketUploadServer', $params);
    }

    /**
     * Returns the server address for market album photo upload.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getMarketAlbumUploadServer(array $params = array()) {
        return $this->http->post('photos.getMarketAlbumUploadServer', $params);
    }

    /**
     * Saves market photos after successful uploading.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - string photo: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
     *      - integer server: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
     *      - string hash: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
     *      - string crop_data: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
     *      - string crop_hash: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamHashException Invalid hash
     * @throws VKApiParamPhotoException Invalid photo
     *
     */
    public function saveMarketPhoto(array $params = array()) {
        return $this->http->post('photos.saveMarketPhoto', $params);
    }

    /**
     * Saves cover photo after successful uploading.
     *
     *
     * @param $params array
     *      - string photo: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
     *      - string hash: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamPhotoException Invalid photo
     *
     */
    public function saveOwnerCoverPhoto(array $params = array()) {
        return $this->http->post('photos.saveOwnerCoverPhoto', $params);
    }

    /**
     * Saves market album photos after successful uploading.
     *
     *
     * @param $params array
     *      - integer group_id: Community ID.
     *      - string photo: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
     *      - integer server: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
     *      - string hash: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamHashException Invalid hash
     * @throws VKApiParamPhotoException Invalid photo
     *
     */
    public function saveMarketAlbumPhoto(array $params = array()) {
        return $this->http->post('photos.saveMarketAlbumPhoto', $params);
    }

    /**
     * Saves a profile or community photo. Upload URL can be got with the
     * [vk.com/dev/photos.getOwnerPhotoUploadServer|photos.getOwnerPhotoUploadServer] method.
     *
     *
     * @param $params array
     *      - string server: parameter returned after [vk.com/dev/upload_files|photo upload].
     *      - string hash: parameter returned after [vk.com/dev/upload_files|photo upload].
     *      - string photo: parameter returned after [vk.com/dev/upload_files|photo upload].
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamPhotoException Invalid photo
     *
     */
    public function saveOwnerPhoto(array $params = array()) {
        return $this->http->post('photos.saveOwnerPhoto', $params);
    }

    /**
     * Saves a photo to a user's or community's wall after being uploaded.
     *
     *
     * @param $params array
     *      - integer user_id: ID of the user on whose wall the photo will be saved.
     *      - integer group_id: ID of community on whose wall the photo will be saved.
     *      - string photo: Parameter returned when the the photo is [vk.com/dev/upload_files|uploaded to the
     *        server].
     *      - integer server:
     *      - string hash:
     *      - number latitude: Geographical latitude, in degrees (from '-90' to '90').
     *      - number longitude: Geographical longitude, in degrees (from '-180' to '180').
     *      - string caption: Text describing the photo. 2048 digits max.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamAlbumIdException Invalid album id
     * @throws VKApiParamServerException Invalid server
     * @throws VKApiParamHashException Invalid hash
     *
     */
    public function saveWallPhoto(array $params = array()) {
        return $this->http->post('photos.saveWallPhoto', $params);
    }

    /**
     * Returns the server address for photo upload onto a user's wall.
     *
     *
     * @param $params array
     *      - integer group_id: ID of community to whose wall the photo will be uploaded.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getWallUploadServer(array $params = array()) {
        return $this->http->post('photos.getWallUploadServer', $params);
    }

    /**
     * Returns the server address for photo upload in a private message for a user.
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getMessagesUploadServer(array $params = array()) {
        return $this->http->post('photos.getMessagesUploadServer', $params);
    }

    /**
     * Saves a photo after being successfully uploaded. URL obtained with
     * [vk.com/dev/photos.getMessagesUploadServer|photos.getMessagesUploadServer] method.
     *
     *
     * @param $params array
     *      - string photo: Parameter returned when the photo is [vk.com/dev/upload_files|uploaded to the server].
     *      - integer server:
     *      - string hash:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamAlbumIdException Invalid album id
     * @throws VKApiParamServerException Invalid server
     * @throws VKApiParamHashException Invalid hash
     *
     */
    public function saveMessagesPhoto(array $params = array()) {
        return $this->http->post('photos.saveMessagesPhoto', $params);
    }

    /**
     * Reports (submits a complaint about) a photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer photo_id: Photo ID.
     *      - PhotosReportReason reason: Reason for the complaint: '0' – spam, '1' – child pornography, '2' –
     *        extremism, '3' – violence, '4' – drug propaganda, '5' – adult material, '6' – insult, abuse
     * @see PhotosReportReason
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function report(array $params = array()) {
        return $this->http->post('photos.report', $params);
    }

    /**
     * Reports (submits a complaint about) a comment on a photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer comment_id: ID of the comment being reported.
     *      - PhotosReportCommentReason reason: Reason for the complaint: '0' – spam, '1' – child pornography,
     *        '2' – extremism, '3' – violence, '4' – drug propaganda, '5' – adult material, '6' – insult, abuse
     * @see PhotosReportCommentReason
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function reportComment(array $params = array()) {
        return $this->http->post('photos.reportComment', $params);
    }

    /**
     * Returns a list of photos.
     *
     *
     * @param $params array
     *      - string q: Search query string.
     *      - number lat: Geographical latitude, in degrees (from '-90' to '90').
     *      - number long: Geographical longitude, in degrees (from '-180' to '180').
     *      - integer start_time:
     *      - integer end_time:
     *      - integer sort: Sort order:
     *      - integer offset: Offset needed to return a specific subset of photos.
     *      - integer count: Number of photos to return.
     *      - integer radius: Radius of search in meters (works very approximately). Available values: '10', '100',
     *        '800', '6000', '50000'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function search(array $params = array()) {
        return $this->http->post('photos.search', $params);
    }

    /**
     * Saves photos after successful uploading.
     *
     *
     * @param $params array
     *      - integer album_id: ID of the album to save photos to.
     *      - integer group_id: ID of the community to save photos to.
     *      - integer server: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
     *      - string photos_list: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
     *      - string hash: Parameter returned when photos are [vk.com/dev/upload_files|uploaded to server].
     *      - number latitude: Geographical latitude, in degrees (from '-90' to '90').
     *      - number longitude: Geographical longitude, in degrees (from '-180' to '180').
     *      - string caption: Text describing the photo. 2048 digits max.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamAlbumIdException Invalid album id
     * @throws VKApiParamServerException Invalid server
     * @throws VKApiParamHashException Invalid hash
     *
     */
    public function save(array $params = array()) {
        return $this->http->post('photos.save', $params);
    }

    /**
     * Allows to copy a photo to the "Saved photos" album
     *
     *
     * @param $params array
     *      - integer owner_id: photo's owner ID
     *      - integer photo_id: photo ID
     *      - string access_key: for private photos
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function copy(array $params = array()) {
        return $this->http->post('photos.copy', $params);
    }

    /**
     * Edits the caption of a photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer photo_id: Photo ID.
     *      - string caption: New caption for the photo. If this parameter is not set, it is considered to be equal
     *        to an empty string.
     *      - number latitude:
     *      - number longitude:
     *      - string place_str:
     *      - string foursquare_id:
     *      - boolean delete_place:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function edit(array $params = array()) {
        return $this->http->post('photos.edit', $params);
    }

    /**
     * Moves a photo from one album to another.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer target_album_id: ID of the album to which the photo will be moved.
     *      - integer photo_id: Photo ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function move(array $params = array()) {
        return $this->http->post('photos.move', $params);
    }

    /**
     * Makes a photo into an album cover.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer photo_id: Photo ID.
     *      - integer album_id: Album ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function makeCover(array $params = array()) {
        return $this->http->post('photos.makeCover', $params);
    }

    /**
     * Reorders the album in the list of user albums.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the album.
     *      - integer album_id: Album ID.
     *      - integer before: ID of the album before which the album in question shall be placed.
     *      - integer after: ID of the album after which the album in question shall be placed.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function reorderAlbums(array $params = array()) {
        return $this->http->post('photos.reorderAlbums', $params);
    }

    /**
     * Reorders the photo in the list of photos of the user album.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer photo_id: Photo ID.
     *      - integer before: ID of the photo before which the photo in question shall be placed.
     *      - integer after: ID of the photo after which the photo in question shall be placed.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamPhotosException Invalid photos
     *
     */
    public function reorderPhotos(array $params = array()) {
        return $this->http->post('photos.reorderPhotos', $params);
    }

    /**
     * Returns a list of photos belonging to a user or community, in reverse chronological order.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of a user or community that owns the photos. Use a negative value to designate a
     *        community ID.
     *      - boolean extended: '1' — to return detailed information about photos
     *      - integer offset: Offset needed to return a specific subset of photos. By default, '0'.
     *      - integer count: Number of photos to return.
     *      - boolean photo_sizes: '1' – to return image sizes in [vk.com/dev/photo_sizes|special format].
     *      - boolean no_service_albums: '1' – to return photos only from standard albums, '0' – to return all
     *        photos including those in service albums, e.g., 'My wall photos' (default)
     *      - boolean need_hidden: '1' – to show information about photos being hidden from the block above the
     *        wall.
     *      - boolean skip_hidden: '1' – not to return photos being hidden from the block above the wall. Works
     *        only with owner_id>0, no_service_albums is ignored.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiBlockedException Content blocked
     *
     */
    public function getAll(array $params = array()) {
        return $this->http->post('photos.getAll', $params);
    }

    /**
     * Returns a list of photos in which a user is tagged.
     *
     *
     * @param $params array
     *      - integer user_id: User ID.
     *      - integer offset: Offset needed to return a specific subset of photos. By default, '0'.
     *      - integer count: Number of photos to return. Maximum value is 1000.
     *      - boolean extended: '1' — to return an additional 'likes' field, '0' — (default)
     *      - string sort: Sort order: '1' — by date the tag was added in ascending order, '0' — by date the
     *        tag was added in descending order
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getUserPhotos(array $params = array()) {
        return $this->http->post('photos.getUserPhotos', $params);
    }

    /**
     * Deletes a photo album belonging to the current user.
     *
     *
     * @param $params array
     *      - integer album_id: Album ID.
     *      - integer group_id: ID of the community that owns the album.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamAlbumIdException Invalid album id
     *
     */
    public function deleteAlbum(array $params = array()) {
        return $this->http->post('photos.deleteAlbum', $params);
    }

    /**
     * Deletes a photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer photo_id: Photo ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function delete(array $params = array()) {
        return $this->http->post('photos.delete', $params);
    }

    /**
     * Restores a deleted photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer photo_id: Photo ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function restore(array $params = array()) {
        return $this->http->post('photos.restore', $params);
    }

    /**
     * Confirms a tag on a photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - string photo_id: Photo ID.
     *      - integer tag_id: Tag ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function confirmTag(array $params = array()) {
        return $this->http->post('photos.confirmTag', $params);
    }

    /**
     * Returns a list of comments on a photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer photo_id: Photo ID.
     *      - boolean need_likes: '1' — to return an additional 'likes' field, '0' — (default)
     *      - integer start_comment_id:
     *      - integer offset: Offset needed to return a specific subset of comments. By default, '0'.
     *      - integer count: Number of comments to return.
     *      - PhotosGetCommentsSort sort: Sort order: 'asc' — old first, 'desc' — new first
     * @see PhotosGetCommentsSort
     *      - string access_key:
     *      - boolean extended:
     *      - array fields:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getComments(array $params = array()) {
        return $this->http->post('photos.getComments', $params);
    }

    /**
     * Returns a list of comments on a specific photo album or all albums of the user sorted in reverse chronological
     * order.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the album(s).
     *      - integer album_id: Album ID. If the parameter is not set, comments on all of the user's albums will be
     *        returned.
     *      - boolean need_likes: '1' — to return an additional 'likes' field, '0' — (default)
     *      - integer offset: Offset needed to return a specific subset of comments. By default, '0'.
     *      - integer count: Number of comments to return. By default, '20'. Maximum value, '100'.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiParamAlbumIdException Invalid album id
     *
     */
    public function getAllComments(array $params = array()) {
        return $this->http->post('photos.getAllComments', $params);
    }

    /**
     * Adds a new comment on the photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer photo_id: Photo ID.
     *      - string message: Comment text.
     *      - array attachments: (Required if 'message' is not set.) List of objects attached to the post, in the
     *        following format: "<owner_id>_<media_id>,<owner_id>_<media_id>", '' — Type of media attachment: 'photo'
     *        — photo, 'video' — video, 'audio' — audio, 'doc' — document, '<owner_id>' — Media attachment owner
     *        ID. '<media_id>' — Media attachment ID. Example: "photo100172_166443618,photo66748_265827614"
     *      - boolean from_group: '1' — to post a comment from the community
     *      - integer reply_to_comment:
     *      - integer sticker_id:
     *      - string access_key:
     *      - string guid:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function createComment(array $params = array()) {
        return $this->http->post('photos.createComment', $params);
    }

    /**
     * Deletes a comment on the photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer comment_id: Comment ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function deleteComment(array $params = array()) {
        return $this->http->post('photos.deleteComment', $params);
    }

    /**
     * Restores a deleted comment on a photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer comment_id: ID of the deleted comment.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function restoreComment(array $params = array()) {
        return $this->http->post('photos.restoreComment', $params);
    }

    /**
     * Edits a comment on a photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer comment_id: Comment ID.
     *      - string message: New text of the comment.
     *      - array attachments: (Required if 'message' is not set.) List of objects attached to the post, in the
     *        following format: "<owner_id>_<media_id>,<owner_id>_<media_id>", '' — Type of media attachment: 'photo'
     *        — photo, 'video' — video, 'audio' — audio, 'doc' — document, '<owner_id>' — Media attachment owner
     *        ID. '<media_id>' — Media attachment ID. Example: "photo100172_166443618,photo66748_265827614"
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function editComment(array $params = array()) {
        return $this->http->post('photos.editComment', $params);
    }

    /**
     * Returns a list of tags on a photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer photo_id: Photo ID.
     *      - string access_key:
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getTags(array $params = array()) {
        return $this->http->post('photos.getTags', $params);
    }

    /**
     * Adds a tag on the photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer photo_id: Photo ID.
     *      - integer user_id: ID of the user to be tagged.
     *      - number x: Upper left-corner coordinate of the tagged area (as a percentage of the photo's width).
     *      - number y: Upper left-corner coordinate of the tagged area (as a percentage of the photo's height).
     *      - number x2: Lower right-corner coordinate of the tagged area (as a percentage of the photo's width).
     *      - number y2: Lower right-corner coordinate of the tagged area (as a percentage of the photo's height).
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function putTag(array $params = array()) {
        return $this->http->post('photos.putTag', $params);
    }

    /**
     * Removes a tag from a photo.
     *
     *
     * @param $params array
     *      - integer owner_id: ID of the user or community that owns the photo.
     *      - integer photo_id: Photo ID.
     *      - integer tag_id: Tag ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function removeTag(array $params = array()) {
        return $this->http->post('photos.removeTag', $params);
    }

    /**
     * Returns a list of photos with tags that have not been viewed.
     *
     *
     * @param $params array
     *      - integer offset: Offset needed to return a specific subset of photos.
     *      - integer count: Number of photos to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getNewTags(array $params = array()) {
        return $this->http->post('photos.getNewTags', $params);
    }
}
