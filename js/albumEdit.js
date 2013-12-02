$( document ).ready(function() {
$( 'a#delete_album').on('click', function(event){
                var id;
                id = $(this).attr('target'); 
                $('#confirm_delete_album').dialog('option','title', 'Удаление новости '+$(this).attr('title'));
                $('#confirm_delete_album').data('id',id).dialog('open');
                $( 'input#yes_confirm_delete_album').attr('name',id); 
                return false; 
        });  
        $( 'input#yes_confirm_delete_album').on('click', function(event){
            $('#confirm_delete_album').dialog('close');
            $.ajax({
                       type: 'POST',
                       url: 'http://potolokportal.ru/albums/delete',
                       data: 'id='+$(this).attr('name'),
                       success: function(msg){
                         json = jQuery.parseJSON(msg);
                         alert('Альбом '+json.name+' был удален');                   
                         window.location = 'http://potolokportal.ru/companies/albums/'+json.companyUrlID;
                       }
                     }); 
            });
        $( 'input#no_confirm_delete_album').on('click', function(event){
            $('#confirm_delete_album').dialog('close');
            });
});