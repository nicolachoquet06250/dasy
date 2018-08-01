@$test->each(($value) => {
	echo $value."<br>\n\n";
});

@for(($i=0, $max=10; $i<$max; $i++) => {
	echo $i."<br>\n";
});

@var(i=0);
@var(max=10);
@global_const(TEST="lol");

@while(($i < $max) => {
	@if(($i>2) => {
		echo $i."<br>\n";
		$i++;
	});
});
