<div class="navbar navbar-fixed-top navbar-inverse ">
  <div class="navbar-inner">
  	<div class="container">
	    <a class="brand" href="#">Administrator</a>
	    <ul class="nav">
	      <li><a href="<?php echo base_url(); ?>">Dashboard</a></li>
	      <li><?php echo anchor('groups', 'Groups'); ?></li>
	      <li><?php echo anchor('positions', 'Positions'); ?></li>
	      <li><?php echo anchor('members', 'Members'); ?></li>
	      <li class="dropdown">
	      	<a class="dropdown-toggle" data-toggle="dropdown" href="#">
	      		People
	      		<b class="caret"></b>
	      	</a>
	      	<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
	      		<li><a href="#">Manage Voters</a></li>
	      		<li><a href="#">Manage Positions</a></li>
	      		<li><a href="#">Manage Voters Group</a></li>
	      		<li role="presentation" class="divider"></li>
	      		<li><a href="#">Settings</a></li>
	      		<li><a href="#"></a></li>
	      	</ul>
	      </li>
	      <li class="dropdown">
	      	<a class="dropdown-toggle" data-toggle="dropdown" href="#">
	      		Settings
	      		<b class="caret"></b>
	      	</a>
	      	<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
	      		<li><a href="#">General Configuration</a></li>
	      		<li><a href="#">Election Settings</a></li>
	      		<li><a href="#">User Management</a></li>
	      	</ul>
	      </li>
	    </ul>
  	</div>
  </div>
</div>