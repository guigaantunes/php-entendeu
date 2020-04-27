<?php
    
    session_start();
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.banco.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/func.gerais.custom.php';
    require_once $_SERVER['DOCUMENT_ROOT']."/classes/Resposta.php";
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/application/controller/Signoweb.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/application/controller/Arquivo.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/application/controller/PagSeguroRecorrencia.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/application/controller/Plano.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/application/controller/Fatura.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/application/controller/Assinatura.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/application/controller/Cliente.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/application/controller/MaterialEstudo.php';
    
        
    use setasign\FpdiProtection\FpdiProtection;
    require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
     
    $classResposta  = new Resposta;
    $classArquivo   = new Arquivo;
    $classAssinatura= new Assinatura;
    $classCliente   = new Cliente;
    $classMaterialEstudo = new MaterialEstudo; 
    
    /* Verificar se cliente está logado e tem plano ativo 
    
    $logado             = isset($_SESSION['cliente']['id']);
    $temAssinatura      = $classAssinatura->temAssinatura();
    $assianturaAtiva    = $classAssinatura->assinaturaAtiva();*/
    
    /*if (!$logado) {
        $classResposta->insert('Deve estar logado para ter acesso aos conteúdos.', Resposta::ERROR);
        $classResposta->setStatus(false);
        die();
    }
    
    if (!$temAssinatura || !$assianturaAtiva) {
        $classResposta->insert('Você não tem uma assinatura ativa.', Resposta::ERROR);
        $classResposta->setStatus(false);
        die();
    }*/
    
    $cliente = $classCliente->getById($_SESSION['cliente']['id']);
    
    
    $sql = "
    SELECT * 
    FROM arquivo
    WHERE id = {$_GET["file_id"]} "	;
    $arquivo = $classArquivo->run($sql, array());
    $arquivo =  $arquivo[0];
    $url = $_SERVER['DOCUMENT_ROOT']."/assets/dinamicos/materialestudo/$arquivo[id_referencia]/arquivo/$arquivo[id]$arquivo[arquivo]";

    $files = [
        $url,
    ];
    $pdf = new FpdiProtection();
    //$ownerPassword = $pdf->setProtection([FpdiProtection::PERM_PRINT], 'a', null, 3);
    //var_dump($ownerPassword);
    
    $fixedString = "Documento gerado exclusivamente para $cliente[nome] | CPF: $cliente[cpf]";
    foreach ($files as $file) {
        $pageCount = $pdf->setSourceFile($file);//TODO o erro do arquivo está por aqui. 
       
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $id = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($id);
            
            $pdf->SetAutoPageBreak(false);
            $pdf->AddPage($size['orientation'], $size);
            $pdf->useTemplate($id);
            $pdf->SetFont('Arial','I',8);
            $pdf->setY(-10);
            $pdf->Cell(0, 10, $fixedString, 0, 0, 'C');
        }
    }
    

	$conteudo = $classMaterialEstudo->getById($arquivo[id_referencia]);    
	$conteudo = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $conteudo['titulo'])));
    $pdf->Output('D', $conteudo.".pdf");