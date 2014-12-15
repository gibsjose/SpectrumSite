<!-- Get HTTP Request from JS on plot.php -->
<?php
    $script = $_POST['script'];
    $flags = $_POST['flags'];

    echo "$script";
    echo "$flags";

    $test = $script . $flags;
    echo "$test";

    $output = shell_exec($script . $flags);
    echo "$output";
?>
