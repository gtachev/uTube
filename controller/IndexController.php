<?php

namespace controller;

use model\db\PlaylistDao;
use model\db\VideoDao;
use model\db\UserDao;
use model\User;

class IndexController extends BaseController {

    public function __construct() {

    }

    public function index() {
        try {
            $videoDao = VideoDao::getInstance();

            $totalLikedVideosCount = $videoDao->getTotalLikedCount()['total_liked_count'];
            $mostLikedPagesCount = ceil($totalLikedVideosCount / 4);
            $mostLikedVideos = $videoDao->getMostLiked(4, 0);

            $videosCount = $videoDao->getTotalCount()['total_count'];
            $newestPagesCount = ceil($videosCount / 4);
            $newestVideos = $videoDao->getNewest(4, 0);

            $this->render('index/index', [
                'most_liked' => $mostLikedVideos,
                'most_liked_pages_count' => $mostLikedPagesCount,
                'newest' => $newestVideos,
                'newest_pages_count' => $newestPagesCount
            ]);
        }
        catch (\Exception $e) {
            $this->render('index/error');
        }
    }

    public function search() {

        try {
            $videoDao = VideoDao::getInstance();
            $userDao = UserDao::getInstance();
            $playlistDao = PlaylistDao::getInstance();

            if (isset($_POST['search'])) {
                $searchOption = $_POST['search-option'];
                $value = $_POST['value'];
                $type = 'video';
                $offset = 0;
                $result = array();
                if (strlen(trim($value)) != 0) {
                    if ($searchOption === 'video') {
                        $result = $videoDao->searchByName($value, 5, $offset);
                    } else if ($searchOption === 'user') {
                        $type = 'user';
                        $result = $userDao->search($value, 5, $offset);
                    } else {
                        $type = 'playlist';
                        $result = $playlistDao->searchByName($value, 5, $offset);
                    }
                }
                $this->render('index/search', [
                        'type' => $type,
                        'result' => $result,
                        'value' => $value
                    ]);

            } else {
                if (isset($_GET['type'])) {
                    $searchOption = $_GET['type'];
                    $offset = $_GET['start'];
                    $searchValue = $_GET['value'];
                    $result = array();
                    $type = 'video';
                    if ($searchOption === 'video') {
                        $result = $videoDao->searchByName($searchValue, 5, $offset);
                    } else if ($searchOption === 'user') {
                        $type = 'user';
                        $result = $userDao->search($searchValue, 5, $offset);
                    } else {
                        $type = 'playlist';
                        $result = $playlistDao->searchByName($searchValue, 5, $offset);
                    }
                    $this->renderPartial('index/search-append', [
                        'type' => $type,
                        'result' => $result,
                        'value' => $searchValue
                    ]);
                    die();
                }

                $searchOption = $_GET['search-option'];
                if (is_null($searchOption)) {
                    header('Location:index.php');
                }
                $searchValue = $_GET['value'];

                if ($searchOption == 'video') {
                    $suggestions = $videoDao->getNameSuggestions($searchValue);
                } else if ($searchOption == 'user') {
                    $suggestions = $userDao->getSuggestionsByUsername($searchValue);
                } else {
                    $suggestions = $playlistDao->getNameSuggestions($searchValue);
                }

                $this->jsonEncodeParams([
                    'suggestions' => $suggestions
                ]);
            }
        }
        catch (\Exception $e) {
            $this->render('index/error');
        }
    }

    public function error() {
        $this->render('index/error');
    }

    public function loadVideos() {

        $page = isset($_GET['pg']) ? $_GET['pg'] : 1;
        $videoDao = VideoDao::getInstance();
        if ($_GET['row'] == '1') {
            $videosCount = $videoDao->getTotalLikedCount()['total_liked_count'];
            $pagesCount = ceil($videosCount / 4);
            if ($page > $pagesCount) {
                $page = $pagesCount;
            } elseif  ($page <= 0) {
                $page = 1;
            }
            $offset = $page * 4 - 4;
            $videos = $videoDao->getMostLiked(4, $offset);
            $this->renderPartial('index/most-liked', [
                'most_liked' => $videos
            ]);
        } else {
            $videosCount = $videoDao->getTotalCount()['total_count'];
            $pagesCount = ceil($videosCount / 4);
            if ($page > $pagesCount) {
                $page = $pagesCount;
            } elseif  ($page <= 0) {
                $page = 1;
            }
            $offset = $page * 4 - 4;
            $videos = $videoDao->getNewest(4, $offset);
            $this->renderPartial('index/newest', [
                'newest' => $videos
            ]);
        }
    }

}


