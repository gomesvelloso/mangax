<?php
class PagamentoMP {

	public $btn_mp;

	private $lightbox = false;

	public $info = array();

	private $sandbox = false;

	private $client_id = "4439260095518932";
	private $client_secret = "AXVY30vR81NXYB38C6NWRxqhLqXqXStw";

	public function PagarMP($ref, $nome, $valor, $url){
	   
		$mp = new MP($this->client_id, $this->client_secret);
		$valor = (double) $valor;

		$preference_data = array(
			# Dados do produto
			"items" => array(
				array(
					"id"		  => 0001,
					"title"		  => $nome,
					"currency_id" => "BRL",
					"picture_url" => "http://dhweb.com.br/img/bulldog.png",
					"description" => $nome,
					"quantity"    => 1,
					"unit_price"  => $valor
				)

			),
			"back_urls" => array(
				"success" => $url."/notifica.php?success",
				"failure" => $url."/notifica.php?failure",
				"pending" => $url."/notifica.php?pending"
			),
			"notification_url"   => $url."/notifica.php",
			"external_reference" => $ref
			
		);

		$preference = $mp->create_preference($preference_data);

		# Criar link para o botão de pagamento normal ou sandbox
		if($this->sandbox){
			$mp->sandbox_mode(TRUE);
			$link = $preference["response"]["sandbox_init_point"];
		}else{
			$mp->sandbox_mode(FALSE);
			$link = $preference["response"]["init_point"];
		}
        
        $target = null;
        
        

		$this->btn_mp = '<a id="btnMP" href="'.$link.'" target="_blank" name="MP-Checkout">Pagar</a>';
		
		if($this->lightbox){
			$this->btn_mp .='<script type="text/javascript" src="//secure.mlstatic.com/mptools/render.js"></script>';
		}
		return  $this->btn_mp;
	}
    
    public function Retorno($id, $conexao){
        # Id : é o id da fatura que foi enviado na função PagarMP($ref)
        $mp = new MP($this->client_id, $this->cliente_secret);
        # $params = [ $mp->get_access_token()];
        
        $params = array("access_token" =>$mp->get_access_token());
        
        $topic = 'payment';
        
        if($topic == 'payment'){
            $payment_info        = $mp->get("/collections/notifications/".$id, $params, false);
            $merchant_order_info = $mp->get("/merchant_orders/".$payment_info["response"]["collection"]["merchant_order_id"], $params, false);
        }
        
        #STATUS
        
        /**
         * 1 - approved (pagamento aprovado e creditado)
         * 2 - pending (usuário não concluiu o processo de pagamento) 
         * 3 - in_process (pagamento sendo analisado)
         * 4 - rejecte (pagamento foi recusado. O usuário pode tentar novamente)
         * 5 - refunded (pagamento foi devolvido ao usuário)
         * 6 - cancelled (pagamento foi cancelado por uma das partes)
         * 7 - in_mediation (foi iniciada uma disputa para o pagamento)
         * */
        
        switch($payment_info["response"]["collection"]["status"]){
            
            case "approved"     : $status = "Aprovado";  break;
            case "pending"      : $status = "Pendente";  break;
            case "in_process"   : $status = "Análise";   break;
            case "rejected"     : $status = "Rejeitado"; break;
            case "refunded"     : $status = "Devolvido"; break;
            case "cancelled"    : $status = "Cancelado"; break;
            case "in_mediation" : $status = "Mediação";  break;
            
        }
        
        switch($payment_info["response"]["collection"]["payment_type"]){
            case "ticked"        : $forma = "Boleto";  break;
            case "account_money" : $forma = "Saldo Mercado Pago";  break;
            case "credit_card"   : $forma = "Cartão de Crédito";  break;
            default : $forma = $payment_info["response"]["collection"]["payment_type"];
        }
        
        $ref = $payment_info["response"]["collection"]["external_reference"];
        
        $sql = "UPDATE fatura SET status = '$status', forma = '$forma' WHERE ref='$ref' LIMIT 1";
        $res = mysqli_query($conexao, $sql);
        if($res){
            return true;
        }
    }
}
?>