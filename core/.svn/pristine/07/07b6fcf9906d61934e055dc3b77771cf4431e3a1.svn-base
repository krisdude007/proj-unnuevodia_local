var submissionHandler = function(el){
    $('#submitEdit').off('submit');
    $('#submitEdit').on('submit',function(e){
        if(confirm('Are you sure you wish to make this edit?')){
            var data = $(this).serializeArray();
            var csrf = new Object;
            csrf.name = 'CSRF_TOKEN';
            csrf.value = getCsrfToken();
            data.push(csrf);
            var request = $.ajax({
                url:"/adminLanguage/ajaxSave",
                type:'POST',
                data:$.param(data),
                success: function(data){
                    $(el).html(data);
                    $('#submitEdit').parents('td').html(el);                                        
                    editHandler();
                }
            });
        }
        return false;
    });
}
var cancelHandler = function(el){
    $('#cancelEdit').off('click');
    $('#cancelEdit').on('click',function(e){
        $(this).parents('td').html(el);
        editHandler();
    });
}
var editHandler = function(){
    $('.setFilterState').off('click');
    $('.setFilterState').on('click',function(e){
        e.preventDefault();
        var obj = new Object;
        obj.column = 'active';
        obj.value = $(this).attr('rev');
        obj.id = $(this).attr('rel');
        obj.CSRF_TOKEN = getCsrfToken();
        if(confirm('Are you sure you wish to make this edit?')){
            var request = $.ajax({
                url:"/adminLanguage/ajaxSave",
                type:'POST',
                data:$.param(obj),
                success: function(data){
                    window.location.href = window.location.href;
                }
            });
        }        
    });
    $('.edit').off('click');
    $('.edit').on('click',function(e){
        if($('#cancelEdit').length != 0){
            $('#cancelEdit').trigger('click');
        }
        e.preventDefault();
        var formHolder = $('<div></div>').css({'display':'inline-block','width':'100%'});
        var miniform = $('<form></form>').attr({'id':'submitEdit'});
        var inputField = $('<input></input>').val($(this).html()).attr({'id':$(this).attr('rel'),'name':'value'});        
        var hiddenIDField = $('<input></input>').attr({'type':'hidden','name':'id'}).val($(this).attr('rev'));        
        var hiddenColField = $('<input></input>').attr({'type':'hidden','name':'column'}).val($(this).attr('rel'));        
        var submitButton = $('<input></input>').attr({'type':'submit'});
        var cancelButton = $('<button></button>').attr({'id':'cancelEdit'}).html('Cancel');
        miniform.append(inputField).append(hiddenIDField).append(hiddenColField).append(submitButton);
        formHolder.append(miniform).append(cancelButton);        
        var el = $(this).replaceWith(formHolder);
        submissionHandler(el);
        cancelHandler(el);
    });
}
$(document).ready(function(){
 
    $('#languageTable').dataTable({
        "fnDrawCallback":editHandler(),
        "aaSorting": [[ 1, "asc" ]]
    });
    editHandler();
});    
