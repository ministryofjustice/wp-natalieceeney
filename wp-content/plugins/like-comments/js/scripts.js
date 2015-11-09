jQuery(document).ready(function($) {
    // Insert magic here.


    var likeComment = function(commentID, callback) {
        var data = {
            "action": "like_comment",
            "commentID": commentID
        };

        $.post(LikeComments.ajaxurl, data, function(response) {
            if (response.success) {
                callback(response.data);
            } else {
                alert('Unable to like this comment.\nMessage from server: ' + response.data.message);
            }
        });
    };

    $('.lc_like_button').on('click', function(e) {
        e.preventDefault();
        var commentID = $(this).data('comment-id');
        likeComment(commentID, likeCommentCallback(this));
    });

    var likeCommentCallback = function(likeButtonNode) {
        return function(responseData) {
            var likeButton = $(likeButtonNode);
            var likeCount = likeButton.parents('.comment').find('.lc_like_count');
            likeButton.replaceWith(responseData.likeButtonHtml);
            likeCount.replaceWith(responseData.likeCountHtml);
        }
    }
});