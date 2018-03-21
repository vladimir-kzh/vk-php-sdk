<?php

namespace VK\Actions;

use VK\Actions\Enums\AdsCheckLinkLinkType;
use VK\Actions\Enums\AdsGetDemographicsIdsType;
use VK\Actions\Enums\AdsGetDemographicsPeriod;
use VK\Actions\Enums\AdsGetStatisticsIdsType;
use VK\Actions\Enums\AdsGetStatisticsPeriod;
use VK\Actions\Enums\AdsGetSuggestionsLang;
use VK\Actions\Enums\AdsGetSuggestionsSection;
use VK\Actions\Enums\AdsGetTargetingStatsAdFormat;
use VK\Actions\Enums\AdsGetUploadURLAdFormat;
use VK\Client\VKHttpClient;
use VK\Exceptions\Api\VKApiAdsPartialSuccessException;
use VK\Exceptions\Api\VKApiAdsPermissionException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\Api\VKApiWeightedFloodException;
use VK\Exceptions\VKClientException;

class Ads {

    /**
     * @var VKHttpClient
     */
    private $http;

    /**
     * Ads constructor.
     * @param VKHttpClient $http
     */
    public function __construct(VKHttpClient $http) {
        $this->http = $http;
    }

    /**
     * Returns a list of advertising accounts.
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getAccounts(array $params = array()) {
        return $this->http->post('ads.getAccounts', $params);
    }

    /**
     * Returns a list of advertising agency's clients.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function getClients(array $params = array()) {
        return $this->http->post('ads.getClients', $params);
    }

    /**
     * Creates clients of an advertising agency.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - string data: Serialized JSON array of objects that describe created campaigns. Description of
     *        'client_specification' objects see below.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAdsPartialSuccessException Some part of the request has not been completed
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function createClients(array $params = array()) {
        return $this->http->post('ads.createClients', $params);
    }

    /**
     * Edits clients of an advertising agency.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - string data: Serialized JSON array of objects that describe changes in clients. Description of
     *        'client_mod' objects see below.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function updateClients(array $params = array()) {
        return $this->http->post('ads.updateClients', $params);
    }

    /**
     * Archives clients of an advertising agency.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - string ids: Serialized JSON array with IDs of deleted clients.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function deleteClients(array $params = array()) {
        return $this->http->post('ads.deleteClients', $params);
    }

    /**
     * Returns a list of campaigns in an advertising account.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - integer client_id: 'For advertising agencies'. ID of the client advertising campaigns are retrieved
     *        from.
     *      - boolean include_deleted: Flag that specifies whether archived ads shall be shown. *0 — show only
     *        active campaigns,, *1 — show all campaigns.
     *      - string campaign_ids: Filter of advertising campaigns to show. Serialized JSON array with campaign
     *        IDs. Only campaigns that exist in 'campaign_ids' and belong to the specified advertising account will be
     *        shown. If the parameter is null, all campaigns will be shown.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function getCampaigns(array $params = array()) {
        return $this->http->post('ads.getCampaigns', $params);
    }

    /**
     * Creates advertising campaigns.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - string data: Serialized JSON array of objects that describe created campaigns. Description of
     *        'campaign_specification' objects see below.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAdsPartialSuccessException Some part of the request has not been completed
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function createCampaigns(array $params = array()) {
        return $this->http->post('ads.createCampaigns', $params);
    }

    /**
     * Edits advertising campaigns.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - string data: Serialized JSON array of objects that describe changes in campaigns. Description of
     *        'campaign_mod' objects see below.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAdsPartialSuccessException Some part of the request has not been completed
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function updateCampaigns(array $params = array()) {
        return $this->http->post('ads.updateCampaigns', $params);
    }

    /**
     * Archives advertising campaigns.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - string ids: Serialized JSON array with IDs of deleted campaigns.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function deleteCampaigns(array $params = array()) {
        return $this->http->post('ads.deleteCampaigns', $params);
    }

    /**
     * Returns number of ads.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - integer client_id: 'Available and required for advertising agencies.' ID of the client ads are
     *        retrieved from.
     *      - boolean include_deleted: Flag that specifies whether archived ads shall be shown: *0 — show only
     *        active ads,, *1 — show all ads.
     *      - string campaign_ids: Filter by advertising campaigns. Serialized JSON array with campaign IDs. If the
     *        parameter is null, ads of all campaigns will be shown.
     *      - string ad_ids: Filter by ads. Serialized JSON array with ad IDs. If the parameter is null, all ads
     *        will be shown.
     *      - integer limit: Limit of number of returned ads. Used only if ad_ids parameter is null, and
     *        'campaign_ids' parameter contains ID of only one campaign.
     *      - integer offset: Offset. Used in the same cases as 'limit' parameter.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function getAds(array $params = array()) {
        return $this->http->post('ads.getAds', $params);
    }

    /**
     * Returns descriptions of ad layouts.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - integer client_id: 'For advertising agencies.' ID of the client ads are retrieved from.
     *      - boolean include_deleted: Flag that specifies whether archived ads shall be shown. *0 — show only
     *        active ads,, *1 — show all ads.
     *      - string campaign_ids: Filter by advertising campaigns. Serialized JSON array with campaign IDs. If the
     *        parameter is null, ads of all campaigns will be shown.
     *      - string ad_ids: Filter by ads. Serialized JSON array with ad IDs. If the parameter is null, all ads
     *        will be shown.
     *      - integer limit: Limit of number of returned ads. Used only if 'ad_ids' parameter is null, and
     *        'campaign_ids' parameter contains ID of only one campaign.
     *      - integer offset: Offset. Used in the same cases as 'limit' parameter.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function getAdsLayout(array $params = array()) {
        return $this->http->post('ads.getAdsLayout', $params);
    }

    /**
     * Returns ad targeting parameters.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - integer client_id: 'For advertising agencies.' ID of the client ads are retrieved from.
     *      - boolean include_deleted: flag that specifies whether archived ads shall be shown: *0 — show only
     *        active ads,, *1 — show all ads.
     *      - string campaign_ids: Filter by advertising campaigns. Serialized JSON array with campaign IDs. If the
     *        parameter is null, ads of all campaigns will be shown.
     *      - string ad_ids: Filter by ads. Serialized JSON array with ad IDs. If the parameter is null, all ads
     *        will be shown.
     *      - integer limit: Limit of number of returned ads. Used only if 'ad_ids' parameter is null, and
     *        'campaign_ids' parameter contains ID of only one campaign.
     *      - integer offset: Offset needed to return a specific subset of results.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function getAdsTargeting(array $params = array()) {
        return $this->http->post('ads.getAdsTargeting', $params);
    }

    /**
     * Creates ads.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - string data: Serialized JSON array of objects that describe created ads. Description of
     *        'ad_specification' objects see below.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiAdsPartialSuccessException Some part of the request has not been completed
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function createAds(array $params = array()) {
        return $this->http->post('ads.createAds', $params);
    }

    /**
     * Edits ads.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - string data: Serialized JSON array of objects that describe changes in ads. Description of
     *        'ad_edit_specification' objects see below.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function updateAds(array $params = array()) {
        return $this->http->post('ads.updateAds', $params);
    }

    /**
     * Archives ads.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - string ids: Serialized JSON array with ad IDs.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function deleteAds(array $params = array()) {
        return $this->http->post('ads.deleteAds', $params);
    }

    /**
     * Allows to check the ad link.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - AdsCheckLinkLinkType link_type: Object type: *'community' — community,, *'post' — community
     *        post,, *'application' — VK application,, *'video' — video,, *'site' — external site.
     * @see AdsCheckLinkLinkType
     *      - string link_url: Object URL.
     *      - integer campaign_id: Campaign ID
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function checkLink(array $params = array()) {
        return $this->http->post('ads.checkLink', $params);
    }

    /**
     * Returns statistics of performance indicators for ads, campaigns, clients or the whole account.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - AdsGetStatisticsIdsType ids_type: Type of requested objects listed in 'ids' parameter: *ad — ads,,
     *        *campaign — campaigns,, *client — clients,, *office — account.
     * @see AdsGetStatisticsIdsType
     *      - string ids: IDs requested ads, campaigns, clients or account, separated with a comma, depending on
     *        the value set in 'ids_type'. Maximum 2000 objects.
     *      - AdsGetStatisticsPeriod period: Data grouping by dates: *day — statistics by days,, *month —
     *        statistics by months,, *overall — overall statistics. 'date_from' and 'date_to' parameters set temporary
     *        limits.
     * @see AdsGetStatisticsPeriod
     *      - string date_from: Date to show statistics from. For different value of 'period' different date format
     *        is used: *day: YYYY-MM-DD, example: 2011-09-27 — September 27, 2011, **0 — day it was created on,,
     *        *month: YYYY-MM, example: 2011-09 — September 2011, **0 — month it was created in,, *overall: 0.
     *      - string date_to: Date to show statistics to. For different value of 'period' different date format is
     *        used: *day: YYYY-MM-DD, example: 2011-09-27 — September 27, 2011, **0 — current day,, *month: YYYY-MM,
     *        example: 2011-09 — September 2011, **0 — current month,, *overall: 0.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function getStatistics(array $params = array()) {
        return $this->http->post('ads.getStatistics', $params);
    }

    /**
     * Returns demographics for ads or campaigns.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - AdsGetDemographicsIdsType ids_type: Type of requested objects listed in 'ids' parameter: *ad —
     *        ads,, *campaign — campaigns.
     * @see AdsGetDemographicsIdsType
     *      - string ids: IDs requested ads or campaigns, separated with a comma, depending on the value set in
     *        'ids_type'. Maximum 2000 objects.
     *      - AdsGetDemographicsPeriod period: Data grouping by dates: *day — statistics by days,, *month —
     *        statistics by months,, *overall — overall statistics. 'date_from' and 'date_to' parameters set temporary
     *        limits.
     * @see AdsGetDemographicsPeriod
     *      - string date_from: Date to show statistics from. For different value of 'period' different date format
     *        is used: *day: YYYY-MM-DD, example: 2011-09-27 — September 27, 2011, **0 — day it was created on,,
     *        *month: YYYY-MM, example: 2011-09 — September 2011, **0 — month it was created in,, *overall: 0.
     *      - string date_to: Date to show statistics to. For different value of 'period' different date format is
     *        used: *day: YYYY-MM-DD, example: 2011-09-27 — September 27, 2011, **0 — current day,, *month: YYYY-MM,
     *        example: 2011-09 — September 2011, **0 — current month,, *overall: 0.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function getDemographics(array $params = array()) {
        return $this->http->post('ads.getDemographics', $params);
    }

    /**
     * Allows to get detailed information about the ad post reach.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - string ads_ids: Ads IDS separated by comma.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     * @throws VKApiAdsPermissionException Permission denied. You have no access to operations specified with given object(s)
     *
     */
    public function getAdsPostsReach(array $params = array()) {
        return $this->http->post('ads.getAdsPostsReach', $params);
    }

    /**
     * Returns current budget of the advertising account.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function getBudget(array $params = array()) {
        return $this->http->post('ads.getBudget', $params);
    }

    /**
     * Returns a list of managers and supervisors of advertising account.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function getOfficeUsers(array $params = array()) {
        return $this->http->post('ads.getOfficeUsers', $params);
    }

    /**
     * Adds managers and/or supervisors to advertising account.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - string data: Serialized JSON array of objects that describe added managers. Description of
     *        'user_specification' objects see below.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function addOfficeUsers(array $params = array()) {
        return $this->http->post('ads.addOfficeUsers', $params);
    }

    /**
     * Removes managers and/or supervisors from advertising account.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - string ids: Serialized JSON array with IDs of deleted managers.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function removeOfficeUsers(array $params = array()) {
        return $this->http->post('ads.removeOfficeUsers', $params);
    }

    /**
     * Returns the size of targeting audience, and also recommended values for CPC and CPM.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - string criteria: Serialized JSON object that describes targeting parameters. Description of
     *        'criteria' object see below.
     *      - integer ad_id: ID of an ad which targeting parameters shall be analyzed.
     *      - AdsGetTargetingStatsAdFormat ad_format: Ad format. Possible values: *'1' — image and text,, *'2'
     *        — big image,, *'3' — exclusive format,, *'4' — community, square image,, *'7' — special app format,,
     *        *'8' — special community format,, *'9' — post in community,, *'10' — app board.
     * @see AdsGetTargetingStatsAdFormat
     *      - string ad_platform: Platforms to use for ad showing. Possible values: (for 'ad_format' = '1'), *'0'
     *        — VK and partner sites,, *'1' — VK only. (for 'ad_format' = '9'), *'all' — all platforms,, *'desktop'
     *        — desktop version,, *'mobile' — mobile version and apps.
     *      - string link_url: URL for the advertised object.
     *      - string link_domain: Domain of the advertised object.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function getTargetingStats(array $params = array()) {
        return $this->http->post('ads.getTargetingStats', $params);
    }

    /**
     * Returns a set of auto-suggestions for various targeting parameters.
     *
     *
     * @param $params array
     *      - AdsGetSuggestionsSection section: Section, suggestions are retrieved in. Available values: *countries
     *        — request of a list of countries. If q is not set or blank, a short list of countries is shown. Otherwise,
     *        a full list of countries is shown. *regions — requested list of regions. 'country' parameter is required.
     *        *cities — requested list of cities. 'country' parameter is required. *districts — requested list of
     *        districts. 'cities' parameter is required. *stations — requested list of subway stations. 'cities'
     *        parameter is required. *streets — requested list of streets. 'cities' parameter is required. *schools —
     *        requested list of educational organizations. 'cities' parameter is required. *interests — requested list
     *        of interests. *positions — requested list of positions (professions). *group_types — requested list of
     *        group types. *religions — requested list of religious commitments. *browsers — requested list of
     *        browsers and mobile devices.
     * @see AdsGetSuggestionsSection
     *      - string ids: Objects IDs separated by commas. If the parameter is passed, 'q, country, cities' should
     *        not be passed.
     *      - string q: Filter-line of the request (for countries, regions, cities, streets, schools, interests,
     *        positions).
     *      - integer country: ID of the country objects are searched in.
     *      - string cities: IDs of cities where objects are searched in, separated with a comma.
     *      - AdsGetSuggestionsLang lang: Language of the returned string values. Supported languages: *ru —
     *        Russian,, *ua — Ukrainian,, *en — English.
     * @see AdsGetSuggestionsLang
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getSuggestions(array $params = array()) {
        return $this->http->post('ads.getSuggestions', $params);
    }

    /**
     * Returns a list of possible ad categories.
     *
     *
     * @param $params array
     *      - string lang: Language. The full list of supported languages is [vk.com/dev/api_requests|here].
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getCategories(array $params = array()) {
        return $this->http->post('ads.getCategories', $params);
    }

    /**
     * Returns URL to upload an ad photo to.
     *
     *
     * @param $params array
     *      - AdsGetUploadURLAdFormat ad_format: Ad format: *1 — image and text,, *2 — big image,, *3 —
     *        exclusive format,, *4 — community, square image,, *7 — special app format.
     * @see AdsGetUploadURLAdFormat
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getUploadURL(array $params = array()) {
        return $this->http->post('ads.getUploadURL', $params);
    }

    /**
     * Returns URL to upload an ad video to.
     *
     *
     * @param $params array
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getVideoUploadURL(array $params = array()) {
        return $this->http->post('ads.getVideoUploadURL', $params);
    }

    /**
     * Returns information about current state of a counter — number of remaining runs of methods and time to the
     * next counter nulling in seconds.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     *
     */
    public function getFloodStats(array $params = array()) {
        return $this->http->post('ads.getFloodStats', $params);
    }

    /**
     * Returns a reason of ad rejection for pre-moderation.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - integer ad_id: Ad ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function getRejectionReason(array $params = array()) {
        return $this->http->post('ads.getRejectionReason', $params);
    }

    /**
     * Creates a group to re-target ads for users who visited advertiser's site (viewed information about the product,
     * registered, etc.).
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - integer client_id: 'Only for advertising agencies.', ID of the client with the advertising account
     *        where the group will be created.
     *      - string name: Name of the target group — a string up to 64 characters long.
     *      - string domain: Domain of the site where user accounting code will be placed.
     *      - integer lifetime: 'For groups with auditory created with pixel code only.', , Number of days after
     *        that users will be automatically removed from the group. '0' — not to remove users.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function createTargetGroup(array $params = array()) {
        return $this->http->post('ads.createTargetGroup', $params);
    }

    /**
     * Edits a retarget group.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - integer client_id: 'Only for advertising agencies.' , ID of the client with the advertising account
     *        where the group will be created.
     *      - integer target_group_id: Group ID.
     *      - string name: New name of the target group — a string up to 64 characters long.
     *      - string domain: Domain of the site where user accounting code will be placed.
     *      - integer lifetime: 'Only for the groups that get audience from sites with user accounting code.', Time
     *        in days when users added to a retarget group will be automatically excluded from it. '0' – automatic
     *        exclusion is off.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function updateTargetGroup(array $params = array()) {
        return $this->http->post('ads.updateTargetGroup', $params);
    }

    /**
     * Deletes a retarget group.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - integer client_id: 'Only for advertising agencies.' , ID of the client with the advertising account
     *        where the group will be created.
     *      - integer target_group_id: Group ID.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function deleteTargetGroup(array $params = array()) {
        return $this->http->post('ads.deleteTargetGroup', $params);
    }

    /**
     * Returns a list of target groups.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - integer client_id: 'Only for advertising agencies.', ID of the client with the advertising account
     *        where the group will be created.
     *      - boolean extended: '1' — to return pixel code.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function getTargetGroups(array $params = array()) {
        return $this->http->post('ads.getTargetGroups', $params);
    }

    /**
     * Imports a list of advertiser's contacts to count VK registered users against the target group.
     *
     *
     * @param $params array
     *      - integer account_id: Advertising account ID.
     *      - integer client_id: 'Only for advertising agencies.' , ID of the client with the advertising account
     *        where the group will be created.
     *      - integer target_group_id: Target group ID.
     *      - string contacts: List of phone numbers, emails or user IDs separated with a comma.
     *
     * @return mixed
     * @throws VKClientException in case of network error
     * @throws VKApiException in case of API error
     * @throws VKApiWeightedFloodException Permission denied. You have requested too many actions this day. Try later.
     *
     */
    public function importTargetContacts(array $params = array()) {
        return $this->http->post('ads.importTargetContacts', $params);
    }
}
