<?php

class ClientesMainModel extends MagaModel {


    public $fields = array(
        'idgrupo',
        'cnomcom',
        'cnomcli',
        'cdomicilio',
        'cpobcli',
        'cprovincia',
        'ctfo1cli',
        'ctfo1cli',
        'ctfo2cli',
        'cptlcli',
        'cdninif',
        'ccontacto',
        'email',
        'web',
        'activo',
        'ipservidor',
        'cnaccli',
        'login',
        'pwd',
    );
    public function __construct() {
        parent::__construct();
        $this->table = "clientes_akaud"; //admin_akaud db
        $this->_db_name = "admin_akaud"; //admin_akaud db
        $this->_db = $this->load->database($this->_db_name, true);
    }

    public function getNotExistCustomers() {

        $query = "SELECT
				cli.CCODCLI as idcliente,
				cli.cnomcli as customer_name				
				FROM
				clientes_akaud
				AS
				cli
				WHERE cli.CCODCLI NOT IN
                  (
                    SELECT idcliente
                    FROM clientes_akaud_accounts WHERE idcliente IS NOT NULL
                  )";
        $res = $this->_db->query($query);

        return $res->result();
    }

    public function getAll($where_query = '') {

        $query = "SELECT 
                  cli.ccodcli AS id,
                  cli.cnomcom AS `commercial_name`,
                  cli.cnomcli AS `fiscal_name`,
                  cli.cpobcli AS `city`,
                  cli.cprovincia AS `province`,
                  CONCAT(cli.ctfo1cli,' ',cli.ctfo2cli) AS `phones`,
                  cli.ccontacto AS contact,
                  cli.email,
                  web,
                  IF(cli.activo=1,'active','not_active') AS state,
                  cli.cnaccli AS `country`,
                  cli.cdomicilio AS `address`,
                  cli.cptlcli AS `zip_code`,
                  cli.cdnicif AS `fiscal_code`,
                  cli.idgrupo AS `idgrupo`,
                  cli.ctfo1cli AS `phone1`,
                  cli.ctfo2cli AS `phone2`,
                  cli.ipservidor AS `ipserver`,
                  cli.login AS `login`,
                  cli.pwd AS `pwd`,
                  gc.grupo AS `group`
                  
                FROM
                  clientes_akaud AS cli
                  LEFT JOIN grupoclientes AS gc
                  ON cli.idgrupo = gc.idgrupo ";

        if(!empty($where_query)){
            $query .= " WHERE ".$where_query;
        }
        $query .= " ORDER BY 2 ;";
        $res = $this->_db->query($query);

        return $res->result();
    }

    public function addEditCustomer($data = null, $type = 'add') {

        if(empty($data)
            && $type != 'add'
            && $type != 'edit'){
            return false;
        }

        if($type == 'edit' && !isset($data['ccodcli'])){
            return false;
        }

        $add_edit_data = $this->make_customer($data, $type);

        if(empty($add_edit_data)){
            return false;
        }
        if($type == 'add'){
//            $this->_db->insert($this->table, $add_edit_data);
//            $where_query = ' cli.login='.$add_edit_data['login'].' cli.pwd='. $add_edit_data['pwd'] . ' ';
//            $added_item =  $this->getAll($where_query);
            return $this->_db->insert($this->table, $add_edit_data);
        }else if($type == 'edit'){
            $this->_db->where('ccodcli', $data['ccodcli']);
            return $this->_db->update($this->table, $add_edit_data);
        }
    }

    private function make_customer($data = null, $type = 'add'){

        if(empty($data)){
            return false;
        }
        $result = array();
        if($type == 'add'){
            $result = array(
                'idgrupo'=>isset($data['idgrupo']) ? $data['idgrupo'] : 0,
                'cnomcom'=>isset($data['commercial_name']) ? $data['commercial_name'] : null,
                'cnomcli'=>isset($data['fiscal_name']) ? $data['fiscal_name'] : null,
                'cdomicilio'=>isset($data['address']) ? $data['address'] : null,
                'cpobcli'=>isset($data['city']) ? $data['city'] : null,
                'cprovincia'=>isset($data['province']) ? $data['province'] : null,
                'ctfo1cli'=>isset($data['phone1']) ? $data['phone1'] : null,
                'ctfo2cli'=>isset($data['phone2']) ? $data['phone2'] : null,
                'cptlcli'=>isset($data['zip_code']) ? $data['zip_code'] : null,
                'cdnicif'=>isset($data['fiscal_code']) ? $data['fiscal_code'] : null,
                'ccontacto'=>isset($data['contact']) ? $data['contact'] : null,
                'email'=>isset($data['email']) ? $data['email'] : null,
                'web'=>isset($data['web']) ? $data['web'] : null,
                'activo'=>isset($data['state']) ? $data['state'] : null,
                'ipservidor'=>isset($data['ipserver']) ? $data['ipserver'] : null,
                'cnaccli'=>isset($data['country']) ? $data['country'] : null,
                'login'=>isset($data['login']) ? $data['login'] : null,
                'pwd'=>isset($data['password']) ? sha1($data['password'] . $this->config->item('encryption_key')) : null //TODO hashed
            );
        }elseif($type == 'edit'){
            if(isset($data['idgrupo'])){
                $result['idgrupo'] = $data['idgrupo'];
            }
            if(isset($data['commercial_name'])){
                $result['cnomcom'] = $data['commercial_name'];
            }
            if(isset($data['fiscal_name'])){
                $result['cnomcli'] = $data['fiscal_name'];
            }
            if(isset($data['address'])){
                $result['cdomicilio'] = $data['address'];
            }
            if(isset($data['city'])){
                $result['cpobcli'] = $data['city'];
            }
            if(isset($data['province'])){
                $result['cprovincia'] = $data['province'];
            }
            if(isset($data['province'])){
                $result['cprovincia'] = $data['province'];
            }
            if(isset($data['phone1'])){
                $result['ctfo1cli'] = $data['phone1'];
            }
            if(isset($data['phone2'])){
                $result['ctfo2cli'] = $data['phone2'];
            }
            if(isset($data['zip_code'])){
                $result['cptlcli'] = $data['zip_code'];
            }
            if(isset($data['fiscal_code'])){
                $result['cdnicif'] = $data['fiscal_code'];
            }
            if(isset($data['contact'])){
                $result['ccontacto'] = $data['contact'];
            }
            if(isset($data['email'])){
                $result['email'] = $data['email'];
            }
            if(isset($data['web'])){
                $result['web'] = $data['web'];
            }
            if(isset($data['state'])){
                $result['activo'] = $data['state'];
            }
            if(isset($data['ipserver'])){
                $result['ipservidor'] = $data['ipserver'];
            }
            if(isset($data['country'])){
                $result['cnaccli'] = $data['country'];
            }
            if(isset($data['login'])){
                $result['login'] = $data['login'];
            }
            if(isset($data['password'])){
                $result['pwd'] = sha1($data['password'] . $this->config->item('encryption_key')); //TODO hashed
            }

        }

        return $result;
    }

    public function deleteItem($where = null){
        if(empty($where)){
            return false;
        }
        return $this->_db->delete($this->table, $where);
    }
}