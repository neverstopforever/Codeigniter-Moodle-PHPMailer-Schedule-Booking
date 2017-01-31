
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
function processEmpleados($data){
    $newData=array();
    foreach ($data[0] as $key => $value) {
        $newData[$key] = $value;
        if($key == 'foto')
        {
            
            $newData[$key] = 'data:image/jpeg;base64,'.base64_encode($value);
        }
    }
    return $newData;
}


function languageEncodeToUtf8($language) {
    $newLanguage = array();
    foreach ($language as $key => $value) {
        
        $newLanguage[$key] = mb_convert_encoding($value, "UTF-8", mb_detect_encoding($value, "UTF-8, ISO-8859-1, ISO-8859-15", true));
    }
     return $newLanguage;
}

if (!function_exists('convert_date')) {

    function convert_date($string, $from_mask, $to_mask='', $return_unix=false)
    {
        // define the valid values that we will use to check
        // value => length
        $all = array(
            's' => 'ss',
            'i' => 'ii',
            'H' => 'HH',
            'y' => 'yy',
            'Y' => 'YYYY',
            'm' => 'mm',
            'd' => 'dd'
        );

        // this will give us a mask with full length fields
        $from_mask = str_replace(array_keys($all), $all, $from_mask);

        $vals = array();
        foreach($all as $type => $chars)
        {
            // get the position of the current character
            if(($pos = strpos($from_mask, $chars)) === false)
                continue;

            // find the value in the original string
            $val = substr($string, $pos, strlen($chars));

            // store it for later processing
            $vals[$type] = $val;
        }

        foreach($vals as $type => $val)
        {
            switch($type)
            {
                case 's' :
                    $seconds = $val;
                    break;
                case 'i' :
                    $minutes = $val;
                    break;
                case 'H':
                    $hours = $val;
                    break;
                case 'y':
                    $year = '20'.$val; // Year 3k bug right here
                    break;
                case 'Y':
                    $year = $val;
                    break;
                case 'm':
                    $month = $val;
                    break;
                case 'd':
                    $day = $val;
                    break;
            }
        }


        $unix_time = mktime(
            (int)$hours, (int)$minutes, (int)$seconds,
            (int)$month, (int)$day, (int)$year);

        if($return_unix){
            return $unix_time;
        }


        return date($to_mask, $unix_time);
    }
}

if (!function_exists('image_parser_from_db')) {

    function image_parser_from_db($bd_photo)
    {
        $img_src = (isset($bd_photo)) ? 'data:image/jpeg;base64,'.base64_encode($bd_photo) : base_url().'assets/img/dummy-image.jpg';

        return $img_src;
    }
}


if (!function_exists('decharespeciales')) {

    function decharespeciales($str) {
        $str = str_replace("/mas","+",$str);
        $str = str_replace("&amp;","&",$str);
        $str = str_replace("/alm","#",$str);
        $str = str_replace("/bar",'`\`',$str);
        $str = str_replace("/coma",",",$str);

        return $str;
    }
}

if (!function_exists('getUserIP')) {
    function getUserIP(){
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }
}

if (!function_exists('replaceTemplateBody')) {

    function replaceTemplateBody($str, $replace_data) {
        $result_str = '';
        if(!empty($replace_data)){

            foreach($replace_data as $key=>$value){
                $subject = !empty($result_str) ? $result_str :  $str;
                $result_str = str_replace('['.$key.']', $value, $subject);
            }
        }
        return $result_str;
    }
}

if ( ! function_exists('switch_db_dynamic'))
{
    function switch_db_dynamic($name_db)
    {
        $CI =& get_instance();
        $CI->db = $CI->load->database($name_db, true);
    }
}

if ( ! function_exists('isToday'))
{
    function isToday($date) //check if it's today
    {
        $date = date("l, F d",strtotime($date));
        if($date == date("l, F d"))
            return true;
        else
            return false;
    }
}

if ( ! function_exists('isYesterday'))
{
    function isYesterday($date) //check if it's yesterday
    {
        $date = date("l, F d",strtotime($date));
        if($date == date("l, F d")-1)
            return true;
        else
            return false;
    }
}

if ( ! function_exists('thousandsCurrencyFormat'))
{
    function thousandsCurrencyFormat($num) {
        $CI =& get_instance();

        $x = round($num);
        if($x <= 999){
            return $x;
        }
        $x_number_format = number_format($x);

        $x_array = explode(',', $x_number_format);
        $x_parts = array(' K', ' M', ' B', ' T');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        
        $lang = $CI->session->userdata('lang');
        
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        if($lang == "spanish"){
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? ',' . $x_array[1][0] : '');
        }

        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
    }
}