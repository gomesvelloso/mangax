<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller {

	public function index()
	{
        
        $this->load->model('manga_model', 'manga');
        $this->load->model('categoria_model', 'categoria');

        $id_categoria = $this->uri->segment(2);
        
        
        $mangas = $nomeCategoria = $linkCategorias = $optionCategorias = null;
		$optionCategorias .= '<option value="">Categorias</option>';
		$categorias = $this->categoria->listAll(array("order_by"=>"nome_categoria ASC"));
		if(!empty($categorias)){
			foreach($categorias as $c){
                $activeCategoria = $selectedCategoria = null;

                if($c->id_categoria == $id_categoria){
                    $selectedCategoria = "SELECTED";
                    $activeCategoria   = "active";
                    $nomeCategoria = $c->nome_categoria;  
                }
                $linkCategorias   .='<a href="'.base_url().'categoria/'.$c->id_categoria.'" class="list-group-item '.$activeCategoria.'">'.$c->nome_categoria.'</a>';            
                $optionCategorias .='<option value="'.$c->id_categoria.'" '.$selectedCategoria.'>'.$c->nome_categoria.'</option>';
			}
		}
        
        $dados = $this->manga->listAll(array("id_categoria"=>$id_categoria, "order_by"=>"obj.nome_objeto, obj.volume_objeto"));
        
        if(!empty($dados)){
            foreach($dados as $d){
                $usado = 'Novo';
                if($d->usado_objeto == 1){
                    $usado = "Usado";
                }
                $qtd = null;
                if($d->qtd_objeto == 0){
                    $qtd = "<span style='color:#900; font-weight:bold;'>Indisponível</span>";
                }else{
                    $qtd = '<a href="#" class="btn btn-primary">Go somewhere</a>';
                }
                $mangas.='
                <div class="col-xs-6 col-lg-3" style="margin-bottom:15px; height:400px;">
                    <div class="card">
                      <img class="card-img-top" src="'.base_url("assets/img/".$d->id_objeto.".jpg").'" title="'.$d->nome_objeto.' #'.$d->volume_objeto.'" style="width:165px; height:242px;">
                      <div class="card-body">
                        <div style="height:40px;">
                            <h6 class="card-title">'.$d->nome_objeto.' #'.$d->volume_objeto.'</h6>
                        </div>
                        <div style="height:35px;">
                        <p class="card-text" style="font-size:12px">R$ '.number_format($d->valor_objeto,2,',','.').' - <b>'.$usado.'</b></p>
                        </div>
                        '.$qtd.'
                      </div>
                    </div>
                </div>';
            
            }
        }else{
            $mangas.='<div class="col-xs-12 col-lg-12">
                        Nenhum objeto encontrado para a categoria '.$nomeCategoria.' 
                      </div>';
        }

        $data = array("linkCategorias"=>$linkCategorias, 
                      "optionCategorias"=>$optionCategorias,
                      "objetos"=>$mangas,
                      "jumbotron"=>"Categoria: ".$nomeCategoria,
                      "display"=>"none");
        $this->load->view('topo',$data);
		$this->load->view('rodape');
	}
}
