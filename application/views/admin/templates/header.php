<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="Robots" content="noindex, nofollow, noarchive">
		<meta name="Description" content="Corvallis Montessori School">
		<meta name="Author" content="Corvallis Montessori School">
		<meta name="Rating" content="General">
		<title><?php echo($title); ?> | CMS</title>
		<link rel="icon" type="image/x-icon" href="<?php echo base_url('favicon.ico'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/styles/screen.css'); ?>" type="text/css"	media="screen" />
	</head>
	<body>
		<div id="main">
			<div id="header">
				<header>
					<div id="log">Login/Logout Stuff Here</div>
					<img src="<?php echo base_url('assets/images/cms_logo.png'); ?>" alt="CMS Logo" width="585" height="67">
					<nav id="topNav">
						<ul>
							<li><?php echo anchor('admin/admin', 'Home'); ?></li>
							<li>Admissions
								<ul>
									<li><?php echo anchor('admin/admin/register', 'Create New Parent Account'); ?></li>
								</ul>
							</li>
							<li>Item 4</li>
							<li>Item 5</li>
							<li>Item 6</li>
							<li>Item 7</li>
						</ul>
					</nav>
				</header>
			</div>
			<div id="sideBar">
				<ul style="list-style:none">
					<li>Item 1</li>
					<li>Item 2</li>
					<li>Item 4</li>
					<li>Item 5</li>
					<li>Item 6</li>
					<li>Item 7</li>
				</ul>
			</div>
			<div id="content">
				
<!-- End Header Segment -->
