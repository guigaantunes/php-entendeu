<?php 
	class Modulo extends Signoweb {
		var $tabela = 'modulo';
		
		function listar($id_modulo_pai = 0) {
    		
    		$modulos = $this->getBy(
                $dados = array(
                    'listar'        => 1,
                    'id_modulo_pai' => $id_modulo_pai
                ),
                $campos     = array('*'),
                $inner      = false,
                $left       = false,
                $groupBy    = false,
                $having     = false,
                $orderBy    = 'ordem ASC'
    		);
    		
    		return $modulos;
    		
		}
		
/*
		const UsuarioAdmin 		= 1;
		const Nivel 			= 2;
		const Imagem 			= 3;
		const Cliente 			= 4;
		const Pagina 			= 5;
		const Seo 				= 6;
		const Plano 			= 7;
		const Produto 			= 8;
		const Fornecedor 		= 9;
		const ProdutoCategoria 	= 10;
		const PlanoCarreira		= 11;
		const FormasPagamento 	= 12;
		const Frete 	        = 13;
		const Video             = 14;
		const Pedido            = 15;
		const Assinatura        = 16;
		const Relatorio         = 17;
		const Movimentacao      = 18;
		const SolicitarSaque    = 19;
		const ConfigSaque       = 20;
		const Banner            = 21;
				
		const Listar 	= 'listar';
		const Incluir 	= 'incluir';
		const Excluir 	= 'excluir';
		const Alterar 	= 'alterar';
		
		static function havePermission($acao, $idNivel, $idModulo) {
    		return true;
			$sql = 'SELECT * FROM nivelXmodulo WHERE id_nivel = ? AND id_modulo = ?';
			$conexao = new Connection();
			list($permissoes) = $conexao->run($sql, array($idNivel, $idModulo));
			return (bool) $permissoes[$acao];
		}
*/
	}
?>