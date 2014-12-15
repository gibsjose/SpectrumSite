<!-- Get HTTP Request from JS on plot.php -->
<?php
    $script = $_POST['script'];
    $flags = $_POST['flags'];

    print("<h2>$script</h2>");
    print("<h2>$flags</h2>");

    $test = $script . " " . $flags;
    print("<h2>$test</h2>");

    $output = shell_exec($script . $flags);
    print("<h2>$output</h2>");
?>
