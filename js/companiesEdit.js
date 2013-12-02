$( document ).ready(function() {
$( 'a#delete_product').on('click', function(event){
                var id;
                id = $(this).attr('target'); 
                $('#confirm_delete_product').dialog('option','title', 'Удаление товара '+$(this).attr('title'));
                $('#confirm_delete_product').data('id',id).dialog('open');
                $( 'input#yes_confirm_delete_product').attr('name',id); 
                return false;
        });  
        $( 'input#yes_confirm_delete_product').on('click', function(event){
            $('#confirm_delete_product').dialog('close');
            $.ajax({
                       type: 'POST',
                       url: 'http://potolokportal.ru/products/delete',
                       data: 'id='+$(this).attr('name'),
                       success: function(msg){
                         json = jQuery.parseJSON(msg);
                         alert('Товар '+json.name+' был удален');                
                         window.location = 'http://potolokportal.ru/companies/products/'+json.companyUrlID;
                       }
                     }); 
            });
        $( 'input#no_confirm_delete_product').on('click', function(event){
            $('#confirm_delete_product').dialog('close');
            });
});