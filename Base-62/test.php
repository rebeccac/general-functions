<?php
	require 'Base62.php';

	$shortened = Base62::convert(rand(10000,99999),10,60);
	echo $shortened;
?>