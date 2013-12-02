$( document ).ready(function() {
$( 'a#delete_vacancy').on('click', function(event){
                var id;
                id = $(this).attr('target'); 
                $('#confirm_delete_vacancy').dialog('option','title', 'Удаление вакансии '+$(this).attr('title'));
                $('#confirm_delete_vacancy').data('id',id).dialog('open');
                $( 'input#yes_confirm_delete_vacancy').attr('name',id); 
                return false; 
        });  
        $( 'input#yes_confirm_delete_vacancy').on('click', function(event){
            $('#confirm_delete_vacancy').dialog('close');
            $.ajax({
                       type: 'POST',
                       url: 'http://potolokportal.ru/vacancies/delete',
                       data: 'id='+$(this).attr('name'),
                       success: function(msg){
                         json = jQuery.parseJSON(msg);
                         alert('Вакансия '+json.name+' была удалена');                   
                         window.location = 'http://potolokportal.ru/companies/vacancies/'+json.companyUrlID;
                       }
                     }); 
            });
        $( 'input#no_confirm_delete_vacancy').on('click', function(event){
            $('#confirm_delete_vacancy').dialog('close');
            });
});