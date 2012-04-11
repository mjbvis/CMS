<?php
/**
 * Is Set Not Empty Function
 * Use: Verify if a variable is set and is not empty.
 * @param mixed $var - Reference of a variable to be checked.
 * @return bool - True if the variable is set AND not empty.  False otherwise.
 */
if (!function_exists('isset_not_empty')) {
	function isset_not_empty(&$var) {
		return (isset($var) && !empty($var));
	}

}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="Robots" content="noindex, nofollow, noarchive">
		<meta name="Description" content="Corvallis Montessori School">
		<meta name="Author" content="Corvallis Montessori School">
		<meta name="Rating" content="General">
		<title><?php echo((isset_not_empty($title) ? "$title | CMS" : "CMS"));?></title>
		<link rel="icon" type="image/x-icon" href="<?php echo base_url('favicon.ico');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/styles/screen.css');?>" type="text/css"	media="screen" />
		<link rel="stylesheet" href="<?php echo base_url('assets/styles/forms/screen.css');?>" type="text/css" media="screen" />
	</head>
	<body>
		<div id="header">
			<a href="http://www.corvallismontessori.org/"><img src="<?php echo base_url('assets/images/cms_logo.png');?>" alt="CMS Logo" width="585" height="67"></a>
		</div>
		<div id="main">
			<nav id="topNav">
				<ul>
					<?php foreach($MenuItems as $mItem):
						$mItemAttr = $mItem->attributes();
					?>
					<li>
						<a href='<?php echo $mItemAttr['url'];?>'><?php echo $mItemAttr['label']; ?></a>
						<ul>
							<?php foreach($mItem->sub_items as $sItem):
								$sItemAttr = $sItem->attributes();
							?>
							<li>
								<?php echo anchor($sItemAttr['url'], $sItemAttr['label']); ?>
							</li>
							<?php endforeach;?>
						</ul>
					</li>
					<?php endforeach;?>
				</ul>
			</nav>
			<div id="content">
				<!-- End Header Segment -->