<script type="text/javascript" src="<?php echo base_url('assets/js/main_content.js'); ?>"></script>
<br />
<legend>Currency Converter</legend>
<br />

<div id="error_messages" style="color: red;"></div>

<div style="margin-left:30%;margin-top:20px;" >

    <div class="form-group">
        <label for="source_val">From</label>
        <input type="text" id="source_val" class="form-control" />
        <?php $this->view('currency_select', Array('name' => 'source_currency')); ?>
        <br />
        <label for="target_val">To</label>
        <input type="text" id="target_val" class="form-control" />
        <?php $this->view('currency_select', Array('name' => 'target_currency')); ?>
    </div>
    <input type="submit" name="name" class="btn btn-primary" value="Convert" onclick="convert()"/>
    <input type="button" name="clear" class="btn btn-default" value="Clear" onclick="clear_inputs()" />
</div>



<div id="stored_currencies" class="currency_container">
    <table id="currency_table" class="table table-striped">
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