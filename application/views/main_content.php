
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
            <select name="source_currency" class="selectpicker" data-size="10"  data-live-search="true" data-width="fit" data-dropup-auto="false">
                    <?php $this->view('select_options', Array($common, $currencies)); ?>
            </select>
            <br />
            <input type="text" name="target" class="form-control" />
            <select name="target_currency" class="selectpicker" data-size="10"  data-live-search="true" data-width="fit" data-dropup-auto="false">
                    <?php $this->view('select_options', Array($common, $currencies)); ?>
            </select>
    </div>
    <input type="submit" name="name" class="btn btn-primary" value="Convert"/>

</div>

<?php echo form_close(); ?>
</div>
