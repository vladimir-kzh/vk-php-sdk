<?php

namespace VK\Client;

use VK\Actions\Account;
use VK\Actions\Ads;
use VK\Actions\Apps;
use VK\Actions\Auth;
use VK\Actions\Board;
use VK\Actions\Database;
use VK\Actions\Docs;
use VK\Actions\Fave;
use VK\Actions\Friends;
use VK\Actions\Gifts;
use VK\Actions\Groups;
use VK\Actions\Leads;
use VK\Actions\Likes;
use VK\Actions\Market;
use VK\Actions\Messages;
use VK\Actions\Newsfeed;
use VK\Actions\Notes;
use VK\Actions\Notifications;
use VK\Actions\Orders;
use VK\Actions\Pages;
use VK\Actions\Photos;
use VK\Actions\Places;
use VK\Actions\Polls;
use VK\Actions\Search;
use VK\Actions\Secure;
use VK\Actions\Stats;
use VK\Actions\Status;
use VK\Actions\Storage;
use VK\Actions\Stories;
use VK\Actions\Streaming;
use VK\Actions\Users;
use VK\Actions\Utils;
use VK\Actions\Video;
use VK\Actions\Wall;
use VK\Actions\Widgets;

class VKApiClient {
    protected const API_VERSION = '5.73';
    protected const API_HOST = 'https://api.vk.com/method';

    /**
     * @var VKHttpClient
     */
    private $httpClient;

    /**
     * @var Account
     */
    private $account;

    /**
     * @var Ads
     */
    private $ads;

    /**
     * @var Apps
     */
    private $apps;

    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Board
     */
    private $board;

    /**
     * @var Database
     */
    private $database;

    /**
     * @var Docs
     */
    private $docs;

    /**
     * @var Fave
     */
    private $fave;

    /**
     * @var Friends
     */
    private $friends;

    /**
     * @var Gifts
     */
    private $gifts;

    /**
     * @var Groups
     */
    private $groups;

    /**
     * @var Leads
     */
    private $leads;

    /**
     * @var Likes
     */
    private $likes;

    /**
     * @var Market
     */
    private $market;

    /**
     * @var Messages
     */
    private $messages;

    /**
     * @var Newsfeed
     */
    private $newsfeed;

    /**
     * @var Notes
     */
    private $notes;

    /**
     * @var Notifications
     */
    private $notifications;

    /**
     * @var Orders
     */
    private $orders;

    /**
     * @var Pages
     */
    private $pages;

    /**
     * @var Photos
     */
    private $photos;

    /**
     * @var Places
     */
    private $places;

    /**
     * @var Polls
     */
    private $polls;

    /**
     * @var Search
     */
    private $search;

    /**
     * @var Secure
     */
    private $secure;

    /**
     * @var Stats
     */
    private $stats;

    /**
     * @var Status
     */
    private $status;

    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var Stories
     */
    private $stories;

    /**
     * @var Streaming
     */
    private $streaming;

    /**
     * @var Users
     */
    private $users;

    /**
     * @var Utils
     */
    private $utils;

    /**
     * @var Video
     */
    private $video;

    /**
     * @var Wall
     */
    private $wall;

    /**
     * @var Widgets
     */
    private $widgets;

    /**
     * VKApiClient constructor.
     * @param VKHttpClient $httpClient
     */
    public function __construct(VKHttpClient $httpClient) {
        $this->httpClient = $httpClient;

        $this->account = new Account($this->httpClient);
        $this->ads = new Ads($this->httpClient);
        $this->apps = new Apps($this->httpClient);
        $this->auth = new Auth($this->httpClient);
        $this->board = new Board($this->httpClient);
        $this->database = new Database($this->httpClient);
        $this->docs = new Docs($this->httpClient);
        $this->fave = new Fave($this->httpClient);
        $this->friends = new Friends($this->httpClient);
        $this->gifts = new Gifts($this->httpClient);
        $this->groups = new Groups($this->httpClient);
        $this->leads = new Leads($this->httpClient);
        $this->likes = new Likes($this->httpClient);
        $this->market = new Market($this->httpClient);
        $this->messages = new Messages($this->httpClient);
        $this->newsfeed = new Newsfeed($this->httpClient);
        $this->notes = new Notes($this->httpClient);
        $this->notifications = new Notifications($this->httpClient);
        $this->orders = new Orders($this->httpClient);
        $this->pages = new Pages($this->httpClient);
        $this->photos = new Photos($this->httpClient);
        $this->places = new Places($this->httpClient);
        $this->polls = new Polls($this->httpClient);
        $this->search = new Search($this->httpClient);
        $this->secure = new Secure($this->httpClient);
        $this->stats = new Stats($this->httpClient);
        $this->status = new Status($this->httpClient);
        $this->storage = new Storage($this->httpClient);
        $this->stories = new Stories($this->httpClient);
        $this->streaming = new Streaming($this->httpClient);
        $this->users = new Users($this->httpClient);
        $this->utils = new Utils($this->httpClient);
        $this->video = new Video($this->httpClient);
        $this->wall = new Wall($this->httpClient);
        $this->widgets = new Widgets($this->httpClient);
    }

    /**
     * @return Account
     */
    public function account(): Account {
        return $this->account;
    }

    /**
     * @return Ads
     */
    public function ads(): Ads {
        return $this->ads;
    }

    /**
     * @return Apps
     */
    public function apps(): Apps {
        return $this->apps;
    }

    /**
     * @return Auth
     */
    public function auth(): Auth {
        return $this->auth;
    }

    /**
     * @return Board
     */
    public function board(): Board {
        return $this->board;
    }

    /**
     * @return Database
     */
    public function database(): Database {
        return $this->database;
    }

    /**
     * @return Docs
     */
    public function docs(): Docs {
        return $this->docs;
    }

    /**
     * @return Fave
     */
    public function fave(): Fave {
        return $this->fave;
    }

    /**
     * @return Friends
     */
    public function friends(): Friends {
        return $this->friends;
    }

    /**
     * @return Gifts
     */
    public function gifts(): Gifts {
        return $this->gifts;
    }

    /**
     * @return Groups
     */
    public function groups(): Groups {
        return $this->groups;
    }

    /**
     * @return Leads
     */
    public function leads(): Leads {
        return $this->leads;
    }

    /**
     * @return Likes
     */
    public function likes(): Likes {
        return $this->likes;
    }

    /**
     * @return Market
     */
    public function market(): Market {
        return $this->market;
    }

    /**
     * @return Messages
     */
    public function messages(): Messages {
        return $this->messages;
    }

    /**
     * @return Newsfeed
     */
    public function newsfeed(): Newsfeed {
        return $this->newsfeed;
    }

    /**
     * @return Notes
     */
    public function notes(): Notes {
        return $this->notes;
    }

    /**
     * @return Notifications
     */
    public function notifications(): Notifications {
        return $this->notifications;
    }

    /**
     * @return Orders
     */
    public function orders(): Orders {
        return $this->orders;
    }

    /**
     * @return Pages
     */
    public function pages(): Pages {
        return $this->pages;
    }

    /**
     * @return Photos
     */
    public function photos(): Photos {
        return $this->photos;
    }

    /**
     * @return Places
     */
    public function places(): Places {
        return $this->places;
    }

    /**
     * @return Polls
     */
    public function polls(): Polls {
        return $this->polls;
    }

    /**
     * @return Search
     */
    public function search(): Search {
        return $this->search;
    }

    /**
     * @return Secure
     */
    public function secure(): Secure {
        return $this->secure;
    }

    /**
     * @return Stats
     */
    public function stats(): Stats {
        return $this->stats;
    }

    /**
     * @return Status
     */
    public function status(): Status {
        return $this->status;
    }

    /**
     * @return Storage
     */
    public function storage(): Storage {
        return $this->storage;
    }

    /**
     * @return Stories
     */
    public function stories(): Stories {
        return $this->stories;
    }

    /**
     * @return Streaming
     */
    public function streaming(): Streaming {
        return $this->streaming;
    }

    /**
     * @return Users
     */
    public function users(): Users {
        return $this->users;
    }

    /**
     * @return Utils
     */
    public function utils(): Utils {
        return $this->utils;
    }

    /**
     * @return Video
     */
    public function video(): Video {
        return $this->video;
    }

    /**
     * @return Wall
     */
    public function wall(): Wall {
        return $this->wall;
    }

    /**
     * @return Widgets
     */
    public function widgets(): Widgets {
        return $this->widgets;
    }

}
