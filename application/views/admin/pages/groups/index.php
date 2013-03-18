<h1> Groups Maintenance </h1>

<div>

	<form class="form-search" action="<?php echo base_url() ?>groups/search">
	  <div class="input-append">
	    <input type="text" class="span2 search-query" name="search" placeholder="Search something . . ." />
	    <button type="submit" class="btn">Search</button>
	  </div>
	</form>

</div>

<div>

	<?php echo anchor('/groups/add', '<i class="icon-plus-sign"></i> Add new group', array("class" => "btn btn-small")); ?>

</div>


<div>
	<table class="table table-condensed table-hover table-striped">

		<thead>
			<tr>
				<th> Name </th>
				<th> Short Description </th>
				<th colspan="2"> Options </th>
			</tr>
		</thead>

		<tbody>

		<?php foreach ($groups as $key => $value) : ?>
			<tr>
				<td> <?php echo $value->getName(); ?> </td> 
				<td> <?php echo $value->getShortDescription(); ?> </td>
				<td> <?php echo anchor('groups/edit/' . $value->getId(), 'Edit');?> </td>
				<td> <?php echo anchor('groups/remove/' . $value->getId(), 'Remove');?> </td>
			</tr>
		<?php endforeach; ?>
		</tbody>
		
	</table>

</div>