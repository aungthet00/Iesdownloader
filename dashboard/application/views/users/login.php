<?php if (validation_errors()) : ?>
<div class="alert alert-danger" role="alert">
<?php echo validation_errors(); ?>
</div>
<?php endif; ?>

<div class="container">
	<div class="row" style="margin-top: 100px">
		<div class="col-md-4 offset-md-4 col-12">
			<h1 class="text-center">ELR IES Generator</h1>

			<form action="<?=site_url('users/login');?>" method="post" class="mt-4">
				<div class="form-group">
					<input 
						class="form-control" 
						name="email" 
						type="email"
						value="<?=set_value('email')?>"
						placeholder="Enter email address" />
				</div>
				<div class="form-group">
					<input
						class="form-control"
						name="password"
						type="password"
						placeholder="Enter password" />
				</div>
				<div class="form-group">
					<input
						class="form-control btn btn-warning"
						name="submit"
						type="submit"
						/>
				</div>

			</form>
		</div>
	</div>
</div>