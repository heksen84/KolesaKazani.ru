<?php 
	
	/* Copied from http://in2.php.net/manual/en/function.disk-free-space.php */
	// Calculate Disk space and Conversion without loops
	// Output: 31.24 GB
    $bytes = disk_free_space("."); 
    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
    $base = 1024;
    $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
   // echo $bytes . '<br />';

//    $free_space = sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class];
    $free_space = sprintf("%1.0f", $bytes / pow($base,$class));
    echo $free_space.' '.$si_prefix[$class];
    if ($free_space < 3) echo " - мало места";