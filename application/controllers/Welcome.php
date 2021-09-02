<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('categoria_model', 'categoria');
 	    $this->load->model('manga_model', 'manga');
	
		$mangas = $linkCategorias = $optionCategorias = null;
		$optionCategorias .= '<option value="">Categorias</option>';
		$categorias = $this->categoria->listAll(array("order_by"=>"nome_categoria ASC"));
		if(!empty($categorias)){
			foreach($categorias as $c){
				$linkCategorias   .='<a href="'.base_url().'categoria/'.$c->id_categoria.'" class="list-group-item">'.$c->nome_categoria.'</a>';
				$optionCategorias .='<option value="'.$c->id_categoria.'">'.$c->nome_categoria.'</option>';
			}
		}
        
        $dados = $this->manga->listAll(array("order_by"=>"obj.nome_objeto","has_qtd_objeto"=> true,"limit"=>4, "rand"=>true));
        
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
                        Nenhum objeto cadastrado no site. 
                      </div>';
        }

        
		$data = array("objetos"=>$mangas,"display"=>"block","jumbotron"=>"MANGAX!","linkCategorias"=>$linkCategorias, "optionCategorias"=>$optionCategorias);
		
		$this->load->view('topo',$data);
		$this->load->view('rodape');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */