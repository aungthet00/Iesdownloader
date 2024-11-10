<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<title><?=(isset($page_title)) ? $page_title : 'ELR'?></title>
	<link rel="stylesheet" href="<?=assets('bootstrap-4.4.1/bootstrap.min.css')?>" />

	<?php if (isset($css_files)): ?>
	<?php 
	foreach($css_files as $file): ?>
		<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<?php endforeach; ?>
	<?php endif ?>
	<script src="<?= assets('jquery-3.4.1/jquery.min.js') ?>"></script>
	<script src="<?= assets('popper-1.16.0/popper.min.js') ?>"></script>
	<script src="<?= assets('bootstrap-4.4.1/bootstrap.min.js') ?>"></script>
	<script src="<?= assets('table-freeze.js') ?>"></script>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script>
		const siteurl = '<?= site_url() ?>';
		const baseurl = '<?= base_url() ?>';
	</script>

</head>
<body>
<?php if (is_logged_in()): ?>
	<nav class="navbar navbar-expand-md navbar-light bg-warning">
		<a class="navbar-brand" href="<?=site_url()?>">ELR IES GENERATOR</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			<div class="navbar-nav mr-auto">
				<a class="nav-item nav-link <?=activate_menu('elr/groups')?>" href="<?=site_url('elr/groups')?>">Groups</a>
				<a class="nav-item nav-link <?=activate_menu('elr/lamps')?>" href="<?=site_url('elr/lamps')?>">Lamps</a>
				<a class="nav-item nav-link <?=activate_menu('elr/fixtures')?>" href="<?=site_url('elr/fixtures')?>">Fixtures</a>
				<a class="nav-item nav-link <?=activate_menu('elr/accessories')?>" href="<?=site_url('elr/accessories')?>">Accessories</a>
				<a class="nav-item nav-link <?=activate_menu('elr/ccts')?>" href="<?=site_url('elr/ccts')?>">CCTs</a>
				<a class="nav-item nav-link <?=activate_menu('elr/cris')?>" href="<?=site_url('elr/cris')?>">CRIs</a>
				<a class="nav-item nav-link <?=activate_menu('elr/angles')?>" href="<?=site_url('elr/angles')?>">Angles</a>
				<a class="nav-item nav-link <?=activate_menu('elr/angles')?>" href="<?=site_url('elr/angles_new')?>">Angles UI</a>
				<!-- <a class="nav-item nav-link <?=activate_menu('elr/compatibility')?>" href="<?=site_url('elr/compatibility')?>">Compatibility</a> -->
				<a class="nav-item nav-link <?=activate_menu('elr/compatibility_ui')?>" href="<?=site_url('elr/compatibility_ui')?>">Compatibility UI</a>
			</div>
			<div class="navbar-nav">
				<span class="nav-item nav-link">Hello, <?= $this->session->userdata('currentuser')?></span>
				<a style="display: <?= (is_admin()) ? '' : 'none'?>" class="nav-item nav-link <?=activate_menu('elr/users')?>" href="<?=site_url('elr/users')?>">Users</a>
				<a class="nav-item nav-link" href="<?=site_url('users/logout')?>">Logout</a>
			</div>
		</div>
	</nav>
<?php endif ?>
	<div class="container-fluid">
		<?php foreach ($this->session->flashdata() as $message) : ?>
		<div class="alert alert-success" role="alert">
			<?php echo $message; ?>
		</div>	
		<?php endforeach; ?>
