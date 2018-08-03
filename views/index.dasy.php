<php>
	let i=2;
	let max=10;
	var toto='test';
	let my_array = [{"toto": "test"}];
	let var1 = 10;
	let var2 = 5;

	const TOTO2='test';
	define TOTO3='toto';

	if(i<2 || max==10) {
		print 'test'
	};
	else if(i<2 || max!=10) {
		print 'test2'
	};
	else if(i>2 && max!=10) {
		print 'test4'
	};
	else {
		print 'test3'
	};

	switch(i) {
		case 2 {
			print 'test'.'<br>'
			break
		}
		case 3 {
			print 'test3'.'<br>'
			break
		}
		default {
			print 'default'.'<br>'
			break
		}
	};

	my_array->each((value) => {
		var_dump($value)
	});

	for(let i=0, max=10; i < max; i++) {
		print $i.'<br>'
	};

	while(var1 >= var2) {
		var_dump($var1, $var2)
		$var1--
	};

</php>²
<?php
	var_dump($i, $max, $toto, TOTO2, TOTO3);
?>
