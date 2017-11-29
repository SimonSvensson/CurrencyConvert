<script type="text/javascript">
    var sourceRate = 1;
    var targetRate = 1;
    
    $(document).ready(function(){
       update_table(); 
    });
    
    function update_table(){
        $.getJSON('index.php/ajax/all_currencies', function(data){
            $('#currency_table tbody tr').remove();
            for(var i = 0; i < data.length; i++){
                $('#currency_table tbody').append(
                        '<tr>'+
                            '<td>'+data[i].iso_4217+'</td>'+
                            '<td>'+data[i].name+'</td>'+
                            '<td>'+data[i].date_created+'</td>'+
                            '<td>'+data[i].date_modified+'</td>'+
                            '<td>'+data[i].rate+'</td>'+
                        '</tr>');
            }
        });
    }
    
    function convert(){
        $.getJSON('index.php/ajax/conversion_factor/'+$('#source_currency').val()+'/'+$('#target_currency').val(),
            function(data){
                console.log(data);
                $('#target_val').val( parseFloat($('#source_val').val()) * parseFloat(data) );
        });
    }
</script>
<br />
<legend>Currency Converter</legend>
<br />
<?php echo form_open('','class="form-inline"'); ?>


<div style="margin-left:30%;margin-top:20px;" >

    <div class="form-group">
        <label for="source_val">From</label>
        <input type="text" id="source_val" name="source_val" class="form-control" />
        <?php $this->view('currency_select', Array($common, $currencies, 'name' => 'source_currency')); ?>
        <br />
        <label for="target_val">To</label>
        <input type="text" id="target_val" name="target_val" class="form-control" />
        <?php $this->view('currency_select', Array($common, $currencies, 'name' => 'target_currency')); ?>
    </div>
    <input type="submit" name="name" class="btn btn-primary" value="Convert"/>

</div>

<?php echo form_close(); ?>

<div id="stored_currencies" class="currency_container">
    <table id="currency_table">
        <thead>
            <tr>
                <td>ISO_4217</td>
                <td>Name</td>
                <td>Date created</td>
                <td>Date modified</td>
                <td>Rate</td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>