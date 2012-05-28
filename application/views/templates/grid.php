<?php 
foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
 
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<?php 
	if (isset($preGrid))
		echo $preGrid
?>

<?php echo $output; ?>

<?php 
	if (isset($postGrid))
		echo $postGrid
?>	




