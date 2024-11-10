<div class="row">
	<div class="col-md-8 m-auto">
		<form id="generate_form" action="<?=site_url('dashboard/generate')?>" method="post" class="mt-4">
			<div class="row">
				<div class="col-md-12 form-group">
					<div class="red-text">Select category of LED Module according to power / lumen output range</div>
					<select name="lamp_categories" id="lamp_categories" class="custom-select" required>
						<option value="">-- LED Module Categories --</option>
						<?php foreach($lamp_categories as $category ) : ?>
							<option value="<?= $category['lamp_cat'] ?>"><?= $category['lamp_cat'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="red-text">Select model of LED Module</div>
						<select name="lamp" id="lamp" disabled class="custom-select" required>
							<option value="">-- LED Module --</option>
						</select>
					</div>
					<div class="form-group">
						<div class="red-text">Select Colour Temperature of LED Module</div>
						<select name="cct" id="cct" disabled class="custom-select">
							<option value="">-- CCT --</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="red-text">Select Fixture to be paired with LED Module</div>
						<select name="fixture" id="fixture" disabled class="custom-select">
							<option value="">-- Fixture --</option>
						</select>
					</div>
					<div class="form-group">
						<div class="red-text">Select Colour Rendering Index of LED Module</div>
						<select name="cri" id="cri" disabled class="custom-select">
							<option value="">-- CRI --</option>
						</select>
					</div>
				</div>
				<div class="form-group col-md-12">
					<label for="accessories">Select Accessories</label> <div class="red-text">(Multiple selection is allowed, up to 3 Accessories involving Comfort Pro or up to 2 Accessories not involving Comfort Pro)</div>
					<select name="accessories[]" class="custom-select" id="accessories" disabled multiple>
					</select>
				</div>
			</div>
			<div class="form-goup">
				<button type="submit" class="btn btn-info btn-block" id="submit">
					Confirm Selection
					<span id="spinner" style="display: none;" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
					<span class="sr-only">Loading...</span>
				</button>
			</div>
		</form>
		<a id="download" style="display:none;" class="btn btn-success btn-block mt-4">Download</a>
	</div>
</div>

<script src="<?=assets('js/create.js')?>">
</script>

