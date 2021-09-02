<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categoria_model extends CI_Model {

    public function listAll($params=null){
        
       if(isset($params["id_categoria"])){
           $this->db->where("id_categoria",$params["id_categoria"]);
       }
       if(isset($params["order_by"])){
            $this->db->order_by($params["order_by"]);
       }
       return $this->db->get('categorias')->result();
        
    }
}

?>