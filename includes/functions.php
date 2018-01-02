***REMOVED***
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
            $funcresult = $bytes / $arItem["VALUE"];
            $funcresult = str_replace(".", "." , strval(round($funcresult, 2)))." ".$arItem["UNIT"];
            break;
        ***REMOVED***
    ***REMOVED***
    global $funcresult;
    return $funcresult;
***REMOVED***
***REMOVED***