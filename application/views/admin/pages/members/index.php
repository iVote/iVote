<h1> Members Maintenance </h1>

<div>

	<form class="form-search" action="<?php echo base_url() ?>members/search">
	  <div class="input-append">
	    <input type="text" class="span2 search-query" name="search" placeholder="Search something . . ." />
	    <button type="submit" class="btn">Search</button>
	  </div>
	</form>

</div>

<div>

	<?php echo anchor('/members/add', '<i class="icon-plus-sign"></i> Add new member', array("class" => "btn btn-small")); ?>

</div>


<div>
	<table class="table table-condensed table-hover table-striped">

		<thead>
			<tr>
				<th> Name </th>
				<th> Short Description </th>
				<th> Groups </th>
				<th colspan="2">Options</th>
			</tr>
		</thead>

		<tbody>

		<?php foreach ($members as $key => $value) : ?>
			<tr>
				<td> <?php echo $value->getName(); ?> </td> 
				<td> <?php echo $value->getShortDescription(); ?> </td>
				<td> 
				<?php 

				foreach ($value->getGroups() as $key => $group) {
					echo $group->getName() . " ";
				}

				?>
				</td>
				<td> </td>
				<td> <?php echo anchor('members/edit/' . $value->getId(), 'Edit');?> </td>
				<td> <?php echo anchor('members/remove/' . $value->getId(), 'Remove');?> </td>
			</tr>
		<?php endforeach; ?>
		</tbody>
		
	</table>

</div>