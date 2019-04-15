<?php  

// Output errors: using a foreach loop within the div class entitled error

if (count($errors) > 0) : ?>
	<div class="alert alert-danger">
		<?php foreach ($errors as $error) : ?>
			<p><?php echo $error ?></p>
		<?php endforeach ?>
	</div>
<?php  endif ?>