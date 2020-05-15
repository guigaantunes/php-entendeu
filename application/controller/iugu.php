<?php 

class Iugu
{
    public function inserir_logs($id_cliente, $data, $resposta_curl,$func)
    {   
        /*echo $id_cliente;
        echo $data;
        echo $resposta_curl;*/
        $obj["id"]=$id_cliente;
        $obj["data"]=$data;
        $obj["resposta"]=$resposta_curl;
        $obj["func"]=$func;
    
        $PDO    = new PDO('mysql:host=' . SERVIDOR . ';dbname=' . BANCODEDADOS, USUARIO, SENHA);
        $sql    = "INSERT INTO logs_iugu1 (id_cliente,data,resposta_curl,func) VALUES ($id_cliente, '$data','$resposta_curl','$func')";
        //echo $sql;
        $result = $PDO->query($sql);
        $object =  json_encode($obj);
        if($result === false){
          mail(EMAIL_DEBUG,"Erro:<br>".$object."<br>Erro logs_iugu", "Erro no sql(".$func."):".$PDO->errorInfo());
        }
        return 1;
        
    }
    
    public function ListarClientes()
    {
        $ch      = curl_init(); //inicio curl  
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode(TOKEN_IUGU.":")
        ); //headers, api token para identificação
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //inserindo os headers
        curl_setopt($ch, CURLOPT_URL, 'https://api.iugu.com/v1/customers'); // setando a url da api
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $resultado = curl_exec($ch); // enviando a chamada e colocando em uma variavel
        
        
        if (curl_errno($ch)) {
            
            return 'Erro:' . curl_error($ch);
            
        }
        
        curl_close($ch); // fechando a conexão
        
        $r = json_decode($resultado, true); // tranformando o json em um array
        
        return $r;
    }
    public function Cliente($id)
    {
        
        $classCliente = new Cliente;
        $cliente      = $classCliente->getById($id); //capturando os dados do cliente 
        //var_dump($cliente["iugu"]);
        //echo isset($cliente["iugu"]);
        if (is_null($cliente["iugu"]) || $cliente["iugu"] == "") {
            //echo "é nulo";
            //verificando  se ele ja possui algum numero de cadastro na iugu
            $ch      = curl_init(); //inicio curl  
            $headers = array(
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode(TOKEN_IUGU.":")
            ); //headers, api token para identificação
            //colocando os dados em outra variavel auxiliar
            $clientes["name"]         = $cliente["nome"];
            $clientes["email"]        = $cliente["email"];
            $clientes["notes"]        = "Cliente Entendeu Direito";
            $numerot                  = explode(" ", $cliente["telefone"]); //separar o dd no numero
            $aux                      = str_split($numerot[0]); //transformado em array 
            $clientes["phone_prefix"] = "0" . $aux[1] . $aux[2]; //concantenando apenas os numero sdentro da string 067
            $numerodotelefone         = explode("-", $numerot[1]);
            $clientes["phone"]        = $numerodotelefone[0] . $numerodotelefone[1];
            $soNumeros                = preg_replace("/[^0-9]/", "", $cliente["cpf"]);
            $clientes["cpf_cnpj"]     = $soNumeros;
            $clientes["zip_code"]     = preg_replace("/[^0-9]/", "", $cliente["cep"]);
            $clientes["cc"]           = "";
            $clientes["number"]       = $cliente["numero"];
            if(substr($clientes["zip_code"],-3)=="000"){
                $clientes["district"]   = $cliente["bairro"];
                $clientes["city"]       = $cliente["cidade"];
                $clientes["state"]      = $cliente["uf"];
            }
            
            $obj = json_encode($clientes); // transformando a variavel auxiliar em um obj JSON
            //         var_dump($obj);
            //die();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //inserindo os headers (autenticação)
            curl_setopt($ch, CURLOPT_URL, 'https://api.iugu.com/v1/customers'); //url da api
            curl_setopt($ch, CURLOPT_POSTFIELDS, $obj); //
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $resultado = curl_exec($ch);
            $func="cria cliente";
            $this->inserir_logs($id, $obj, $resultado,$func);
            //var_dump ($resultado);
            $r = json_decode($resultado,true);
            if (array_key_exists("errors", $r)) { //verificando se tem erros
                $r->status = false; //colocano o status como falso
                return $r; //retornando so erros
                die();
            }
            $cliente["iugu"] = $r['id']; //upando o id do cliente da iugu
            $classCliente->update($cliente["id"], $cliente);
            $r['status'] = true;
            //var_dump($resultado);
            return $r;
        } else {
            $ch      = curl_init();
            $headers = array(
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode(TOKEN_IUGU.":")
            ); //headers, api token para identificação
            curl_setopt($ch, CURLOPT_URL, 'https://api.iugu.com/v1/customers/' . $cliente["iugu"]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //inserindo 
            $resultado = curl_exec($ch);
            
            curl_close($ch);
            $r           = json_decode($resultado, true);
            $r['status'] = true;
              //var_dump($r);
            $func="busca cliente";
            $this->inserir_logs($id, $cliente["iugu"], $resultado,$func);
            return $r;
        }
    }
    public function criarboleto($id, $vip)
    {
        /* $id = $dados['id'];
        $vip = $dados['vip'];*/
        $classCliente = new Cliente;
        $cliente      = $classCliente->getById($id);
        $planos        = new Planos;
        $plano = $planos->getById_planos($vip);
        
        $ch = curl_init();
        
        $config_boleto["ignore_due_email"]       = false; //Desabilita o envio de emails notificando o vencimento de uma fatura em assinaturas que podem ser pagas com boleto bancário
        $config_boleto["credits_based"]          = false; //É uma assinatura baseada em créditos? 
        $config_boleto["customer_id"]            = $cliente["iugu"]; //id do cliente na iugu
        $config_boleto["plan_identifier"]        = $plano; //Identificador do Plano. Só é enviado para assinaturas que não são credits_based
        $config_boleto["only_on_charge_success"] = false; //Apenas Cria a Assinatura se a Cobrança for bem sucedida. Isso só funciona caso o cliente já tenha uma forma de pagamento padrão cadastrada. Não enviar "expires_at".
        $config_boleto["payable_with"]           = "bank_slip"; //Método de pagamento que será disponibilizado para as Faturas desta Assinatura (all, credit_card ou bank_slip). Obs: Dependendo do valor, este atributo será herdado, pois a prioridade é herdar o valor atribuído ao Plano desta Assinatura; caso este esteja atribuído o valor ‘all’, o sistema considerará o payable_with da Assinatura; se não, o sistema considerará o payable_with do Plano
        $config_boleto["expires_at"]             = date('d-m-Y'); //Data de Expiração "DD-MM-AAAA". (Data da primeira cobrança, as próximas datas de cobrança dependem do "intervalo" do plano vinculado).
        //, strtotime('+3 days', strtotime(date("d-m-Y")))
        $data                                    = json_encode($config_boleto); //transformando em objeto json
        
        curl_setopt($ch, CURLOPT_URL, 'https://api.iugu.com/v1/subscriptions'); //link api de criação de assinatura
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode(TOKEN_IUGU.":")
        ); //headers, api token para identificação
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $resultado = curl_exec($ch);
        curl_close($ch);
        
        $r = json_decode($resultado, true);
        $r = $r["recent_invoices"][0]['secure_url'];
        //echo $resultado;
      $func="cria boleto";
        $this->inserir_logs($id, $data, $resultado,$func);
        if ($resultado["errors"] === null) { //verificando se tem erros
            $r->status = false; //colocano o status como falso
            return $r; //retornando so erros
            die();
        }
        
        /*if(isset($r)){
        echo 1;
        }
        else{
        echo 0;
        }*/
        
        return $r;
        
    }
    public function temAssinatura($id)
    {
        $classCliente = new Cliente;
        $cliente      = $classCliente->getById($id);
        $ch           = curl_init(); //inicio curl  
        //  var_dump($cliente);
        $headers      = array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode(TOKEN_IUGU.":")
        ); //headers, api token para identificação
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //inserindo os headers
        curl_setopt($ch, CURLOPT_URL, 'https://api.iugu.com/v1/subscriptions?customer_id='.$cliente["iugu"]); // setando a url da api
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $resultado = curl_exec($ch); // enviando a chamada e colocando em uma variavel
        
        
        curl_close($ch); // fechando a conexão
        
        $r = json_decode($resultado, true); // tranformando o json em um array
        //var_dump($r);z
        if ($r["totalItems"] > 1) {
            
            $resp = false;
            
        } elseif ($r["items"][0]["suspend"] == false) {
            
            $resp = $r["items"][0]["plan_identifier"];
            
        } else {
            $resp = false;
        }
        /*echo $id;
        echo $resp;
        echo $resultado;*/
      $func="temassinatura";
         $this->inserir_logs($id,json_encode($resp) , json_encode($resultado),$func);
        //var_dump($resp);
        return $resp;
    }
    public function FormaDePagamento($id, $id_plan, $token)
    {
        
        //echo $token;
        $classCliente            = new Cliente;
        $cliente                 = $classCliente->getById($id);
        $iugu_id                 = $cliente["iugu"];
        //echo 'https://api.iugu.com/v1/'.$iugu_id.'/custumer/payment_methods'; $array["plan_identifier"] = $plano;
        $array["description"]    = "Assinatura do plano: " . $plano;
        $array["token"]          = $token;
        $array["set_as_default"] = true;
        $data                    = json_encode($array);
        /*echo"<pre>";
        var_dump( 'https://api.iugu.com/v1/customers/'.$iugu_id.'/payment_methods');
        echo"<pre>";
        die();*/
        $ch                      = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.iugu.com/v1/customers/' . $iugu_id . '/payment_methods');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode(TOKEN_IUGU.":")
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        //var_dump($result);
        curl_close($ch);
        $r = json_decode($resultado, true);
        //var_dump($r);
        $func="Forma de pagamento";
        $this->inserir_logs($id, $data, $result,$func);
        if (array_key_exists("errors", $result)) {
            return false;
            die();
        }
        
        return true;
    }
    public function CriarAssinaturaCartao($id, $vip)
    {
        $classCliente = new Cliente;
        $cliente      = $classCliente->getById($id);
        $planos        = new Planos;
        $plano = $planos->getById_planos($vip);
        $ch = curl_init();
        
        $config_cartao["ignore_due_email"]       = false; //Desabilita o envio de emails notificando o vencimento de uma fatura em assinaturas que podem ser pagas com boleto bancário
        $config_cartao["credits_based"]          = false; //É uma assinatura baseada em créditos? 
        $config_cartao["customer_id"]            = $cliente["iugu"]; //id do cliente na iugu
        $config_cartao["plan_identifier"]        = $plano; //Identificador do Plano. Só é enviado para assinaturas que não são credits_based
        $config_cartao["only_on_charge_success"] = true; //Apenas Cria a Assinatura se a Cobrança for bem sucedida. Isso só funciona caso o cliente já tenha uma forma de pagamento padrão cadastrada. Não enviar "expires_at".
        $config_cartao["payable_with"]           = "all"; //Método de pagamento que será disponibilizado para as Faturas desta Assinatura (all, credit_card ou bank_slip). Obs: Dependendo do valor, este atributo será herdado, pois a prioridade é herdar o valor atribuído ao Plano desta Assinatura; caso este esteja atribuído o valor ‘all’, o sistema considerará o payable_with da Assinatura; se não, o sistema considerará o payable_with do Plano
        $config_cartao["expires_at"]             = null; //Data de Expiração "DD-MM-AAAA". (Data da primeira cobrança, as próximas datas de cobrança dependem do "intervalo" do plano vinculado).
        
        $data = json_encode($config_cartao); //transformando em objeto json
        //var_dump($data);
        curl_setopt($ch, CURLOPT_URL, 'https://api.iugu.com/v1/subscriptions'); //link api de criação de assinatura
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode(TOKEN_IUGU.":")
        ); //headers, api token para identificação
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $resultado = curl_exec($ch);
        $func="Criaassinaturacartao";
        $this->inserir_logs($id,  $data, $resultado,$func);
        curl_close($ch);
        $r = json_decode($resultado, true);
        //echo $resultado;
        if (array_key_exists("errors", $r)) { //verificando se tem erros
            $r['status'] = false;
            return $r; //retornando so erros
            die();
            
        }
        /*if(isset($r)){
        echo 1;
        }
        else{
        echo 0;
        }*/   
        $r['status'] = true;
        return $r;
    }   
}
?>