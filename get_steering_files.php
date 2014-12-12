<!-- Scan the 'Steering' directory and create options for each entry -->
<?php
    $output = shell_exec('find Steering/ -name *.txt');
    $steering_array = preg_split("/\r\n|\n|\r| /", $output);

    echo "<option>None</option>\n";

    foreach ($steering_array as $file) {
        $full = $file;
        $stripped = preg_replace('Steering/', '', $file);
        $stripped = basename($stripped, '.txt');
        echo "<option value='$full'>$stripped</option>\n";
    }
?>
