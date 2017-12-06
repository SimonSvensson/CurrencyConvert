<script type="text/javascript" src="<?php echo base_url('assets/js/main_content.js'); ?>"></script>

<br />
<legend>Currency Converter</legend>
<br />

<div style="margin-left:30%;margin-top:20px; width:70%" class="form-inline" >

    <label for="source_val">From</label><br />
    <input type="text" id="source_val" class="form-control curr_input" />

    <?php $this->view('currency_select', Array('name' => 'source_currency')); ?>
    <br />
    <label for="target_val">To</label><br />
    <input type="text" id="target_val" class="form-control curr_input" disabled="true" />

    <?php $this->view('currency_select', Array('name' => 'target_currency')); ?>
    <br /><br />
    <div>
    <input type="submit" name="convert" id="btn_convert" class="btn btn-primary" value="Convert" />
    <input type="button" name="clear" id="btn_clear" class="btn btn-default" value="Clear inputs" />
    </div>
</div>
<div id="spinner" style="height: 50px; width: 50px;float:center;"></div>
<div id="error_messages" style="color: red;"></div>
<br />

<div id="stored_currencies" class="currency_container">
    <div class="form-inline" style="float:right;">
        <input type="button" id="btn_update" class="btn btn-success" value="Update Rates" />
        <input type="button" id="btn_wipe" class="btn btn-danger" value="Delete All" />
    </div>
    <table id="currency_table" class="table table-striped">
        <thead>
            <tr>
                <th>ISO_4217</th>
                <th>Name</th>
                <th>Date created</th>
                <th>Date modified</th>
                <th>Rate</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>