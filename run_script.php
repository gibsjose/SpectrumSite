<!-- Get HTTP Request from JS on plot.php -->
<?php
    $script = $_POST['script'];
    $flags = $_POST['flags'];

    $output = shell_exec($script . $flags);
    echo "$output";
?>
