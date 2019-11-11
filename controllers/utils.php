<?php
function sanity_check($data, $flag=TRUE) {
    $data = trim($data);
    if ($flag) $data = stripslashes($data);
    else $data = str_replace("\\", "\\\\", $data);
    $data = htmlspecialchars($data);
    return $data;
}