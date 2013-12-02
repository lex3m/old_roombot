$( document ).ready(function() {
$( 'a#delete_tender').on('click', function(event){
                var id;
                id = $(this).attr('target'); 
                $('#confirm_delete_tenders').dialog('option','title', 'Удаление новости '+$(this).attr('title'));
                $('#confirm_delete_tenders').data('id',id).dialog('open');
                $( 'input#yes_confirm_delete_tender').attr('name',id); 
                return false; 
        });  
        $( 'input#yes_confirm_delete_tender').on('click', function(event){
            $('#confirm_delete_tenders').dialog('close');
            $.ajax({
                       type: 'POST',
                       url: '/tenders/delete',
                       data: { id: $(this).attr('name')},
                       success: function(msg){  
                         json = jQuery.parseJSON(msg);
                         alert('Новость '+json.name+' была удалена');                   
                         window.location = 'http://potolokportal.ru/companies/tenders/'+json.companyUrlID;
                       }
                     }); 
            });
        $( 'input#no_confirm_delete_tender').on('click', function(event){
            $('#confirm_delete_tenders').dialog('close');
            });
});