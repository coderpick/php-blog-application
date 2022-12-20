<?php

function inputValidate($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripcslashes($data);
    return $data;
}
/* array item validation */
function is_array_empty($tags)
{
    if (is_array($tags)) {
        foreach ($tags as $key => $value) {
            if (!empty($value) || $value != NULL || $value != "") {
                return true;
                break;
                /* stop the process we have seen that at least 1 of the tagsay has value so its not empty*/
            }
        }
        return false;
    }
}

function str_slug($string){
    $string =mb_strtolower($string);
    $string =str_replace("?","",$string);
    $string =str_replace("%","",$string);
    $string =str_replace("(","",$string);
    $string =str_replace(")","",$string);
    $string =preg_replace("/\s+/u","-",trim ($string));
    return $string;
}

?>