<?php
class Html {
	
	public function grupoTabela($dados, $faseGrupos, $datas, $meuGrupo, $equipe = true) {
		$metade = ($faseGrupos) ? "l6" : "";
		$groupColor = ($meuGrupo) ? "green" : "blue";
		if ($equipe) {
			if ($faseGrupos) {
				$subTitle = ($meuGrupo) ? "<i>Sua equipe está neste grupo.</i>" : "";
			} else {
				$subTitle = ($meuGrupo) ? "<i>Sua equipe está na fase final.</i>" : "";
			}
		} else {
			if ($faseGrupos) {
				$subTitle = ($meuGrupo) ? "<i>Você está neste grupo.</i>" : "";
			} else {
				$subTitle = ($meuGrupo) ? "<i>Você está na fase final.</i>" : "";
			}
		}
		
		return '<div class="col s12 '.$metade.'">
					<div class="group">
						<div class="title '.$groupColor.' base white-text">
							<span class="uppercase spaced"><b>'.$dados["nome"].'</b></span>
							'.$subTitle.'
						</div>
						<div class="content dark base">
							<div class="row">
								<div class="col s12">
									<table class="bordered highlight">
										<tbody>'.$jogos.'</tbody>
									</table>
								</div>
							</div>
							<div class="row no-margin">
								<div class="col s12">
									<a href="'.URL_SITE.'components/templates-layout/modal-membros-grupo/modal-membros-grupo.php?id='.$dados["id"].'&idCampeonato='.$dados["id_campeonato"].'" class="ajax-popup-link btn uppercase outline gradient-'.$groupColor.' spaced fullwidth">Ver '.($equipe ? 'equipes' : 'jogadores').' do grupo</a>
								</div>
							</div>
						</div>
					</div>
				</div>';
	}	
	
	static function componentMember($jogador, $isDono, $type, $idEquipe, $idSubequipe) {
		if (empty($jogador)) {
			if ($isDono) {
				return '<li class="empty">
							<a href="'.URL_SITE.'components/templates-layout/modal-add-membro-equipe/modal-add-membro-equipe.php?tp='.$type.'&id='.$idEquipe.'&idsubequipe='.$idSubequipe.'" class="ajax-popup-link infos-member">
								<div class="flex-row">
									<span class="spaced uppercase"><b>Selecionar membro para esta posição</b></span>
								</div>
							</a>
						</li>';
			} else {
				return '';
			}
		}
		
		$isCaptain = (bool)($jogador['capitao']);
		$checkCaptain = $isCaptain ? 'checked="checked"' : '';
		$owner = ($jogador['dono']) ? '<li class="owner tooltipped" data-position="bottom" data-tooltip="Dono"><i class="green">D</i></li>' : '';
		$captain = $isCaptain ? '<li class="captain tooltipped" data-position="bottom" data-tooltip="Capitão"><i class="yellow">C</i></li>' : '';
		
		if ($isDono) {
			$editTeam = '	<a href="javascript:void(0)" class="options-button"><i class="icon-settings"></i></a>
							<div class="options-member">
								<div class="button-option captain">
									<label onclick="$.ajax({url:\'/ajax/equipe-mudar-capitao.php\', data: {equipe: '.$idSubequipe.', jogador: '.$jogador['id'].'}, type: \'post\', dataType: \'json\', success: retornoDefault}); return false;">
										<input type="checkbox" name="captain-sub-team-1" value="1" '. $checkCaptain .' />
										<span class="yellow-text">Capitão</span>
									</label>
								</div>
								<div class="button-option kick-position" onclick="$.ajax({url:\'/ajax/equipe-kickar-membro.php\', data: {equipe: '.$idSubequipe.', jogador: '.$jogador['id'].'}, type: \'post\', dataType: \'json\', success: retornoDefault})">
									<a href="#" class="red-text text-lighten-1"><i class="icon-minus"></i>Kickar da posição</a>
								</div>
							</div>';
		}
		
		return '<li>
					<a href="'.URL_SITE.'perfil/'.$jogador['id'].'" class="infos-member">
						<div class="flex-row">
							<span class="name">'.$jogador['nome'].'</span>
							<ul class="stats">
								'.$owner.'
								'.$captain.'
								<li class="points tooltipped" data-position="bottom" data-tooltip="Pontos"><i class="teal">P</i><label class="teal-text">'.'--'.'</label></li>
							</ul>
						</div>
						<div class="flex-row">
							<span class="position">Posição: '.$jogador['posicao'].'</span>
							<span class="member-since">Membro desde: '.$jogador['data'].'</span>
						</div>
					</a>
					'.$editTeam.'
				</li>';
	}
	
}	
?>