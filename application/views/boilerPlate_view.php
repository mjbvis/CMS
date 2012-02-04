<h2>Bacon Ipsum</h2>
<p>Bacon ipsum dolor sit amet pig shank tri-tip capicola spare ribs. Ribeye meatloaf ground round, beef ribs ham beef turkey spare ribs flank brisket hamburger turducken bacon. Andouille meatloaf tenderloin meatball ground round, kielbasa short loin tail pork loin strip steak swine salami pork chop. Sirloin chicken shank, pork loin spare ribs biltong pork chop kielbasa.</p>
<h3>Data query example</h3>
<ul>
	<?php foreach($query->result() as $row): ?>
	<li><?php echo $row -> name;?></li>
	<?php endforeach; ?>
</ul>