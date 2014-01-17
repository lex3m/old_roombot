<style>
    .facebook-login-button {
        height: 32px;
        background: url(/images/socbuttons.png) no-repeat;
        width: 104px;
        cursor: pointer;

        display: inline-block;
        background-position: -113px 0;
        margin-left: 8px;
    }
    .facebook-login-button:hover {
        background-position: -113px -49px;
    }
</style>
<a href="<?php echo $url . '?'. urldecode(http_build_query($buttonParams)); ?>">
    <div class="facebook-login-button"></div>
</a>


