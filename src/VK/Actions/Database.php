<?php

namespace VK\Actions;

use VK\Client\VKHttpClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class Database {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Database constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns a list of countries.
     *
     *
     * @param $params array
     *      - boolean need_all: '1' — to return a full list of all countries, '0' — to return a list of
     *        countries near the current user's country (default).
     *      - string code: Country codes in [vk.com/dev/country_codes|ISO 3166-1 alpha-2] standard.
     *      - integer offset: Offset needed to return a specific subset of countries.
     *      - integer count: Number of countries to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getCountries(array $params = array()) {
        return $this->http->post('database.getCountries', $params);
    }

    /**
     * Returns a list of regions.
     *
     *
     * @param $params array
     *      - integer country_id: Country ID, received in [vk.com/dev/database.getCountries|database.getCountries]
     *        method.
     *      - string q: Search query.
     *      - integer offset: Offset needed to return specific subset of regions.
     *      - integer count: Number of regions to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getRegions(array $params = array()) {
        return $this->http->post('database.getRegions', $params);
    }

    /**
     * Returns information about streets by their IDs.
     *
     *
     * @param $params array
     *      - array street_ids: Street IDs.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getStreetsById(array $params = array()) {
        return $this->http->post('database.getStreetsById', $params);
    }

    /**
     * Returns information about countries by their IDs.
     *
     *
     * @param $params array
     *      - array country_ids: Country IDs.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getCountriesById(array $params = array()) {
        return $this->http->post('database.getCountriesById', $params);
    }

    /**
     * Returns a list of cities.
     *
     *
     * @param $params array
     *      - integer country_id: Country ID.
     *      - integer region_id: Region ID.
     *      - string q: Search query.
     *      - boolean need_all: '1' — to return all cities in the country, '0' — to return major cities in the
     *        country (default),
     *      - integer offset: Offset needed to return a specific subset of cities.
     *      - integer count: Number of cities to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getCities(array $params = array()) {
        return $this->http->post('database.getCities', $params);
    }

    /**
     * Returns information about cities by their IDs.
     *
     *
     * @param $params array
     *      - array city_ids: City IDs.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getCitiesById(array $params = array()) {
        return $this->http->post('database.getCitiesById', $params);
    }

    /**
     * Returns a list of higher education institutions.
     *
     *
     * @param $params array
     *      - string q: Search query.
     *      - integer country_id: Country ID.
     *      - integer city_id: City ID.
     *      - integer offset: Offset needed to return a specific subset of universities.
     *      - integer count: Number of universities to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getUniversities(array $params = array()) {
        return $this->http->post('database.getUniversities', $params);
    }

    /**
     * Returns a list of schools.
     *
     *
     * @param $params array
     *      - string q: Search query.
     *      - integer city_id: City ID.
     *      - integer offset: Offset needed to return a specific subset of schools.
     *      - integer count: Number of schools to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getSchools(array $params = array()) {
        return $this->http->post('database.getSchools', $params);
    }

    /**
     * Returns a list of school classes specified for the country.
     *
     *
     * @param $params array
     *      - integer country_id: Country ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getSchoolClasses(array $params = array()) {
        return $this->http->post('database.getSchoolClasses', $params);
    }

    /**
     * Returns a list of faculties (i.e., university departments).
     *
     *
     * @param $params array
     *      - integer university_id: University ID.
     *      - integer offset: Offset needed to return a specific subset of faculties.
     *      - integer count: Number of faculties to return.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getFaculties(array $params = array()) {
        return $this->http->post('database.getFaculties', $params);
    }

    /**
     * Returns list of chairs on a specified faculty.
     *
     *
     * @param $params array
     *      - integer faculty_id: id of the faculty to get chairs from
     *      - integer offset: offset required to get a certain subset of chairs
     *      - integer count: amount of chairs to get
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getChairs(array $params = array()) {
        return $this->http->post('database.getChairs', $params);
    }
}
