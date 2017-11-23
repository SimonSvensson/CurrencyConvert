<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/bootstrap-select.css'); ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.2.1.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-select.min.js'); ?>"></script>

<div class="container">

<?php echo form_open('','class="form-inline"'); ?>
</br>
<legend>Currency Converter</legend>
</br>

<div style="margin-left:30%;margin-top:20px;" >

    <div class="form-group">
            <input type="text" name="source" class="form-control" />
            <select class="selectpicker" name="source_currency" data-live-search="true" data-width="fit" data-dropup-auto="false">
                    <optgroup label="Common">
                            <option data-subtext="United States Dollar">USD</option>
                            <option>EUR</option>
                            <option>JPY</option>
                            <option>CHF</option>
                    </optgroup>
                    <optgroup label="Others">
                            <option>PEN</option>
                    </optgroup>
            </select>
            <br />
            <input type="text" name="target" class="form-control" />
            <select class="selectpicker" name="target_currency" data-live-search="true">
                    <optgroup label="Common">
                            <option>EUR</option>
                    </optgroup>
                    <optgroup label="Others">
                            <option>PEN</option>
                    </optgroup>
            </select>
    </div>
    <input type="submit" name="name" class="btn btn-primary" value="Convert"/>

</div>

<?php echo form_close(); ?>
</div>
