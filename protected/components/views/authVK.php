<style>
    .auth-vkontakte-button, .facebook-login-button {
        height: 32px;
        background: url(/images/socbuttons.png) no-repeat;
        width: 104px;
        cursor: pointer;
    }
    .auth-vkontakte-button:hover {
        background-position: 0 -49px;
    }
</style>
<a href="<?php echo $url . '?'. urldecode(http_build_query($buttonParams)); ?>">
    <div class="auth-vkontakte-button"></div>
</a>

