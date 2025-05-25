<?php
if (isset($_GET['fileName'])) {
    $fileName = $_GET['fileName'];

    if (!file_exists($fileName)) {
        $handle = fopen($fileName, 'w');  // Create the file
        fclose($handle);
        echo "$fileName checked/created successfully.";
    } else {
        echo "$fileName already exists.";
    }
}
?>
