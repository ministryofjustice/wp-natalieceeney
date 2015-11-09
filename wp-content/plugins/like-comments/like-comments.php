<?php
/**
 * Plugin Name: Like Comments
 * Description: Add ability for visitors to like comments. Comments will be sorted in order of popularity.
 * Version:     0.0.1
 * Author:      Ollie Treend
 */

require_once 'classes/Plugin.php';
require_once 'classes/Comment.php';

$LikeComments = new LikeComments\Plugin(__FILE__);

/**
 * Pieces of the puzzle
 *
 * 1. Add 'like' link to outputted comments.
 * 2. Ajax endpoint to record comment likes
 * 3. Data structure to store likes
 * 4. Sort comments based on popularity & date
 *
 *
 * Where did I get to?
 *  – Trying to describe what determines one user?
 *  – Should users be able to 'unlike' a comment?
 *  – Should users have a state, or are they always stateless? i.e. unlimited likes.
 *
 * Answers:
 *  1. Unknown visitors will be assigned a unique ID upon their first like.
 *     This will be stored as a cookie in the user's browser.
 *  2. The liked comment will be remembered in a 'comment_likes' table, with the comment ID and unique user ID.
 *     A cached count will be stored/updated as a meta field of the comment.
 *  3. The UI will change 'Like' button for a greyed-out 'Liked' button.
 *     User cannot 'unlike'.
 *
 * Considerations:
 *  – Upon comment delete, ensure that this cascades to remove associated 'comment_likes'.
 *  – Comments should be sorted by number of likes, and then by date.
 */
