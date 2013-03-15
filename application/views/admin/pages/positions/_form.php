<div>


	<?php echo form_open('positions/submit', array("class" => "form-horizontal")); ?>

	<?php echo isset($edit) ? form_hidden('id', $position->getId()) : "" ; ?>

	<div class="control-group">

	<?php echo form_label('Title:', 'title', array("class" => "control-label")); ?>

		<div class="controls">

			<?php echo form_input('title', isset($edit) ? $position->getTitle() : ""); ?>

		</div> 

	</div>

	<div class="control-group">
	
	<?php echo form_label('Limitation:', 'limitation', array("class" => "control-label")) ?>

		<div class="controls">

			<?php echo form_input('limitation', isset($edit) ? $position->getLimitation() : "", array("class" => "controls")); ?>

		</div>
	
	</div>

	<div class="control-group">

	<?php echo form_label('Group dependencies:', 'groups', array("class" => "control-label")) ?>

	<?php foreach ($groups as $key => $value) : ?>

		<div class="controls">

			<label class="checkbox">
				<?php if (isset($edit)) {
					$checked = FALSE;
					
					if (! is_null($active_groups)) {
						$checked = in_array($value->getId(), $active_groups);
					}
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