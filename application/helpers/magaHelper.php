
<?php


function utf8ize($d) {
    $n = array();
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $n[utf8ize($k) ] = utf8ize($v);
        }
    } 
    else if (is_string($d)) {
        return utf8_encode($d);
    }
    return $n;
}

function recordsList($strQueryString) {
    if ($resQuery = mysql_query($strQueryString)) {
        $objReturn = array();
        while ($objRow = mysql_fetch_assoc($resQuery)) {
            $objReturn[] = $objRow;
        }
        return $objReturn;
    } 
    else {
        return null;
    }
}


 function encodeToUtf8($string) {
     return mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
}

 function languageEncodeToUtf8($language) {
    $newLanguage = array();
    foreach ($language as $key => $value) {
        $newLanguage[$key] = mb_convert_encoding($value, "UTF-8", mb_detect_encoding($value, "UTF-8, ISO-8859-1, ISO-8859-15", true));
    }
     return $newLanguage;
}
