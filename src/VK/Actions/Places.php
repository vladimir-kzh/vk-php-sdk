<?php

namespace VK\Actions;

use VK\Actions\Enums\PlacesSearchRadius;
use VK\Client\VKHttpClient;
use VK\Exceptions\Api\VKApiAccessCheckinException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiSameCheckinException;
use VK\Exceptions\VKClientException;

class Places {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Places constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Adds a new location to the location database.
     *
     *
     * @param $params array
     *      - integer type: ID of the location's type (e.g., '1' — Home, '2' — Work). To get location type IDs,
     *        use the [vk.com/dev/places.getTypes|places.getTypes] method.
     *      - string title: Title of the location.
     *      - number latitude: Geographical latitude, in degrees (from '-90' to '90').
     *      - number longitude: Geographical longitude, in degrees (from '-180' to '180').
     *      - integer country: ID of the location's country. To get country IDs, use the
     *        [vk.com/dev/database.getCountries|database.getCountries] method.
     *      - integer city: ID of the location's city. To get city IDs, use the
     *        [vk.com/dev/database.getCities|database.getCities] method.
     *      - string address: Street address of the location (e.g., '125 Elm Street').
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function add(array $params = array()) {
        return $this->http->post('places.add', $params);
    }

    /**
     * Returns information about locations by their IDs.
     *
     *
     * @param $params array
     *      - array places: Location IDs.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getById(array $params = array()) {
        return $this->http->post('places.getById', $params);
    }

    /**
     * Returns a list of locations that match the search criteria.
     *
     *
     * @param $params array
     *      - string q: Search query string.
     *      - integer city: City ID.
     *      - number latitude: Geographical latitude of the initial search point, in degrees (from '-90' to '90').
     *      - number longitude: Geographical longitude of the initial search point, in degrees (from '-180' to
     *        '180').
     *      - PlacesSearchRadius radius: Radius of the search zone: '1' — 100 m. (default), '2' — 800 m. '3'
     *        — 6 km. '4' — 50 km.
     * @see PlacesSearchRadius
     *      - integer offset: Offset needed to return a specific subset of locations.
     *      - integer count: Number of locations to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function search(array $params = array()) {
        return $this->http->post('places.search', $params);
    }

    /**
     * Checks a user in at the specified location.
     *
     *
     * @param $params array
     *      - integer place_id: Location ID.
     *      - string text: Text of the comment on the check-in (255 characters maximum, line breaks not supported).
     *      - number latitude: Geographical latitude of the check-in, in degrees (from '-90' to '90').
     *      - number longitude: Geographical longitude of the check-in, in degrees (from '-180' to '180').
     *      - boolean friends_only: '1' — Check-in will be available only for friends. '0' — Check-in will be
     *        available for all users (default).
     *      - array services: List of services or websites (e.g., 'twitter', 'facebook') to which the check-in will
     *        be exported, if the user has set up the respective option.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiSameCheckinException You have sent same checkin in last 10 minutes
     *
     */
    public function checkin(array $params = array()) {
        return $this->http->post('places.checkin', $params);
    }

    /**
     * Returns a list of user check-ins at locations according to the set parameters.
     *
     *
     * @param $params array
     *      - number latitude: Geographical latitude of the initial search point, in degrees (from '-90' to '90').
     *      - number longitude: Geographical longitude of the initial search point, in degrees (from '-180' to
     *        '180').
     *      - integer place: Location ID of check-ins to return. (Ignored if 'latitude' and 'longitude' are
     *        specified.)
     *      - integer user_id:
     *      - integer offset: Offset needed to return a specific subset of check-ins. (Ignored if 'timestamp' is
     *        not null.)
     *      - integer count: Number of check-ins to return. (Ignored if 'timestamp' is not null.)
     *      - integer timestamp: Specifies that only those check-ins created after the specified timestamp will be
     *        returned.
     *      - boolean friends_only: '1' — to return only check-ins with set geographical coordinates. (Ignored if
     *        'latitude' and 'longitude' are not set.)
     *      - boolean need_places: '1' — to return location information with the check-ins. (Ignored if 'place'
     *        is not set.),
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAccessCheckinException Access to checkins denied
     *
     */
    public function getCheckins(array $params = array()) {
        return $this->http->post('places.getCheckins', $params);
    }

    /**
     * Returns a list of all types of locations.
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getTypes(array $params = array()) {
        return $this->http->post('places.getTypes', $params);
    }
}
