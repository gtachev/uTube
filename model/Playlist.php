<?php

namespace model;

class Playlist {
    private $id;
    private $title;
    private $dateAdded;
    private $creatorID;
    private $videosIDs;
    private $thumbnailURL;

    /**
     * Playlist constructor.
     * @param $title
     * @param $dateAdded
     * @param $creatorID
     * @param $videoIDs
     * @param $thumbnailURL
     */
    public function __construct($title, $dateAdded, $creatorID, Array $videoIDs, $thumbnailURL)
    {
        $this->title = $title;
        $this->dateAdded = $dateAdded;
        $this->creatorID = $creatorID;
        $this->videosIDs = $videoIDs;
        $this->thumbnailURL = $thumbnailURL;

    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param mixed $dateAdded
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
    }

    /**
     * @return mixed
     */
    public function getCreatorID()
    {
        return $this->creatorID;
    }

    /**
     * @param mixed $creatorID
     */
    public function setCreatorID($creatorID)
    {
        $this->creatorID = $creatorID;
    }

    /**
     * @return array
     */
    public function getVideosIDs()
    {
        return $this->videosIDs;
    }

    /**
     * @param array $videosIDs
     */
    public function setVideosIDs(Array $videosIDs)
    {
        $this->videosIDs = $videosIDs;
    }

    /**
     * @return mixed
     */
    public function getThumbnailURL()
    {
        return $this->thumbnailURL;
    }

    /**
     * @param mixed $thumbnailURL
     */
    public function setThumbnailURL($thumbnailURL)
    {
        $this->thumbnailURL = $thumbnailURL;
    }



}
