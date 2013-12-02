$( document ).ready(function() {
$( 'a#delete_consultant').on('click', function(event){
                var id;
                id = $(this).attr('target'); 
                $('#confirm_delete_consultant').dialog('option','title', 'Управление консультантом '+$(this).attr('title'));
                $('#confirm_delete_consultant').data('id',id,'action','11').dialog('open'); 
                $( 'input#yes_confirm_delete_consultant').attr('name',id); 
                
                
                return false; 
        });  
        $( 'input#yes_confirm_delete_consultant').on('click', function(event){
            $('#confirm_delete_consultant').dialog('close');
            $.ajax({
                       type: 'POST',
                       url: 'http://potolokportal.ru/consultants/delete',
                       data: 'id='+$(this).attr('name'),
                       success: function(msg){
                         json = jQuery.parseJSON(msg);
                         alert('Консультант '+json.name+' был удален');                   
                         window.location = 'http://potolokportal.ru/companies/consultants/'+json.urlID;
                       }
                     }); 
            });
        $( 'input#no_confirm_delete_consultant').on('click', function(event){
            $('#confirm_delete_consultant').dialog('close');
            });
            
$( 'a#block_consultant').on('click', function(event){
                var id;
                id = $(this).attr('target'); 
                $('#confirm_block_consultant').dialog('option','title', 'Управление консультантом '+$(this).attr('title'));
                $('#confirm_block_consultant').data('id',id).dialog('open'); 
                $( 'input#yes_confirm_block_consultant').attr('name',id); 
                return false; 
        });  
        $( 'input#yes_confirm_block_consultant').on('click', function(event){
            $('#confirm_block_consultant').dialog('close');
            $.ajax({
                       type: 'POST',
                       url: 'http://potolokportal.ru/consultants/block',
                       data: 'id='+$(this).attr('name'),
                       success: function(msg){
                         json = jQuery.parseJSON(msg);
                         if (json.block == 0)   
                            {
                                block_action_last = 'заблокирован';
                                block_action_future = 'Заблокировать';
                            }  
                         else
                            {
                                block_action_last = 'разблокирован';
                                block_action_future = 'Разблокировать';
                            }
                         alert('Консультант '+json.name+' был '+block_action_last);         
                         $('div#'+json.consultantUrlID).find('a#block_consultant').text(block_action_future);           
                       //  window.location = 'http://potolokportal.ru/companies/consultants/'+json.urlID;
                       }
                     }); 
            });
        $( 'input#no_confirm_block_consultant').on('click', function(event){
            $('#confirm_block_consultant').dialog('close');
            });
});