<select name="<?php echo $name ?>" id="<?php echo $name ?>" class="selectpicker" data-size="10"  data-live-search="true" data-width="fit" data-dropup-auto="false">
<optgroup label="Common">
    <?php
    foreach($common AS $currency) :
    ?>
        <option data-tokens="<?php echo $currencies[$currency]," ", $currency; ?>" data-subtext="<?php echo $currencies[$currency]; ?>" value="<?php echo $currency; ?>"><?php echo $currency; ?></option>
    <?php
    endforeach;
    ?>
</optgroup>
<optgroup label="Others">
    <?php
    foreach($currencies AS $key => $name) :
        if(!in_array($key, $common)) :
    ?>
        <option data-tokens="<?php echo $name," ", $key; ?>" data-subtext="<?php echo $name; ?>" value="<?php echo $key; ?>"><?php echo $key; ?></option>                      
    <?php
        endif;
    endforeach;
    ?>
</optgroup>
</select>