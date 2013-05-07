<?php echo validation_errors('<div class="alert alert-error">','</div>'); ?>

<div>

	<?php $id = isset($id) ? $id : ''; ?>
	

	<?php echo form_open($main_content . '/' . $id, array("class" => "form-horizontal")); ?>

	<?php echo !empty($id) ? form_hidden('id', $member->getId()) : "" ; ?>

	<div class="control-group">

	<?php echo form_label('Name:', 'name', array("class" => "control-label")); ?>

		<div class="controls">

			<?php echo form_input('name', isset($edit) ? $member->getName() : set_value('name')); ?>

		</div> 

	</div>

	<div class="control-group">
	
	<?php echo form_label('Short Description:', 'shortDescription', array("class" => "control-label")) ?>

		<div class="controls">

			<?php echo form_textarea('shortDescription', isset($edit) ? $member->getShortDescription() : set_value('shortDescription'), array("class" => "controls")); ?>

		</div>
	
	</div>

	<div class="control-group">

	<?php echo form_label('Group dependencies:', 'groups', array("class" => "control-label")) ?>

	<?php foreach ($groups as $key => $value) : ?>

		<div class="controls">

			<label class="checkbox">
				<?php if (isset($edit)) {

					$checked = !is_null($active_groups) ? in_array($value->getId(), $active_groups) : FALSE;

				} ?>
				<?php echo form_checkbox("groups[]", $value->getId(), isset($edit) ? $checked : set_checkbox('groups', $value->getId())); ?>
				<?php echo $value->getName(); ?>

			</label>

		</div>

	<?php endforeach; ?>
	</div>
	
	<div class="control-group">

		<div class="controls">
		
			<?php echo form_submit(array("name" => "submit", "class" => "btn btn-primary"), 'Save'); ?>
		
		</div>

	</div>

	<?php echo form_close();?>

</div>	