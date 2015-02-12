<!-- Scan the 'Grid' directory and create options for each entry -->
<?php

#echo "Scan the Grid directory  ";

$output = shell_exec('find Grids/ -name *[^rav].txt');
$steering_array = preg_split("/\r\n|\n|\r| /", $output);

#echo "<option>None</option>\n";

#echo " output= " $output

foreach ($steering_array as $file) {
    echo "<option>$file</option>\n";
}
?>
