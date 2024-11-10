<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>ELR</title>

	<link rel="stylesheet" href="<?=assets('css/pixel/pixel.css')?>" />
	<link rel="stylesheet" href="<?=assets('css/mystyle.css')?>" />
	<link rel="stylesheet" href="<?=assets('css/select2.min.css') ?>" />
	<script src="<?=assets('js/jquery/jquery.min.js')?>"></script>
	<script src="<?=assets('js/jquery/select2.min.js') ?>"></script>
	<script>
		baseurl = '<?=base_url('/')?>';
		siteurl = '<?=site_url('/')?>';
		csrfname = '<?=$this->security->get_csrf_token_name()?>';
		csrfhash = '<?=$this->security->get_csrf_hash()?>';
	</script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 m-auto">
				<div class="alert alert-warning" id="message"  style="display:none;" role="alert">
					<strong id="error"></strong> <span id="errormsg"></span>
				</div>
				<?php if ($this->session->flashdata('accessories_error')) : ?>
				<div class="alert alert-warning mt-4" id="flashdata" role="alert">
					<strong>Error</strong>: <span><?= $this->session->flashdata('accessories_error') ?></span>
				</div>
				<?php endif; ?>
			</div>
		</div>
