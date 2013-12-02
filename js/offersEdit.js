$( document ).ready(function() {
$( 'a#delete_offer').on('click', function(event){
                var id;
                id = $(this).attr('target'); 
                $('#confirm_delete_offer').dialog('option','title', 'Удаление вакансии '+$(this).attr('title'));
                $('#confirm_delete_offer').data('id',id).dialog('open');
                $( 'input#yes_confirm_delete_offer').attr('name',id); 
                return false; 
        });  
        $( 'input#yes_confirm_delete_offer').on('click', function(event){
            $('#confirm_delete_offer').dialog('close');
            $.ajax({
                       type: 'POST',
                       url: 'http://potolokportal.ru/offers/delete',
                       data: 'id='+$(this).attr('name'),
                       success: function(msg){
                         json = jQuery.parseJSON(msg);
                         alert('Вакансия '+json.name+' была удалена');                   
                         window.location = 'http://potolokportal.ru/companies/offers/'+json.companyUrlID;
                       }
                     }); 
            });
        $( 'input#no_confirm_delete_offer').on('click', function(event){
            $('#confirm_delete_offer').dialog('close');
            });
});