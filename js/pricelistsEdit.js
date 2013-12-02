$( document ).ready(function() {
$( 'a#delete_pricelist').on('click', function(event){
                var id;
                id = $(this).attr('target'); 
                $('#confirm_delete_pricelist').dialog('option','title', 'Удаление документа '+$(this).attr('title'));
                $('#confirm_delete_pricelist').data('id',id).dialog('open');
                $( 'input#yes_confirm_delete_pricelist').attr('name',id); 
                return false;
        });  
        $( 'input#yes_confirm_delete_pricelist').on('click', function(event){
            $('#confirm_delete_pricelist').dialog('close');
            $.ajax({
                       type: 'POST',
                       url: 'http://potolokportal.ru/pricelists/delete',
                       data: 'id='+$(this).attr('name'),
                       success: function(msg){
                         json = jQuery.parseJSON(msg);
                         alert('Документ '+json.name+' был удален');                   
                         window.location = 'http://potolokportal.ru/companies/pricelists/'+json.companyUrlID;
                       }
                     }); 
            });
        $( 'input#no_confirm_delete_pricelist').on('click', function(event){
            $('#confirm_delete_news').dialog('close');
            });
});