<?php


class CursosModel extends MagaModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'cursos';
    }

   public function getCourses(){
       $query = $this->db->select('id, curso AS title ')
                         ->from($this->table)
                         ->order_by('2')
                         ->get();

       return $query->result();

   }

}