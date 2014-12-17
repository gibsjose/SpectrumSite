<?php
    //Get the script name and flags
    $script = $_POST['script'];
    $flags = $_POST['flags'];

    //Strip C-Style quotation escaping
    $script = stripslashes($script);
    $flags = stripslashes($flags);

    //Create the full string
    $full = $script . " " . $flags;

    //Run the script and print the output
    $output = `$full`;
    print("$output");
?>
