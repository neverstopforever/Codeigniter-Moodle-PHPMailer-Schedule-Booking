<?php

/**
 * Created by IntelliJ IDEA.
 * User: qasim
 * Date: 11/29/15
 * Time: 12:37 PM
 */
require_once APPPATH . "third_party/PHPWord.php";

class Word extends PHPWord {

    public function __construct() {
        parent::__construct();
    }

}
