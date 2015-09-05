<?php
/**
 * Compute the delay to execute a function a number of time
 * @param $count    Number of time that the tests will execute the given function
 * @param $function     the function to test. Can be a string with parameters (ex: 'myfunc(123, 0, 342)') or a callback
 * @return float            Duration in seconds (as a float)
 */
function timeit($count, $function) {
    if ($count <= 0){
        echo "Error: count have to be more than zero";
        return -1;
    }
    
    $nbargs = func_num_args();
    if ($nbargs < 2) {
        echo 'Error: No Funciton!';
        echo 'Usage:';
        echo "\ttimeit(count, 'function(param)')";
        echo "\te.g:timeit(100, 'function(0,2)')";
        return -1;                      // no function to time
    }
    
    // Generate callback
    $func = func_get_arg(1);
    $func_name = current(explode('(', $func));
    if (!function_exists($func_name)) {
        echo 'Error: Unknown Function';
        return -1;                  // can't test unknown function
    }
    
    $str_cmd = '';
    $str_cmd .= '$start = microtime(true);';
    $str_cmd .= 'for($i=0; $i<'.$count.'; $i++) '.$func.';';
    $str_cmd .= '$end = microtime(true);';
    $str_cmd .= 'return ($end - $start);';
    
    return eval($str_cmd);
}

?>
