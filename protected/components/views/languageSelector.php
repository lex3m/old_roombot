<div id="language-select" style="padding-top: 10px;">
    <?php
        foreach($languages as $key=>$lang) {
            if($key != $currentLang) {
                echo CHtml::link(
                    '<img src="/images/site/'.$key.'.gif" title="'.$lang.'" style="padding: 1px;" width=16 height=11>',
                    $this->getOwner()->createMultilanguageReturnUrl($key));
            };
        }
    ?>
</div>