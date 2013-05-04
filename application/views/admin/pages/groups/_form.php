
<?php echo validation_errors('<div class="alert alert-error">','</div>'); ?>


<div>

	<?php $id = isset($id) ? $id : ''; ?>


	<?php echo form_open($main_content . '/' . $id, array("class" => "form-horizontal")); ?>

	<?php echo !empty($id) ? form_hidden('id', $id) : "" ; ?>

	<div class="control-group">

	<?php echo form_label('Name:', 'name', array("class" => "control-label")); ?>

		<div class="controls">

			<?php echo form_input('name', isset($edit) ? $group->getName() : set_value('name')); ?>

		</div> 
		
	</div>

	<div class="control-group">
	
	<?php echo form_label('Short Description:', 'shortDescription', array("class" => "control-label")) ?>

		<div class="controls">

			<?php echo form_textarea('shortDescription', isset($edit) ? $group->getShortDescription() : set_value('shortDescription'), array("class" => "controls")); ?>

		</div>
	
	</div>
	
	<div class="control-group">

		<div class="controls">
		
			<?php echo form_submit(array("name" => "submit", "class" => "btn btn-primary"), 'Save'); ?>
		
		</div>

	</div>

	<?php echo form_close();?>

</div>	