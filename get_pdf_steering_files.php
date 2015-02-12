<!-- Scan the 'PDF' directory and create options for each entry -->
<?php

echo "Scan the PDF directory ";

$output = shell_exec('find PDF/ -name *.txt');


echo "after output ";

#echo "<option>None</option>\n";

#echo " output= " $output;



$steering_array = preg_split("/\r\n|\n|\r| /", $output);

#echo $output

echo "<option>None</option>\n";

foreach ($steering_array as $file) {
    echo "<option>$file</option>\n";
}

?>
