<?php foreach($test as $value) {
	echo $value."<br>\n\n";
} ?>

<?php for($i=0, $max=10; $i<$max; $i++) {
	echo $i."<br>\n";
} ?>

<?php $i=0 ?>
<?php $max=10 ?>
@global_const(TEST="lol");

@while(($i < $max) => {
	<?php if($i>2) {
		echo $i."<br>\n";
		$i++;
	} ?>
});
