<php>
	let i=2;
	let max=10;
	var toto='test';

	const TOTO2='test';
	define TOTO3='toto';

	if(i<2 || max==10) {
		print 'test';
	}
	else if(i<2 || max!=10) {
		print 'test2';
	}
	else if(i<2 && max!=10) {
		print 'test4';
	}
	else {
		print 'test3';
	}


</php>²
<?php
	var_dump($i, $max, $toto, TOTO2, TOTO3);
?>
