<?php
    $user = wp_get_current_user();
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        if ( in_array( 'administrator', $user->roles ) ) {
            // let them stay since admins can post
        } else {
            return wp_redirect(home_url());
        }
    } else {
        return wp_redirect(home_url());
    }
    include("header.php");
    include("header-custom.php");
?>

        <!-- <div class="container"> in header-custom.php -->
        <p class="home__link"><a href="/">Visit ElsieGram</a></p>
        <p class="home__link">Add Post</p>

        <form id="jsPostForm">
            <input id="jsPostFile" type="file" accept="image/*" class="post__input"/>
            <label id="jsInputLabel" for="jsPostFile" class="post__input-label">Choose An Image</label>
            <img id="target" class="post__target" style="display:none"/>
            <textarea name="caption" id="jsPostCaption" class="post__caption" placeholder="Caption" rows="6"></textarea>
            <button id="jsPostSubmit" class="post__submit">Submit Image</button>
        </form>
    </div>
    <script src="<?php echo ASSET_URL?>/js/post.js"></script>
</body>
</html>