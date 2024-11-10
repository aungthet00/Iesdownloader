<table class="mt-4 table table-responsive">
<tr>
	<td>IESNAyyyyy:LM-63-2002</td>
</tr>
<tr>
	<td>[TEST]</td>
	<td>ABSOLUTE</td>
</tr>
<tr>
	<td>[TESTLAB]</td>
	<td>ELR</td>
</tr>
<tr>
	<td>[ISSUEDATE]</td>
	<td><?=date('d/m/Y')?></td>
</tr>
<tr>
	<td>[MANUFAC]</td>
	<td>ELR</td>
</tr>
<tr>
	<td>[LUMCAT]</td>
	<td><?= ( ! isset($fixture) ? $lamp['category'] : $fixture['category'])?></td>
</tr>
<?php if (isset($fixture)) : ?>
<tr>
	<td>[LUMINAIRE]</td>
	<?php if (isset($accessories_names)): ?>
	<td><?=$fixture['fixture'] . ' ' . $accessories_names?></td>
	<?php else: ?>
	<td><?=$fixture['fixture']?></td>
	<?php endif ?>
</tr>
<?php endif; ?>
<tr>
	<td>[LAMP]</td>
	<td><?=$lamp['module'] . ' ' . $cct['cct'] . ' ' . $cri['cri']?></td>
</tr>
<tr>
	<td>TILT=KUDOSss</td>
</tr>
<tr>
	<td>1</td><!-- lamps default value is 1 -->
	<td><?=( ($lamp['lumens_HP']>0) ? $lamp['lumens_HP'] : $lamp['lumens'] )?></td>
	<td>1</td><!-- multiplier default value is 1 -->
	<td><?= $vertical_angles ?></td>
	<td><?= $horizontal_angles ?></td>
	<td>1</td>
	<td>2</td>
	<td><?=( ! isset($fixture) ? $lamp['width'] : $fixture['width'])?></td>
	<td><?=( ! isset($fixture) ? $lamp['length'] : $fixture['length'])?></td>
	<td><?=( ! isset($fixture) ? $lamp['height'] : $fixture['height'])?></td>
</tr>
<tr>
	<td>1</td>
	<td>1</td>
	<td><?=$lamp['power']?></td>
</tr>
<tr>
<?php foreach($y_values as $y_value) : ?>
	<td><?= $y_value ?></td>
<?php endforeach; ?>
</tr>
<tr>
<?php foreach($x_values as $x_value) : ?>
	<td><?= $x_value ?></td>
<?php endforeach; ?>
</tr>
<?php for($i = 0; $i < sizeof($result); $i++) : ?>
<tr>
<?php foreach ($result[$i] as $res): ?>
	<td><?= $res ?></td>
<?php endforeach ?>
</tr>
<?php endfor; ?>

</table>
<p id="file-name" style="display: none;"><?= $file_name ?></p>

<a href="#" class="btn btn-block btn-success" id="download">Download</a>
<script src="<?=assets('js/generate.js')?>"></script>
