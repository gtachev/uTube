function likeDislikeVideo(videoId, likeDislike) {
    var request = new XMLHttpRequest();
    var loggedUserId = document.getElementById('logged-user-id').value;
    var logged = document.getElementById('logged').value;
    if (logged === 'false') {
        swal({
            text: "Please sign in/up in order to be able like or dislike videos!",
            type: "info",
            confirmButtonColor: "rgb(92, 192, 220)"
        });
    } else {
        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var likeHtml = document.getElementById('video-like');
                var dislikeHtml = document.getElementById('video-dislike');
                var response = JSON.parse(this.responseText);
                likeHtml.innerHTML = response['likes'];
                dislikeHtml.innerHTML = response['dislikes'];
            }
        };
        request.open('GET', 'index.php?controller=video&action=likeDislikeVideo&like=' + likeDislike + '&video-id=' + videoId + '&user-id=' + loggedUserId);
        request.send();
    }
}

function likeDislikeComment(commentId, likeDislike) {
    var request = new XMLHttpRequest();
    var loggedUserId = document.getElementById('logged-user-id').value;
    var logged = document.getElementById('logged').value;
    if (logged === 'false') {
        swal({
            text: "Please sign in/up in order to be able like or dislike comments!",
            type: "info",
            confirmButtonColor: "rgb(92, 192, 220)"
        });
    } else {
        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var likeHtml = document.getElementById('comment-like-' + commentId);
                var dislikeHtml = document.getElementById('comment-dislike-'  + commentId);
                var response = JSON.parse(this.responseText);
                likeHtml.innerHTML = response['likes'];
                dislikeHtml.innerHTML = response['dislikes'];
            }
        };
        request.open('GET', 'index.php?controller=video&action=likeDislikeComment&like=' + likeDislike + '&comment-id=' + commentId + '&user-id=' + loggedUserId);
        request.send();
    }
}

function comment(videoId) {
    var loggedUserId = document.getElementById('logged-user-id').value;
    var logged = document.getElementById('logged').value;

    if (logged === 'false') {
        swal({
            text: "Please sign in/up in order to be able comment videos!",
            type: "info",
            confirmButtonColor: "rgb(92, 192, 220)"
        });
    } else {
       var commentText = document.getElementById('comment-field').value; // input field value
        if (commentText.trim().length > 0) {
            var request = new XMLHttpRequest();
            var commentField = document.getElementById('comment-section');
            request.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById('comment-field').value = '';
                    commentField.innerHTML = this.responseText;
                    document.getElementById('start').value = '4';
                }
            };
            request.open('POST', 'index.php?controller=video&action=comment', true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send("comment=" + commentText + '&video-id=' + videoId + '&user-id=' + loggedUserId);
        }
    }
}

