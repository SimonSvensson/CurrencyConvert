var sourceRate = 1;
var targetRate = 1;
    
$(document).ready(function(){
   loading();
   update_selectboxes();
   update_table();
});
    
function update_selectboxes(){
    
    loading();
    
    $.getJSON('/index.php/ajax/selectboxes', function(data){
       if(data.error === undefined){

           var common = JSON.parse(data.common);
           var currencies = JSON.parse(data.currencies);

           //remove all the options
           $('.selectpicker').find('option').remove();


           // add the common currencies
           for(var i  = 0; i < common.length ; i++){
               if(currencies[common[i]] !== undefined){
                   $('.opt_common').append( '<option data-tokens="'+currencies[common[i]]+' '+common[i]+'" data-subtext="'+currencies[common[i]]+'" value="'+common[i]+'">'+common[i]+'</option>' );
               }
           }

           // add the rest of the currencies
           $.each(currencies, function(iso, name){
               if($.inArray(iso, common) < 0){
                   $('.opt_others').append('<option data-tokens="'+name+' '+iso+'" data-subtext="'+name+'" value="'+iso+'">'+iso+'</option>');
               }
           });

           $('.selectpicker').selectpicker('refresh');
       }else{
           $('#error_messages').append('<p>'+data+'</p>');
            console.log(data);
       }
       finished_loading();
    });

}
    
function update_table(){
    loading();
    $.getJSON('/index.php/ajax/all_currencies', function(data){
        $('#currency_table tbody tr').remove();
        for(var i = 0; i < data.length; i++){
            $('#currency_table tbody').append(
                    '<tr>'+
                        '<td>'+data[i].iso_4217+'</td>'+
                        '<td>'+data[i].name+'</td>'+
                        '<td>'+data[i].date_created+'</td>'+
                        '<td>'+data[i].date_modified+'</td>'+
                        '<td>'+data[i].rate+'</td>'+
                        '<td><a href="#" onclick="clear_currency(\''+data[i].iso_4217+'\');">Delete</a></td>'+
                    '</tr>');
        }
        finished_loading();
    });
    
}
    
function convert(){
    loading();
    $.getJSON('/index.php/ajax/conversion_factor/'+$('#source_currency').val()+'/'+$('#target_currency').val(),
        function(data){
            
            $('#target_val').val(
                    isNaN(parseFloat($('#source_val').val().replace(',','.')))
                        ? 0
                        : parseFloat(parseFloat($('#source_val').val().replace(',','.')) * parseFloat(data.factor)).toFixed(2) );
    });
    
    finished_loading();
}
    
function clear_inputs(){
    $('#source_val').val('');
    $('#target_val').val('');
}

function clear_currency(iso){
    loading();
    
    $.getJSON('/index.php/ajax/clear_currency/'+iso, function(data){
        if(data.error === undefined){
            update_selectboxes();
            update_table();
        }else{
            
        }
        finished_loading();
    });
}

function update_currencies(){
    loading();
    
    $.getJSON('/index.php/ajax/update_currencies', function(data){
        if(data.error === undefined){
            update_selectboxes();
            update_table();
        }else{
            $('#error_messages').append('<p>'+data.error+'</p>');
            console.log(data.error);
        }
        finished_loading();
    });
}

function clear_all_currencies(){
    
    loading();
    
    $.getJSON('/index.php/ajax/wipe_currencies', function(data){
        if(data.error === undefined){
            
            
            $('.selectpicker').find('option').remove();
            $('.selectpicker').selectpicker('refresh');
            $('#currency_table tbody tr').remove();
            
        }else{
            $('#error_messages').append('<p>'+data.error+'</p>');
            console.log(data.error);
        }
        finished_loading();
    });
}

function loading(){
    $('#spinner').html('<img src="/assets/img/loading_spinner.gif" style="height: 50px; width: 50px;">');
}

function finished_loading(){
    $('#spinner').html('');
}

