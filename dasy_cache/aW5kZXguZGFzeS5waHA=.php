<php>
	<?php $i=2; ?>
	<?php $max=10; ?>
	<?php $toto='test'; ?>

	<?php const TOTO2='test' ?>
	<?php define('TOTO3', 'toto'); ?>

	<?php if($i<2 || $max==10) {
		print 'test';
	}
	elseif($i<2 || max!=10) {
		print 'test2';
	}
	else if(i<2 && max!=10) {
		print 'test4';
	}
	else  {
		print 'test3';
	} ?>


</php>²
<?php
	var_dump($i, $max, $toto, TOTO2, TOTO3);
?>
