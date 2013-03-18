<div>


	<?php echo form_open('groups/submit', array("class" => "form-horizontal")); ?>

	<?php echo isset($edit) ? form_hidden('id', $group->getId()) : "" ; ?>

	<div class="control-group">

	<?php echo form_label('Name:', 'name', array("class" => "control-label")); ?>

		<div class="controls
		">

			<?php echo form_input('name', isset($edit) ? $group->getName() : ""); ?>

		</div> 

	</div>

	<div class="control-group">
	
	<?php echo form_label('Short Description:', 'shortDescription', array("class" => "control-label")) ?>

		<div class="controls">

			<?php echo form_textarea('shortDescription', isset($edit) ? $group->getShortDescription() : "", array("class" => "controls")); ?>

		</div>
	
	</div>
	
	<div class="control-group">

		<div class="controls">
		
			<?php echo form_submit(array("name" => "submit", "class" => "btn btn-primary"), 'Save'); ?>
		
		</div>

	</div>

	<?php echo form_close();?>

</div>	