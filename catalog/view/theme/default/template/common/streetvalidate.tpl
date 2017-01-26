<div id="streevalidate" class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title"><?php echo $heading_title; ?></h4>
    </div>
    <div class="modal-body">
    	<div class="row">
		  <?php foreach ($addresses as $add =>$address) { ?>
		  <div class="col-sm-10">
		  	<?php if ($add == 0) { ?>
		  		<input type="radio" class="radioBtnClass" name="address" value="0,<?php echo $address['AddressLine']; ?>,<?php echo $address['Appt']; ?>,<?php echo $address['Region']; ?>,<?php echo $address['Zip']; ?>,<?php echo $address['City']; ?>,<?php echo $address['State']; ?>,<?php echo $address['County']; ?>" /><b><?php echo $address['AddressLine']; ?> &nbsp; <?php echo $address['Appt']; ?> &nbsp; <?php echo $address['Region']; ?> {one you entered }</b> <!--&nbsp; <?php echo $address['County']; ?>&nbsp; <?php echo $address['State']; ?>&nbsp; <?php echo $address['Zip']; ?> -->
		  	<?php } else { ?>
		  		<input type="radio" class="radioBtnClass" name="address" value="1,<?php echo $address['AddressLine']; ?>,<?php echo $address['Appt']; ?>,<?php echo $address['Region']; ?>,<?php echo $address['Zip']; ?>,<?php echo $address['City']; ?>,<?php echo $address['State']; ?>,<?php echo $address['County']; ?>" /><?php echo $address['AddressLine']; ?> &nbsp; <?php echo $address['Appt']; ?> &nbsp; <?php echo $address['Region']; ?> <!--&nbsp; <?php echo $address['County']; ?>&nbsp; <?php echo $address['State']; ?>&nbsp; <?php echo $address['Zip']; ?> -->
		  	<?php } ?>
		  </div>
		  <?php } ?>
		 </div>
    </div>
    
    <div class="modal-footer"></div>
  </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function(){

      $("input[name='address']").on("click", function() {
            var a = $(this).val();
            var aArray = a.split(",");
            if(aArray[0] == 1){
            	$('#<?php echo $target; ?>').val($(this).val());
            	$('#<?php echo $target; ?>').trigger('change');
            }
            $('#modal-image').modal('hide');
        });
});

//--></script>