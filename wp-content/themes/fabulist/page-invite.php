<?php
    if(is_user_logged_in()) {
        wp_redirect("/");
        die();
    }
    include("header.php");
    include("header-custom.php");
?>
    <!-- <div class="container"> in header-custom.php -->
    <form id="jsInviteForm">
        <p class="invite__header">Request Invitation</p>
        <label for="jsInviteName" class="invite__label">Name</label>
        <input type="text" placeholder="Name" name="name" id="jsInviteName" class="invite__input" required>
        <label for="jsInviteEmail" class="invite__label">Email</label>
        <input type="email" placeholder="Email" name="email" id="jsInviteEmail" class="invite__input" required>
        <input type="hidden" name="action" value="submit_invitation_request">
        <button class="invite__submit" id="jsInviteSubmit">Submit</button>
    </form>

    <div id="jsInviteSuccessMessage" class="invite__success" style="display:none">
        <p class="invite__success-header">Success!</p>
        <p class="invite__success-subheader">You will recieve an email when your account has been created.</p>
    </div>

    <div id="jsInviteErrorMessage" class="invite__success" style="display:none">
        <p class="invite__success-header">Error...</p>
        <p class="invite__success-subheader">This page will refresh, then try again.</p>
    </div>

    <script src="<?php echo ASSET_URL?>/js/invite.js"></script>
</body>
</html>