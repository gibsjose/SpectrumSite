<!-- Scan the 'Steering' directory and create options for each entry -->
<?php
    $output = shell_exec('find Steering/ -name *.txt');
    $steering_array = preg_split("/\r\n|\n|\r| /", $output);

    echo "<option>None</option>\n";

    foreach ($steering_array as $file) {
        $full = $file;
        $stripped = basename($file, '.txt');
        echo "<option value='$full'>$stripped</option>\n";
    }
?>

<!-- <?php
    function startsWith($haystack, $needle) {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }
?>

<?php
    $s_config = 'config/steering.config';
    $config_contents = file_get_contents($s_config);
    $lines = explode('\n', $config_contents);

    foreach($lines as $line) {
        if(startsWith($line, "#")) {

        }
    }
?> -->
