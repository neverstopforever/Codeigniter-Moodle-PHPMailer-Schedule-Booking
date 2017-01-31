<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LeadsModel
 *
 * @author Basit Ullah
 */
class LeadsModel extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->tableName = "variables2";
         $this->table = "erp_custom_fields";
    }

    public function getEstadoData() {
        $query = $this->db->get('estado_solicitud');
        return $query->result_array();
    }

    public function getMediosData() {
        $query = $this->db->get('medios');
        return $query->result_array();
    }

    public function updateVariable() {
        $updateQuery = $this->db->query("UPDATE " . $this->tableName . " SET numpresupuesto = numpresupuesto + 1");
        if ($updateQuery) {
            $query = $this->db->query("SELECT numpresupuesto+1 as leadid FROM " . $this->tableName . " ");
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                return $row["leadid"];
            }
        }
        return null;
    }

 public function getFieldsList($form_type = null){
        $this->db->select('*');
        $this->db->from($this->table);
        if($form_type) {
            $this->db->where('form_type', $form_type);
        }
        $query = $this->db->get();
        
        return $query->result_array();
        
    }
    public function addLeadsRecords($formData = false) {

        if ($formData) {
            $data_presupuestot = array(
                "NumPresupuesto" => isset($formData["NumPresupuesto"]) ? trim($formData["NumPresupuesto"]): null,
                "Nombre" => (isset($formData["sApellidos"]) && isset($formData["Nombre"])) ? $formData["sApellidos"] . " " . $formData["Nombre"]: null,
                "sNombre" => isset($formData["Nombre"]) ? $formData["Nombre"]: null,
                "sApellidos" => isset($formData["sApellidos"]) ? $formData["sApellidos"]: null,
                "FechaPresupuesto" => date("Y-m-d H:i:s"),
                "FechaUltima" => date("Y-m-d H:i:s"),
                "IdAlumno" => $formData['IdAlumno'],
                "IdCentro" => "0",
                "leido" => "1",
                "facturara" => "0",
                "perfil" => "1",
                "idusuario" => $this->session->userdata("userData")[0]->Id,
                "idestado" => "0",
                "email" => (isset($formData["email"]) ? $formData["email"] : null),
                "id_user" => $this->session->userdata("userData")[0]->Id,
                "custom_fields"=>$formData['custom_fields'],
            );
            if($this->db->insert("presupuestot", $data_presupuestot)){
                return true;
            }
        }
        return false;
    }

    public function getCopyUsers($formData = false) {
        $getQuery = $this->db->query("SELECT sql_es, sql_en FROM erp_consultas
                                        WHERE ref = 'lst_sol_copy_user'
                                        ");
        if ($getQuery->num_rows() > 0) {
            $row = $getQuery->row_array();
            if ($formData) {
                $query = $this->db->query("SELECT * FROM
                                        (
                                        (SELECT '1' AS `Profileid`, co.`Id` AS  id, co.`sApellidos` AS Apellidos, co.`sNombre` AS Nombre, co.`Email`, 'Contacto' AS `Perfil`
                                        FROM contactos AS co
                                        where co.`sNombre` IS NOT NULL 
                                        ORDER BY 3)
                                        UNION
                                        (SELECT '2' AS `Profileid`, al.`ccodcli` AS id, al.`sApellidos` AS Apellidos, al.`sNombre` AS Nombre, al.`Email`, 'Alumno' AS `Perfil`
                                        FROM alumnos AS al
                                        where al.`sNombre` IS NOT NULL
                                        ORDER BY 3)
                                        ) AS t1 WHERE Nombre LIKE '%" . $formData["Nombre"] . "%' ORDER BY 3
                                        ");
            } else {
                if ($row["sql_es"] != "") {
                    $query = $this->db->query("SELECT * FROM
                                        (
                                        (SELECT '1' AS `Profileid`, co.`Id` AS  id, co.`sApellidos` AS Apellidos, co.`sNombre` AS Nombre, co.`Email`, 'Contacto' AS `Perfil`
                                        FROM contactos AS co
                                         where co.`sNombre` != ''
                                        ORDER BY 3)
                                        UNION
                                        (SELECT '2' AS `Profileid`, al.`ccodcli` AS id, al.`sApellidos` AS Apellidos, al.`sNombre` AS Nombre, al.`Email`, 'Alumno' AS `Perfil`
                                        FROM alumnos AS al
                                        where al.`sNombre` != ''
                                        ORDER BY 3)
                                        ) AS t1 ORDER BY 3");
                } else {
                    $query = $this->db->query("SELECT * FROM
                                        (
                                        (SELECT '1' AS `Profileid`, co.`Id` AS  id, co.`sApellidos` AS Apellidos, co.`sNombre` AS Nombre, co.`Email`, 'Contacto' AS `Perfil`
                                        FROM contactos AS co
                                        where co.`sNombre` IS NOT NULLl 
                                        ORDER BY 3)
                                        UNION
                                        (SELECT '2' AS `Profileid`, al.`ccodcli` AS id, al.`sApellidos` AS Apellidos, al.`sNombre` AS Nombre, al.`Email`, 'Alumno' AS `Perfil`
                                        FROM alumnos AS al
                                        where al.`sNombre` IS NOT NULL
                                        ORDER BY 3)
                                        ) AS t1 ORDER BY 3");
                }
            }
            $dataArray = array();
            if ($query->num_rows() > 0) {
                $rows = $query->result_array();
                //vardump($rows);exit;
                foreach ($rows as $row) {
                    $data = array(
                        "select" => "Select",
                        "id" => $row["id"],
                        "Profileid" => $row["Profileid"],
                        "Apellidos" => $row["Apellidos"],
                        "Nombre" => $row["Nombre"],
                        "Email" => $row["Email"],
                        "Perfil" => $row["Perfil"],
                    );
                    $dataArray[] = $data;
                }
                return $dataArray;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    public function getCopyContactos() {
        $getQuery = $this->db->query("SELECT sql_es, sql_en FROM erp_consultas
                                        WHERE ref = 'lst_sol_copy_user'
                                        ");
        if ($getQuery->num_rows() > 0) {
            $row = $getQuery->row_array();
                if ($row["sql_es"] != "") {
                    $query = $this->db->query("SELECT '1' AS `Profileid`, co.`Id` AS  id, co.`sApellidos` AS Apellidos, co.`sNombre` AS Nombre, co.`Email`, 'Contacto' AS `Perfil`
                                        FROM contactos AS co
                                         where co.`sNombre` != ''
                                        ORDER BY 3 ");
                } else {
                    $query = $this->db->query("SELECT '1' AS `Profileid`, co.`Id` AS  id, co.`sApellidos` AS Apellidos, co.`sNombre` AS Nombre, co.`Email`, 'Contacto' AS `Perfil`
                                        FROM contactos AS co
                                        where co.`sNombre` IS NOT NULLl 
                                        ORDER BY 3 ");
                }
            
            $dataArray = array();
            if ($query->num_rows() > 0) {
                $rows = $query->result_array();
                //vardump($rows);exit;
                foreach ($rows as $row) {
                    $data = array(
                        "select" => "Select",
                        "id" => $row["id"],
                        "Profileid" => $row["Profileid"],
                        "Apellidos" => $row["Apellidos"],
                        "Nombre" => $row["Nombre"],
                        "Email" => $row["Email"],
                        "Perfil" => $row["Perfil"],
                    );
                    $dataArray[] = $data;
                }
                return $dataArray;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    public function getCopyStudents() {
        $query = $this->db->query("
                                       SELECT '2' AS `Profileid`, al.`ccodcli` AS id, al.`sApellidos` AS Apellidos, al.`sNombre` AS Nombre, al.`Email`, 'Alumno' AS `Perfil`
                                        FROM alumnos AS al
                                        where al.`sNombre` IS NOT NULL
                                        ORDER BY 3"
                                        );
            $dataArray = array();
            if ($query->num_rows() > 0) {
                $rows = $query->result_array();
                //vardump($rows);exit;
                foreach ($rows as $row) {
                    $data = array(
                        "select" => "Select",
                        "id" => $row["id"],
                        "Profileid" => $row["Profileid"],
                        "Apellidos" => $row["Apellidos"],
                        "Nombre" => $row["Nombre"],
                        "Email" => $row["Email"],
                        "Perfil" => $row["Perfil"],
                    );
                    $dataArray[] = $data;
                }
                return $dataArray;
            } 
        
    }

    public function addExistingUser($leadId = false, $userId = false, $profileId = false) {
        if ($profileId == 1) {
            $query = $this->db->query("INSERT presupuestot (
                                        `sNombre`, `sApellidos`, `email`, `domicilio`,
                                        `Poblacion`, `Provincia`, `pais`, `Nacimiento`,
                                        `CPTLCLI`, `Movil`, `iban`, `idsexo`,
                                        `CDNICIF`, `Nombre`, `Skype`, `Telefono`,
                                        `Telefono2`, `perfil`, 
                                        `NumPresupuesto`, `FechaPresupuesto`,`FechaUltima`,`Estado`,
                                        `IdAlumno`,`IdCentro`,`leido`,`facturara`,
                                        `idusuario`,`prioridad`,`bookmark`,`idestado`
                                        )
                                        SELECT 
                                          `sNombre`, `sApellidos`, `email`, `domicilio`,
                                          `Poblacion`, `Provincia`, `pais`, `FNacimiento`,
                                          `Distrito`, `Movil`, `iban`, `idsexo`,
                                          `CDNICIF`,  `Nombre`, `Skype`, `Telefono1`,
                                          `Telefono2`, '1',
                                          $leadId, CURDATE(), CURDATE(), '0',
                                          id, '0', '1', '0',
                                          $userId, '0', '0', '0'

                                        FROM
                                          contactos
                                          WHERE id  = $userId
                                        ");
            return $leadId;
        } else {
            $query = $this->db->query("INSERT presupuestot (
                                        `sNombre`, `sApellidos`, `email`, `domicilio`,
                                        `Poblacion`, `Provincia`, `pais`, `Nacimiento`,
                                        `CPTLCLI`, `Movil`, `iban`, `idsexo`,
                                        `CDNICIF`, `Nombre`, `Skype`, `Telefono`,
                                        `Telefono2`, `perfil`, 
                                        `NumPresupuesto`, `FechaPresupuesto`,`FechaUltima`,`Estado`,
                                        `IdAlumno`,`IdCentro`,`leido`,`facturara`,
                                        `idusuario`,`prioridad`,`bookmark`,`idestado`
                                        )
                                        SELECT 
                                          `sNombre`, `sApellidos`, `email`, `cdomicilio`,
                                          `cpobcli`,`ccodprov`,`cnaccli`,`Nacimiento`,
                                          `cptlcli`,`Movil`,`iban`,`idsexo`,
                                          `CDNICIF`,`cnomcli`,`SkypeAlumno`,`ctfo1cli`,
                                          `ctfo1cli`, '2',
                                          $leadId, CURDATE(), CURDATE(), '0',
                                          ccodcli, '0', '1', '0',
                                          $userId, '0', '0', '0'

                                        FROM
                                          alumnos
                                          WHERE ccodcli  = $userId
                                        ");
            return $leadId;
        }
    }

    public function updateContactosFromProspects($IdAlumno = null){
        if(!$IdAlumno){
            return null;
        }
        $sql = "UPDATE contactos AS cot 
            
                 LEFT JOIN presupuestot AS
                 prt ON cot.id = prt.IdAlumno
                SET cot.sNombre = prt.sNombre,
                  cot.sApellidos = prt.sApellidos,
                  cot.email = prt.email,
                  cot.domicilio = prt.domicilio,
                  cot.Poblacion = prt.Poblacion,
                  cot.Provincia = prt.Provincia,
                  cot.pais = prt.pais,
                  cot.FNacimiento = prt.Nacimiento,
                  cot.Distrito = prt.CPTLCLI,
                  cot.Movil = prt.Movil,
                  cot.iban = prt.iban,
                  cot.idsexo = prt.idsexo,
                  cot.CDNICIF = prt.CDNICIF,
                  cot.Nombre = prt.Nombre,
                  cot.Skype = prt.Skype,
                  cot.Telefono1 = prt.Telefono,
                  cot.Telefono2 = prt.Telefono2,
                  cot.LastUpdate = CURDATE(),
                  cot.facturara = prt.facturara
                  WHERE prt.IdAlumno = '".$IdAlumno."'
                  AND prt.perfil = 1";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProspectDataById($id){
        $query = $this->db->select('sNombre AS first_name, sApellidos AS last_name, 
                            CONCAT(sNombre, "  ",sApellidos) AS full_name, email, 
                            Movil AS mobile,
                            Telefono AS phone,
                            Fax AS fax,
                            Nacimiento,
                            ')
                 ->from('presupuestot')
                 ->where('NumPresupuesto', $id)
                 ->get();

        return $query->row();
    }

    public function deleteLead($leadId = false, $profileId = false) {
        if ($leadId > 0) {
            $this->db->query("DELETE from presupuestot WHERE NumPresupuesto = $leadId");
            $this->db->query("DELETE from presupuestol WHERE NumPresupuesto = $leadId");
            $this->db->query("DELETE from presupuesto_solicitud WHERE NumPresupuesto = $leadId");
            $this->db->query("DELETE from presupuesto_doc WHERE idpresupuesto = $leadId");
            $this->db->query("DELETE from presupuesto_segui WHERE NumPresupuesto = $leadId");
            if($profileId == 1) {
                $this->db->query("DELETE from contactos WHERE Id = $leadId");
            } else if($profileId == 2) {
                $this->db->query("DELETE from alumnos WHERE ccodcli = $leadId");
            }
            return 1;
        } else {
            return 0;
        }
    }

}
