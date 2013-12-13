<script type="text/javascript">
 
function showModule(){
$("#module").show("slow");
}
 
$(function(){
 $('#close').click(function(){
    $("#module").hide(200); 
 });
 
});
</script>



<li class="lastPhotos__item">
<div class="lastPhotosElement rb-media rb-border-light-bottom">
<!--    <a class="photoImgPreview rb-media-image" target="_blank" href="--><?php //echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?><!--">-->
   



<!-- Spoyler -->

<div id="module" class="spoiler_body spoiler_container">
      <img src="/images/close.png" id="close" />
      <div class="spoiler-content-1">

            <div class="gallery-sliger">
                <a class="gallery-nav-left" href="">
                    <img src="/images/str_oransh_l.png" />
                </a>
                <a class="gallery-nav-right" href="">
                    <img src="/images/str_oransh_r.png" />
                </a>
                <div class="usfot">
                     <img class="image__full" height="580" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $data->image; ?>">
                </div>
            </div>
               
            <div class="sotcial">
                <div class="photoElement__stats stats-left">
                    <div class="userStats">
                        <ul class="rb-ministats-group">
                            <li title="<?php echo Yii::t('app', '{n} комментарий|{n} комментария|{n} комментариев|{n} комментариев', $data->countComments); ?>" class="rb-ministats-item">
                                <a href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?>" class="rb-ministats rb-ministats-small rb-ministats-comments">
                                    <span class="small_comments_i small_i"></span>
                                    <span ><?php echo $data->countComments;  ?> &nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                </a>
                            </li>
                            <li title="<?php echo Yii::t('app', '{n} книга идей|{n} две книги идей|{n} книг идей|{n} книг идей', $data->countIdeasBooks); ?>" class="rb-ministats-item">
                                <span class="rb-ministats rb-ministats-small rb-ministats-ideasbooks">
                                    <span class="small_albums_i small_i"></span>
                                    <span><?php echo $data->countIdeasBooks; ?>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                </span>
                            </li>
                            <li title="<?php echo $data->countLikes; ?>" class="rb-ministats-item">
                                <span class="rb-ministats rb-ministats-small rb-ministats-ideasbooks">
                                    <span class="small_likes_i small_i"></span>
                                    <span><?php echo $data->countLikes; ?></span>
                                </span>
                            </li>
                        </ul>

                    </div> 
                </div>
                <div class="sotssety">
                    Тут соц. сети
                </div>
            </div>

      </div>

      <div class="spoiler-content-2">
        <div class="scroll-content2">
             <div class="awtor">

                   <img id="mainMemberCabinetPic" src="/images/members/avatars/17774408855.jpg" width="45" height="55">
                        <h2 class="photoElement__title">
                             <a class="rb-dark-link" title="Visit timewriter’s profile" href="/mobilepictures/viewinfo/1567" target="_blank">asd</a>
                         </h2>
                         <a href="/member/dashboard/958918230">
                              <h3 class="photoElement__details rb-type-light">lexan24</h3>
                         </a>
             </div>
             <div class="info-foto">
                   <div class="foto-nazwa">
                         <h3>Картинка 1</h3>
                   </div>
                   <div class="foto-opys">
                         <p>Это супер - пупер крвсивое фото и его не очень длинное описание</p>
                   </div>
                   <div class="foto-tegi">
                        <span><strong>Теги:</strong></span>дом, сад, квартира, дизайн, цветы, фасады, интерьер, экстерьер, мебель корпусная, мебель мягкая, офисные помещения
                   </div>
             </div>
             <div class="foto-kommentariy">
                   <div class="foto-kom-info">
                         <span>23 комментария</span>
                         <a href="#">Показать все</a>
                   </div>
                   <div class="komments-users">
                        <span class="user user_1">
                             <h4>User 101:</h4>
                             <p>Это супер - пупер крвсивое фотоkgndvv lk;ldfnlsj ,fjnlskfn</p>
                        </span>
                        <span class="user user_2">
                             <h4>User 102:</h4>
                             <p>fkdnlv fkjvbdlkfv  kfjvkv slkjfls очень длинное описание</p>
                        </span>
                        <span class="user user_3">
                             <h4>User 103:</h4>
                             <p>tgkmnbl lodhvb ljp ndpfvndpf lkfnpfpvk lkfkf vlkfgmp; nldifjppeoi lfkgengkneg lefkgnelkgnkb flgnlegknmelrnfk lkbgfbm kgbngknlef ldfknlfdkbm lvkglkn lfkgvndlkfn </p>
                        </span>
                        <span class="user user_1">
                             <h4>User 101:</h4>
                             <p>Это супер - пупер крвсивое фотоkgndvv lk;ldfnlsj ,fjnlskfn</p>
                        </span>
                        <span class="user user_2">
                             <h4>User 102:</h4>
                             <p>fkdnlv fkjvbdlkfv  kfjvkv slkjfls очень длинное описание</p>
                        </span>
                        <span class="user user_3">
                             <h4>User 103:</h4>
                             <p>tgkmnbl lodhvb ljp ndpfvndpf lkfnpfpvk lkfkf vlkfgmp; nldifjppeoi lfkgengkneg lefkgnelkgnkb flgnlegknmelrnfk lkbgfbm kgbngknlef ldfknlfdkbm lvkglkn lfkgvndlkfn </p>
                        </span>
                        <span class="user user_1">
                             <h4>User 101:</h4>
                             <p>Это супер - пупер крвсивое фотоkgndvv lk;ldfnlsj ,fjnlskfn</p>
                        </span>
                        <span class="user user_2">
                             <h4>User 102:</h4>
                             <p>fkdnlv fkjvbdlkfv  kfjvkv slkjfls очень длинное описание</p>
                        </span>
                        <span class="user user_3">
                             <h4>User 103:</h4>
                             <p>tgkmnbl lodhvb ljp ndpfvndpf lkfnpfpvk lkfkf vlkfgmp; nldifjppeoi lfkgengkneg lefkgnelkgnkb flgnlegknmelrnfk lkbgfbm kgbngknlef ldfknlfdkbm lvkglkn lfkgvndlkfn </p>
                        </span>
                   </div>
                   <div class="napisat-komment">
                        <table class="table-comment">
                             <tr>
                                  <td>
                                       <form id="usercomment"action="fotocomment.php" method="POST" name="commentform">
                                            <span>Напишите ваш комментарий к фото</span><br />
                                            <textarea name="usercomment" cols="40" rows="5">
                                            </textarea><br />
                                            <input type="submit" name="button" value="Опубликовать" class="opublik">
                                       </form>
                                  </td>
                             </tr>
                        </table>
                   </div>
             </div>

         </div>
             
      </div>
</div>

<!-- Spoyler end -->




    <a class="photoImgPreview rb-media-image" onClick="showModule();" href="#" data-lightbox="last-photos" title="<?php echo $data->name; ?>">
<!--        <div class="image  left"  style="height: 120px; width: 120px;">-->
            <img class="image__full"  width="120" height="120" src="<?php echo Yii::app()->baseUrl; ?>/images/mobile/images/<?php echo $data->image; ?>">
<!--        </div>-->
    </a>


        <div class="rb-media-content">
                <h2 class="photoElement__title">
                    <a  href="#<?php //echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?>" class="rb-dark-link" title="Visit timewriter’s profile"><?php echo $data->name; ?></a>
                </h2>
                <a href="<?php echo Yii::app()->createUrl('member/dashboard',array('id'=>$data->memberUrlID)); ?>"><h3 class="photoElement__details rb-type-light"><?php echo $data->memberLogin; ?></h3></a>
                <div class="photoElement__stats">
                    <div class="userStats">
                        <ul class="rb-ministats-group">
                            <li title="<?php echo Yii::t('app', '{n} комментарий|{n} комментария|{n} комментариев|{n} комментариев', $data->countComments); ?>" class="rb-ministats-item">
                                <a href="<?php echo Yii::app()->createUrl('mobilepictures/viewinfo',array('id'=>$data->id)); ?>" class="rb-ministats rb-ministats-small rb-ministats-comments">
                                    <span class="small_comments_i small_i"></span>
                                    <span ><?php echo $data->countComments;  ?> &nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                      </a>
                            </li>
                            <li title="<?php echo Yii::t('app', '{n} книга идей|{n} две книги идей|{n} книг идей|{n} книг идей', $data->countIdeasBooks); ?>" class="rb-ministats-item">
                                <span class="rb-ministats rb-ministats-small rb-ministats-ideasbooks">
                                    <span class="small_albums_i small_i"></span>
                                    <span><?php echo $data->countIdeasBooks; ?>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                </span>
                            </li>
                            <li title="<?php echo $data->countLikes; ?>" class="rb-ministats-item">
                                <span class="rb-ministats rb-ministats-small rb-ministats-ideasbooks">
                                    <span class="small_likes_i small_i"></span>
                                    <span><?php echo $data->countLikes; ?></span>
                                </span>
                            </li>
                        </ul>

                </div> </div>
        </div>

</div>


</li>







