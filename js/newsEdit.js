$( document ).ready(function() {
$( 'a#delete_news').on('click', function(event){
                var id;
                id = $(this).attr('target'); 
                $('#confirm_delete_news').dialog('option','title', 'Удаление новости '+$(this).attr('title'));
                $('#confirm_delete_news').data('id',id).dialog('open');
                $( 'input#yes_confirm_delete_news').attr('name',id); 
                return false; 
        });  
        $( 'input#yes_confirm_delete_news').on('click', function(event){
            $('#confirm_delete_news').dialog('close');
            $.ajax({
                       type: 'POST',
                       url: 'http://potolokportal.ru/news/delete',
                       data: 'id='+$(this).attr('name'),
                       success: function(msg){
                         json = jQuery.parseJSON(msg);
                         alert('Новость '+json.name+' была удалена');                   
                         window.location = 'http://potolokportal.ru/companies/news/'+json.companyUrlID;
                       }
                     }); 
            });
        $( 'input#no_confirm_delete_news').on('click', function(event){
            $('#confirm_delete_news').dialog('close');
            });
});