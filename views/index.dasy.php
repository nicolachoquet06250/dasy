<!Doctype html>
<html>
<head>
	<meta charset="{{charset}}" />
	<title>{{page_title}}</title>
</head>

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

	test->each((value) => {
		var_dump($value)
	});

	for(let i=0, max=10; i < max; i++) {
		print $i.'<br>'
	};

	while(var1 >= var2) {
		var_dump($var1, $var2)
		$var1--
	};

	dump(i);
	dump(max);
	dump(toto);
	<br>
	dump_constant(TOTO2);
	dump_constant(TOTO3);
	<br>
	dump(i === max && i > var1);

</php>²

</html>
