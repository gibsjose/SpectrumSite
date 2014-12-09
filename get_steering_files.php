
<!-- Scan the 'Steering' directory and create options for each entry -->
<?php
    $output = shell_exec('find Steering/ -name *.txt');
    $steering_array = preg_split("/\r\n|\n|\r| /", $output);
    //$steering_array = explode(" ", $)
    echo "$output";
    var_dump($steering_array);
    echo "<option>None</option>\n";

    foreach ($steering_array as $file) {
        error_log("$file");
        echo "<option>$file</option>\n";
    }
?>
