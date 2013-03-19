<div>


	<?php echo form_open('members/submit', array("class" => "form-horizontal")); ?>

	<?php echo isset($edit) ? form_hidden('id', $member->getId()) : "" ; ?>

	<div class="control-group">

	<?php echo form_label('Name:', 'name', array("class" => "control-label")); ?>

		<div class="controls">

			<?php echo form_input('name', isset($edit) ? $member->getName() : ""); ?>

		</div> 

	</div>

	<div class="control-group">
	
	<?php echo form_label('Short Description:', 'shortDescription', array("class" => "control-label")) ?>

		<div class="controls">

			<?php echo form_textarea('shortDescription', isset($edit) ? $member->getShortDescription() : "", array("class" => "controls")); ?>

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
				<?php echo form_checkbox("groups[]", $value->getId(), isset($edit) ? $checked : FALSE); ?>
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