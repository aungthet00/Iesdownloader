<?php if (validation_errors()) : ?>
<div class="alert alert-danger" role="alert">
<?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<form action="<?=site_url('users/register');?>" method="post" class="mt-4">
	<div class="form-group">
		<input 
			class="form-control" 
			name="fname" 
			type="fname"
			value="<?=set_value('fname')?>"
			placeholder="Enter first name"/>
	</div>
	<div class="form-group">
		<input 
			class="form-control" 
			name="lname" 
			type="lname"
			value="<?=set_value('lname')?>"
			placeholder="Enter last name"/>
	</div>
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
			class="form-control"
			name="cpassword"
			type="password"
			placeholder="Confirm password" />
	</div>
	<div class="form-group">
		<input
			class="form-control btn btn-primary"
			name="submit"
			type="submit"
			/>
		<a href="<?=site_url('users/login')?>" class="form-control btn btn-warning">Login</a>
	</div>

</form>
