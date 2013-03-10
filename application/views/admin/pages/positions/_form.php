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
	
	<?php echo "<br />"; ?>

	<div class="control-group">

		<div class="controls">
		
			<?php echo form_submit(array("name" => "submit", "class" => "btn btn-primary"), 'Save'); ?>
		
		</div>

	</div>

	<?php echo form_close();?>

</div>	