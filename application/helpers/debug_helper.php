<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Readable print_r
 *
 * Prints human-readable information about a variable
 *
 * @access	public
 * @param	mixed
 */
if ( ! function_exists('printr'))
{
    function printr($var)
    {
        $CI =& get_instance();
        echo '<pre>' . print_r($var, TRUE) . '</pre>';
    }
}
// ------------------------------------------------------------------------
/**
 * Readable var_dump
 *
 * Readable dump information about a variable
 *
 * @access	public
 * @param	mixed *
 */
if ( ! function_exists('vardump'))
{
    function vardump($var)
    {
        $CI =& get_instance();
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}
/* End of file debug_helper.php */
/* Location: ./application/helpers/debug_helper.php */
