<?php
    
/**
  *  CASOS DE TESTE
  *  
  *  - 1 Qualificado e não atrasado
  *  - 1 Qualificado e atrasado
  *  - 1 [DESQUALIFICADO] [INATIVO] -> status = 0
  *  - 1 [DESQUALIFICADO] [INATIVO] -> Não efetuou compra mínima
  *  - 1 [DESQUALIFICADO] -> Não possui n indicados diretos [ATIVO]
  *  - 1 [DESQUALIFICADO] -> Possui n indicados diretos, mas nem todos ativos [ATIVO]
  *  - 1 [DESQUALIFICADO] -> Não possui plano mínimo [ATIVO]
  */    
 
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php'; 
    
require_once $_SERVER['DOCUMENT_ROOT']."/config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/classes/func.gerais.custom.php";

require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/Signoweb.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/Cliente.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/ClientePlano.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/Plano.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/Assinatura.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/Produto.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/Pedido.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/ExtratoPontos.php";

require_once $_SERVER['DOCUMENT_ROOT']."/application/controller/CasosTeste.php";

//$faker = Faker\Factory::create('pt_BR');

$Teste = new CasosTeste;

$Cliente = new Cliente;
$Plano = new Plano;
$ClientePlano = new ClientePlano;
$Assinatura = new Assinatura;
$Produto = new Produto;
$Pedido = new Pedido;
 
$opt = $_GET['gerar'];
$parametro_plano = $_GET['plano'];

if (empty($opt)) {
    echo "Use plano=7(bronze) para opc 1-6 -- recomendado usar plano=8 para opc 7<br><br>";
    
    echo "PARAMETRO [gerar=1]: Gerar cliente QUALIFICADO e NÃO ATRASADO<br>";
    echo "PARAMETRO [gerar=2]: Gerar cliente QUALIFICADO e ATRASADO<br>";
    echo "PARAMETRO [gerar=3]: Gerar cliente DESQUALIFICADO [INATIVO] -> status = 0<br>";
    echo "PARAMETRO [gerar=4]: Gerar cliente DESQUALIFICADO [INATIVO] -> sem compra mínima<br>";
    echo "PARAMETRO [gerar=5]: Gerar cliente DESQUALIFICADO [INATIVO] -> não possui n clientes diretos<br>";
    echo "PARAMETRO [gerar=6]: Gerar cliente DESQUALIFICADO [INATIVO] -> clientes diretos não ativos<br>";
    echo "PARAMETRO [gerar=7]: Gerar cliente DESQUALIFICADO [INATIVO] -> clientes diretos sem plano mínimo<br>";
    die();
}

if ($opt == 1) {
    /*
        Gerar cliente QUALIFICADO e NÃO ATRASADO
        
            --Gerar CLIENTE -> vincular codigo_patrocinador com 
                               código de um cliente aleatório
            --Escolher um PLANO aleatório
            --Vincular PLANO e CLIENTE
            --Gerar uma ASSINATURA paga
            --Compra mínima
            --Gerar n CLIENTES para serem diretamente indicados 
            --Cada um dos n clientes: [ATIVO]
                --status = 1
                --Gerar ASSINATURA paga
                --Gerar uma compra com valor mínimo
                --Possuir plano míninimo    
    */
    $planoId = $parametro_plano;
    $cliente = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="QUALIFICADO ATIVO NÃO ATRASADO"));
    
    echo "Gerando cliente<br>";
    
    $plano = $Plano->getById($planoId);
    
    /* Registrar Cliente e plano */
    $idCliente = $Cliente->insert($cliente);
    $ClientePlano->insert(array(
        'id_cliente' => $idCliente, 
        'id_plano' => $planoId
    ));
    echo "Cadastrando cliente e seu plano $planoId<br>";
    echo "Cliente cadastrado: $idCliente<br>";
    
    /* Gerar assinatura paga, se o plano não for gratuito */
    if ($planoId > 1) {
        $assinatura = $Teste->gerarAssinatura($idCliente, $planoId);
        $Assinatura->insert($assinatura);
        echo "Gerando Assinatura paga<br>";
    }
    
    //plano mínimo necessário
    $plano_minimo = $plano['necessita_plano'];
    //minimo indicados diretos plano
    $indicados_diretos = $plano['necessita_clientes_diretos'];
    //valor da compra mínima
    $valor_compra_minima = $plano['compra_minima'];
    
    $plano_minimo_info = $Plano->getById($plano_minimo);
    
    /* Gerar pedido com valor de compra mínima */
    $pedido = $Teste->gerarPedido($idCliente, $valor_compra_minima, $pago = 1, $pontos = FALSE);
    $Pedido->insert($pedido);
    echo "Gerando pedido com valor mínimo, pago<br>";
    
    /* cria n clientes indicados diretos */
    for($i = 0; $i < $indicados_diretos; $i++) {
        
        $clienteIndicado = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="INDICADO DIRETO", $cod_patrocinador=$cliente['login']));
        $idClienteIndicado = $Cliente->insert($clienteIndicado);
        $ClientePlano->insert(array(
            'id_cliente' => $idClienteIndicado, 
            'id_plano' => $plano_minimo
        ));
        echo "Gerando cliente indicado<br>";
        echo "Cliente indicado gerado: $idClienteIndicado<br>";
        
        if ($plano_minimo > 1) {
            $assinaturaIndicado = $Teste->gerarAssinatura($idClienteIndicado, $plano_minimo);
            $Assinatura->insert($assinaturaIndicado);
            echo "Gerando assinatura para cliente indicado<br>";
        }
        
        /* Gerar pedido com valor de compra mínima */
        $pedido = $Teste->gerarPedido($idClienteIndicado, $plano_minimo_info['compra_minima'], $pago = 1, $pontos = FALSE);
        $Pedido->insert($pedido);
        echo "Gerando pedido com valor mínimo, pago, para cliente indicado<br>";
    }
    
    
} 
else if ($opt == 2) {
    define('DIAS_APOS_VENCIMENTO', 10);
    /*
        Gerar cliente QUALIFICADO e ATRASADO
    */
    $planoId = $parametro_plano;
    $cliente = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="QUALIFICADO ATIVO ATRASADO"));
    
    echo "Gerando cliente<br>";
    
    $plano = $Plano->getById($planoId);
    
    /* Registrar Cliente e plano */
    $idCliente = $Cliente->insert($cliente);
    $ClientePlano->insert(array(
        'id_cliente' => $idCliente, 
        'id_plano' => $planoId
    ));
    echo "Cadastrando cliente e seu plano $planoId<br>";
    echo "Cliente cadastrado: $idCliente<br>";
    
    /* Gerar assinatura paga, se o plano não for gratuito */
    if ($planoId > 1) {
        //DIAS_APOS_VENCIMENTO
        $vencimento = (new DateTime)->modify('-'.(DIAS_APOS_VENCIMENTO+1).'days');
        $assinatura = $Teste->gerarAssinatura($idCliente, $planoId, $valor = FALSE, $pago = 0, $data_vencimento = $vencimento->format('Y-m-d'));
        $Assinatura->insert($assinatura);
        echo "Gerando Assinatura atrasada<br>";
    }
    
    //plano mínimo necessário
    $plano_minimo = $plano['necessita_plano'];
    //minimo indicados diretos plano
    $indicados_diretos = $plano['necessita_clientes_diretos'];
    //valor da compra mínima
    $valor_compra_minima = $plano['compra_minima'];
    
    $plano_minimo_info = $Plano->getById($plano_minimo);
    
    /* Gerar pedido com valor de compra mínima */
    $pedido = $Teste->gerarPedido($idCliente, $valor_compra_minima, $pago = 1, $pontos = FALSE);
    $Pedido->insert($pedido);
    echo "Gerando pedido com valor mínimo, pago<br>";
    
    /* cria n clientes indicados diretos */
    for($i = 0; $i < $indicados_diretos; $i++) {
        
        $clienteIndicado = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="INDICADO DIRETO", $cod_patrocinador=$cliente['login']));
        $idClienteIndicado = $Cliente->insert($clienteIndicado);
        $ClientePlano->insert(array(
            'id_cliente' => $idClienteIndicado, 
            'id_plano' => $plano_minimo
        ));
        echo "Gerando cliente indicado<br>";
        echo "Cliente indicado gerado: $idClienteIndicado<br>";
        
        if ($plano_minimo > 1) {
            $assinaturaIndicado = $Teste->gerarAssinatura($idClienteIndicado, $plano_minimo);
            $Assinatura->insert($assinaturaIndicado);
            echo "Gerando assinatura para cliente indicado<br>";
        }
        
        /* Gerar pedido com valor de compra mínima */
        $pedido = $Teste->gerarPedido($idClienteIndicado, $plano_minimo_info['compra_minima'], $pago = 1, $pontos = FALSE);
        $Pedido->insert($pedido);
        echo "Gerando pedido com valor mínimo, pago, para cliente indicado<br>";
    }
     
} 
else if ($opt == 3) {  
    /*
        Gerar cliente DESQUALIFICADO -> INATIVO [status = 0]
    */
    
    $planoId = $parametro_plano;
    $cliente = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="DESQUALIFICADO INATIVO STAUTS 0", $cod_patrocinador = FALSE, $status = 0));
    
    echo "Gerando cliente com status 0<br>";
    
    $plano = $Plano->getById($planoId);
    
    /* Registrar Cliente e plano */
    $idCliente = $Cliente->insert($cliente);
    $ClientePlano->insert(array(
        'id_cliente' => $idCliente, 
        'id_plano' => $planoId
    ));
    echo "Cadastrando cliente e seu plano $planoId<br>";
    echo "Cliente cadastrado: $idCliente<br>";
    
    /* Gerar assinatura paga, se o plano não for gratuito */
    if ($planoId > 1) {
        $assinatura = $Teste->gerarAssinatura($idCliente, $planoId);
        $Assinatura->insert($assinatura);
        echo "Gerando Assinatura paga<br>";
    }
    
    //plano mínimo necessário
    $plano_minimo = $plano['necessita_plano'];
    //minimo indicados diretos plano
    $indicados_diretos = $plano['necessita_clientes_diretos'];
    //valor da compra mínima
    $valor_compra_minima = $plano['compra_minima'];
    
    $plano_minimo_info = $Plano->getById($plano_minimo);
    
    /* Gerar pedido com valor de compra mínima */
    $pedido = $Teste->gerarPedido($idCliente, $valor_compra_minima, $pago = 1, $pontos = FALSE);
    $Pedido->insert($pedido);
    echo "Gerando pedido com valor mínimo, pago<br>";
    
    /* cria n clientes indicados diretos */
    for($i = 0; $i < $indicados_diretos; $i++) {
        
        $clienteIndicado = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="INDICADO DIRETO", $cod_patrocinador=$cliente['login']));
        $idClienteIndicado = $Cliente->insert($clienteIndicado);
        $ClientePlano->insert(array(
            'id_cliente' => $idClienteIndicado, 
            'id_plano' => $plano_minimo
        ));
        echo "Gerando cliente indicado<br>";
        echo "Cliente indicado gerado: $idClienteIndicado<br>";
        
        if ($plano_minimo > 1) {
            $assinaturaIndicado = $Teste->gerarAssinatura($idClienteIndicado, $plano_minimo);
            $Assinatura->insert($assinaturaIndicado);
            echo "Gerando assinatura para cliente indicado<br>";
        }
        
        /* Gerar pedido com valor de compra mínima */
        $pedido = $Teste->gerarPedido($idClienteIndicado, $plano_minimo_info['compra_minima'], $pago = 1, $pontos = FALSE);
        $Pedido->insert($pedido);
        echo "Gerando pedido com valor mínimo, pago, para cliente indicado<br>";
    }
    
    
}
else if ($opt == 4) {
    
    /*
        Gerar cliente DESQUALIFICADO -> INATIVO [não fez compra mínima]
    */
    
    $planoId = $parametro_plano;
    $cliente = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="DESQUALIFICADO INATIVO SEM_COMPRA_MINIMA", $cod_patrocinador = FALSE, $status = 1));
    
    echo "Gerando cliente<br>";
    
    $plano = $Plano->getById($planoId);
    
    /* Registrar Cliente e plano */
    $idCliente = $Cliente->insert($cliente);
    $ClientePlano->insert(array(
        'id_cliente' => $idCliente, 
        'id_plano' => $planoId
    ));
    echo "Cadastrando cliente e seu plano $planoId<br>";
    echo "Cliente cadastrado: $idCliente<br>";
    
    /* Gerar assinatura paga, se o plano não for gratuito */
    if ($planoId > 1) {
        $assinatura = $Teste->gerarAssinatura($idCliente, $planoId);
        $Assinatura->insert($assinatura);
        echo "Gerando Assinatura paga<br>";
    }
    
    //plano mínimo necessário
    $plano_minimo = $plano['necessita_plano'];
    //minimo indicados diretos plano
    $indicados_diretos = $plano['necessita_clientes_diretos'];
    //valor da compra mínima
    $valor_compra_minima = $plano['compra_minima'];
    
    $plano_minimo_info = $Plano->getById($plano_minimo);
    
    /* Gerar pedido com valor de compra mínima */
    $pedido = $Teste->gerarPedido($idCliente, $valor_compra_minima, $pago = 1, $pontos = FALSE);
    //$Pedido->insert($pedido);
    echo "Não gerar pedido algum...<br>";
    
    /* cria n clientes indicados diretos */
    for($i = 0; $i < $indicados_diretos; $i++) {
        
        $clienteIndicado = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="INDICADO DIRETO", $cod_patrocinador=$cliente['login']));
        $idClienteIndicado = $Cliente->insert($clienteIndicado);
        $ClientePlano->insert(array(
            'id_cliente' => $idClienteIndicado, 
            'id_plano' => $plano_minimo
        ));
        echo "Gerando cliente indicado<br>";
        echo "Cliente indicado gerado: $idClienteIndicado<br>";
        
        if ($plano_minimo > 1) {
            $assinaturaIndicado = $Teste->gerarAssinatura($idClienteIndicado, $plano_minimo);
            $Assinatura->insert($assinaturaIndicado);
            echo "Gerando assinatura para cliente indicado<br>";
        }
        
        /* Gerar pedido com valor de compra mínima */
        $pedido = $Teste->gerarPedido($idClienteIndicado, $plano_minimo_info['compra_minima'], $pago = 1, $pontos = FALSE);
        $Pedido->insert($pedido);
        echo "Gerando pedido com valor mínimo, pago, para cliente indicado<br>";
    }
    
    
    
}
else if ($opt == 5) {
    
    /*
        Gerar cliente DESQUALIFICADO -> ATIVO [não possui n indicados diretos]
    */
    
    $planoId = $parametro_plano;
    $cliente = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="DESQUALIFICADO ATIVO MENOS_INDICADOS_DIRETOS", $cod_patrocinador = FALSE, $status = 1));
    
    echo "Gerando cliente<br>";
    
    $plano = $Plano->getById($planoId);
    
    /* Registrar Cliente e plano */
    $idCliente = $Cliente->insert($cliente);
    $ClientePlano->insert(array(
        'id_cliente' => $idCliente, 
        'id_plano' => $planoId
    ));
    echo "Cadastrando cliente e seu plano $planoId<br>";
    echo "Cliente cadastrado: $idCliente<br>";
    
    /* Gerar assinatura paga, se o plano não for gratuito */
    if ($planoId > 1) {
        $assinatura = $Teste->gerarAssinatura($idCliente, $planoId);
        $Assinatura->insert($assinatura);
        echo "Gerando Assinatura paga<br>";
    }
    
    //plano mínimo necessário
    $plano_minimo = $plano['necessita_plano'];
    //minimo indicados diretos plano
    $indicados_diretos = $plano['necessita_clientes_diretos'];
    //valor da compra mínima
    $valor_compra_minima = $plano['compra_minima'];
    
    $plano_minimo_info = $Plano->getById($plano_minimo);
    
    /* Gerar pedido com valor de compra mínima */
    $pedido = $Teste->gerarPedido($idCliente, $valor_compra_minima, $pago = 1, $pontos = FALSE);
    $Pedido->insert($pedido);
    echo "Gerando pedido com valor mínimo<br>";
    
    echo "Gerando menos clientes indicados que o necessário - Necessário: $indicados_diretos; Gerados: ".($indicados_diretos-1)."<br>";
    /* cria n clientes indicados diretos */
    for($i = 0; $i < $indicados_diretos - 1 /* - 1 propositalmente (para não ter a qtde necessária)*/; $i++) {
        
        $clienteIndicado = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="INDICADO DIRETO", $cod_patrocinador=$cliente['login']));
        $idClienteIndicado = $Cliente->insert($clienteIndicado);
        $ClientePlano->insert(array(
            'id_cliente' => $idClienteIndicado, 
            'id_plano' => $plano_minimo
        ));
        echo "Gerando cliente indicado<br>";
        echo "Cliente indicado gerado: $idClienteIndicado<br>";
        
        if ($plano_minimo > 1) {
            $assinaturaIndicado = $Teste->gerarAssinatura($idClienteIndicado, $plano_minimo);
            $Assinatura->insert($assinaturaIndicado);
            echo "Gerando assinatura para cliente indicado<br>";
        }
        
        /* Gerar pedido com valor de compra mínima */
        $pedido = $Teste->gerarPedido($idClienteIndicado, $plano_minimo_info['compra_minima'], $pago = 1, $pontos = FALSE);
        $Pedido->insert($pedido);
        echo "Gerando pedido com valor mínimo, pago, para cliente indicado<br>";
    }
    
}
else if ($opt == 6) {
    
    /*
        Gerar cliente DESQUALIFICADO -> ATIVO [indicados diretos não ativos]
    */
    
    $planoId = $parametro_plano;
    $cliente = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="DESQUALIFICADO ATIVO INDICADOS_INATIVOS", $cod_patrocinador = FALSE, $status = 1));
    
    echo "Gerando cliente<br>";
    
    $plano = $Plano->getById($planoId);
    
    /* Registrar Cliente e plano */
    $idCliente = $Cliente->insert($cliente);
    $ClientePlano->insert(array(
        'id_cliente' => $idCliente, 
        'id_plano' => $planoId
    ));
    echo "Cadastrando cliente e seu plano $planoId<br>";
    echo "Cliente cadastrado: $idCliente<br>";
    
    /* Gerar assinatura paga, se o plano não for gratuito */
    if ($planoId > 1) {
        $assinatura = $Teste->gerarAssinatura($idCliente, $planoId);
        $Assinatura->insert($assinatura);
        echo "Gerando Assinatura paga<br>";
    }
    
    //plano mínimo necessário
    $plano_minimo = $plano['necessita_plano'];
    //minimo indicados diretos plano
    $indicados_diretos = $plano['necessita_clientes_diretos'];
    //valor da compra mínima
    $valor_compra_minima = $plano['compra_minima'];
    
    $plano_minimo_info = $Plano->getById($plano_minimo);
    
    /* Gerar pedido com valor de compra mínima */
    $pedido = $Teste->gerarPedido($idCliente, $valor_compra_minima, $pago = 1, $pontos = FALSE);
    $Pedido->insert($pedido);
    echo "Gerando pedido com valor mínimo<br>";
    
    echo "Gerando clientes indicados <br>";
    /* cria n clientes indicados diretos */
    for($i = 0; $i < $indicados_diretos; $i++) {
        
        $clienteIndicado = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="INDICADO DIRETO INATIVO", $cod_patrocinador=$cliente['login']));
        $idClienteIndicado = $Cliente->insert($clienteIndicado);
        $ClientePlano->insert(array(
            'id_cliente' => $idClienteIndicado, 
            'id_plano' => $plano_minimo
        ));
        echo "Gerando cliente indicado<br>";
        echo "Cliente indicado gerado: $idClienteIndicado<br>";
        
        if ($plano_minimo > 1) {
            $assinaturaIndicado = $Teste->gerarAssinatura($idClienteIndicado, $plano_minimo);
            $Assinatura->insert($assinaturaIndicado);
            echo "Gerando assinatura para cliente indicado<br>";
        }
        
        /* Gerar pedido com valor de compra mínima */
        $pedido = $Teste->gerarPedido($idClienteIndicado, $plano_minimo_info['compra_minima'], $pago = 1, $pontos = FALSE);
        //$Pedido->insert($pedido);
        echo "NÃO Gerando pedido com valor mínimo, para cliente indicado<br>";
    }
    
}
else if ($opt == 7) {
    
    /*
        Gerar cliente DESQUALIFICADO -> ATIVO [indicados diretos não ativos]
    */
    
    $planoId = $parametro_plano;
    $cliente = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="DESQUALIFICADO ATIVO INDICADOS_SEM_PLANO_MINIMO", $cod_patrocinador = FALSE, $status = 1));
    
    echo "Gerando cliente<br>";
    
    $plano = $Plano->getById($planoId);
    
    /* Registrar Cliente e plano */
    $idCliente = $Cliente->insert($cliente);
    $ClientePlano->insert(array(
        'id_cliente' => $idCliente, 
        'id_plano' => $planoId
    ));
    echo "Cadastrando cliente e seu plano $planoId<br>";
    echo "Cliente cadastrado: $idCliente<br>";
    
    /* Gerar assinatura paga, se o plano não for gratuito */
    if ($planoId > 1) {
        $assinatura = $Teste->gerarAssinatura($idCliente, $planoId);
        $Assinatura->insert($assinatura);
        echo "Gerando Assinatura paga<br>";
    }
    
    //plano mínimo necessário
    $plano_minimo = $plano['necessita_plano'];
    //minimo indicados diretos plano
    $indicados_diretos = $plano['necessita_clientes_diretos'];
    //valor da compra mínima
    $valor_compra_minima = $plano['compra_minima'];
    
    $plano_minimo_info = $Plano->getById($plano_minimo);
    
    /* Gerar pedido com valor de compra mínima */
    $pedido = $Teste->gerarPedido($idCliente, $valor_compra_minima, $pago = 1, $pontos = FALSE);
    $Pedido->insert($pedido);
    echo "Gerando pedido com valor mínimo<br>";
    
    echo "Gerando clientes indicados com plano abaixo do mínimo necessário<br>";
    /* cria n clientes indicados diretos */
    for($i = 0; $i < $indicados_diretos; $i++) {
        
        $clienteIndicado = end($Teste->gerarCliente($qtde = 1, $sufixo_nome="INDICADO DIRETO", $cod_patrocinador=$cliente['login']));
        $idClienteIndicado = $Cliente->insert($clienteIndicado);
        $ClientePlano->insert(array(
            'id_cliente' => $idClienteIndicado, 
            'id_plano' => 1 /* plano 1 - para ser qualificado, deveria ser maior*/
        ));
        echo "Gerando cliente indicado<br>";
        echo "Cliente indicado gerado: $idClienteIndicado<br>";
        
        /*
if ($plano_minimo > 1) {
            $assinaturaIndicado = $Teste->gerarAssinatura($idClienteIndicado, $plano_minimo);
            $Assinatura->insert($assinaturaIndicado);
            echo "Gerando assinatura para cliente indicado<br>";
        }
*/
        
        /* Gerar pedido com valor de compra mínima */
        $pedido = $Teste->gerarPedido($idClienteIndicado, $plano_minimo_info['compra_minima'], $pago = 1, $pontos = FALSE);
        $Pedido->insert($pedido);
        echo "Gerando pedido com valor mínimo, pago, para cliente indicado<br>";
    }
    
    
}


