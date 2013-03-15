<h1> Positions Maintenance </h1>

<div>

	<form class="form-search" action="<?php echo base_url() ?>positions/search">
	  <div class="input-append">
	    <input type="text" class="span2 search-query" name="search" placeholder="Search something . . ." />
	    <button type="submit" class="btn">Search</button>
	  </div>
	</form>

</div>

<div>

	<?php echo anchor('/positions/add', '<i class="icon-plus-sign"></i> Add new position', array("class" => "btn btn-small")); ?>

</div>


<div>
	<table class="table table-condensed table-hover table-striped">

		<thead>
			<tr>
				<th> Titles </th>
				<th> Limitations </th>
				<th>Groups</th>
				<th colspan="2">Options</th>
			</tr>
		</thead>

		<tbody>

		<?php foreach ($positions as $key => $value) : ?>
			<tr>
				<td> <?php echo $value->getTitle(); ?> </td> 
				<td> <?php echo $value->getLimitation(); ?> </td>
				<td> 
				<?php 

				foreach ($value->getGroups() as $key => $group) {
					echo $group->getName() . " ";
				}

				?>
				</td>
				<td> </td>
				<td> <?php echo anchor('positions/edit/' . $value->getId(), 'Edit');?> </td>
				<td> <?php echo anchor('positions/remove/' . $value->getId(), 'Remove');?> </td>
			</tr>
		<?php endforeach; ?>
		</tbody>
		
	</table>

</div>