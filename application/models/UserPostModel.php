<?php

class UserPostModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "usuarios_post";
    }

    public function getAll() {

        $query = "SELECT
				post_id,
				post_date,
				post_title,
				post_content,
				post_image
				FROM usuarios_post
				ORDER BY post_date DESC
				;";

        return $this->selectCustom($query);
    }
}