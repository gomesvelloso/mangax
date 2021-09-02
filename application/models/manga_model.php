<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manga_model extends CI_Model {

    public function listAll($params=null){

        $this->db->select("obj.*");
        $this->db->from("objetos obj");
        $this->db->join("categorias cat", "obj.fk_categoria = cat.id_categoria");

       if(isset($params["id_categoria"])){
           $this->db->where("obj.fk_categoria",$params["id_categoria"]);
       }
       if(isset($params["order_by"])){
            if(isset($params["rand"])){
                $this->db->order_by($params["order_by"], 'RANDOM');
            }else{
                $this->db->order_by($params["order_by"]);
            }
       }
       if(isset($params["has_qtd_objeto"])){
            $this->db->where("obj.qtd_objeto >0");
       }
       if(isset($params["limit"])){
            $this->db->limit($params["limit"]);
       }  
       return $this->db->get()->result();
        
    }
}

?>