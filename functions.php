<?php

function FileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "PB",
                "VALUE" => pow(1024, 3)
            ),
            1 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 2)
            ),
            2 => array(
                "UNIT" => "GB",
                "VALUE" => 1024
            ),
            3 => array(
                "UNIT" => "MB",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "." , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}
?>