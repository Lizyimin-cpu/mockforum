<?php
include 'db_connect.php';
session_start();
$qry = $conn->query("SELECT * from system_settings limit 1");
if ($qry->num_rows > 0) {
	foreach ($qry->fetch_array() as $key => $value) {
		$_SESSION['system_' . $key] = $value;
	}
}
?>
<style>
	.collapse a {
		text-indent: 10px;
	}

	nav#sidebar {
		/* background: url('./assets/img/bg.jpg') no-repeat !important; */
		background-size: cover !important;
	}
</style>

<nav id="sidebar" class='mx-lt-5'>

	<div class="sidebar-list">
		<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
		<a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-tags"></i></span> Classification</a>
		<a href="index.php?page=topics" class="nav-item nav-topics"><span class='icon-field'><i class="fa fa-comment"></i></span> Discussion</a>
		<?php if ($_SESSION['login_type'] == 1) : ?>
			<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> User</a>
			<a href="index.php?page=settings" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-globe"></i></span> Settings</a>
		<?php endif; ?>
	</div>

</nav>
<script>
	$('.nav_collapse').click(function() {
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>