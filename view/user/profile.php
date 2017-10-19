<div class="col-md-10">
    <div class="row">
        <div class="col-md-2 col-md-offset-1 margin-top">
            <img src="<?= $params['userPhoto']; ?>" alt="" width="250" class="img-rounded" height="auto">
        </div>
        <div class="col-md-4 col-md-offset-2 margin-top">
            <h3 class="text-muted"><?= $params['username']; ?></h3>
        </div>
        <div class="col-md-4 col-md-offset-2">
            <h3 class="text-muted"><?= $params['subscribersCount']; ?> <small> subscribers</small></h3>
        </div>
    </div>
    <div class="row margin-top">
        <div class="col-md-11 col-md-offset-1">
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a data-toggle="tab" href="#home" onclick="getAboutPage(<?= $params['userId'] ?>)">Videos</a></li>
                <li><a data-toggle="tab" href="#menu1" onclick="getAboutPage(<?= $params['userId'] ?>)">Playlists</a></li>
                <li><a data-toggle="tab" href="#menu2">About</a></li>
            </ul>
            <div class="tab-content container-fluid">
                <div id="home" class="tab-pane fade in active">

                    <?php
                    /* @var $video \model\Video */
                        foreach ($params['videos'] as $video) {
                            $title = $video->getTitle();
                            $thumbnail = $video->getThumbnailURL();
                            $videoId = $video->getId();
                            echo "
                                <div class='col-md-3 margin-top'>
                                    <a href='index.php?page=watch&id=$videoId'>
                                        <img src='$thumbnail' class='img-rounded' width='200' height='auto'>
                                        <h4 class='text-left text-muted'>$title</h4>
                                    </a>
                                </div>";
                        }
                    ?>

                </div>
                <div id="menu1" class="tab-pane fade">
                    <h3>Menu 1</h3>
                    <p>Some content in menu 1.</p>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <div class="col-md-3 col-md-offset-2">
                        <h3 class="text-muted">Name: </h3>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-muted"><?= $params['firstName'] . ' ' . $params['lastName']; ?></h3>
                    </div>
                    <div class="col-md-1 margin-top">
                        <button class="btn btn-info" onclick="getEditForm(<?= $params['userId'] ?>)">Edit profile</button>
                    </div>
                    <div class="col-md-3 col-md-offset-2">
                        <h3 class="text-muted">Email: </h3>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-muted"><?= $params['email'] ?></h3>
                    </div>
                    <div class="col-md-3 col-md-offset-2">
                        <h3 class="text-muted">Member since: </h3>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-muted"><?= $params['dateJoined']; ?></h3>
                    </div>
                    <div class="col-md-3 col-md-offset-2">
                        <h3 class="text-muted">Subscriptions: </h3>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-muted"><?= $params['subscriptionsCount']; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>

