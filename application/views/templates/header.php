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
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="Robots" content="noindex, nofollow, noarchive">
		<meta name="Description" content="Corvallis Montessori School">
		<meta name="Author" content="Corvallis Montessori School">
		<meta name="Rating" content="General">
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<title><?php echo((isset_not_empty($title) ? "$title | CMS" : "CMS"));?></title>
		<link rel="icon" type="image/x-icon" href="<?php echo base_url('favicon.ico');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/styles/screen.css');?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo base_url('assets/styles/forms/screen.css');?>" type="text/css" media="screen" />
		
		<script type="text/javascript" src="assets/js/jquery.autoheight.js"></script>
		
	</head>
	<body>
		<div id="header">
			<a href="http://www.corvallismontessori.org/"><img src="<?php echo base_url('assets/images/cms_logo.png');?>" alt="CMS Logo" width="580" height="91"></a>
		</div>
		<div id="main">
			<nav id="topNav">
				<ul>
					<?php
					foreach($MenuItems as $mItem):
						$mItemAttr = $mItem->attributes();
						printf('<li>');
							printf('<a href=%s>%s</a></br>', base_url($mItemAttr['url']), $mItemAttr['label']);
							printf('<ul>');
								foreach($mItem->sub_items as $sItem):
									$sItemAttr = $sItem->attributes();
									printf('<li>');
										printf('<a href=%s>%s</a></br>', base_url($sItemAttr['url']), $sItemAttr['label']);
									printf('</li>');
								endforeach;
							printf('</ul>');
						printf('</li>');
					endforeach;
					?>
				</ul>
			</nav>
			<div id="content">
				<!-- End Header Segment -->