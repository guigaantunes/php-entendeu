$(document).ready(init);

function init() {
    updateTableParticipantes();
    updateTableLances();

    setInterval(updateTableParticipantes, 3000);
    setInterval(updateTableLances, 3000);
}

function updateTableLances() {
    
    const   $tableLances = $('table.table-lances');

    /* Update allotment content */
	$.ajax({
        method: "GET",
        url:    '/admin/public/ajax/atualiza.tabela.lances.php',
        success: function(data) {
            let jsonData = JSON.parse(data);

            if (!jsonData || !jsonData.data) return;
            let content = jsonData.data;

            /* Remove rows from table */
            $tableLances.find('tbody tr').remove();

            /* Add rows to table */
            for(var i in content) {
                $tableLances.find('tbody').append(
                    `<tr>
                        <td>${content[i].titulo_leilao}</td>
                        <td>${content[i].titulo_lote}</td>
                        <td>${content[i].participante}</td>
                        <td>R$ ${content[i].valor_formatado}</td>
                        <td>${content[i].data_cadastro_formatada}</td>
                    </tr>`
                );
            }
        }
    });

}

function updateTableParticipantes() {
    
    const   $tableParticipantes = $('table.table-participantes');

    /* Update allotment content */
	$.ajax({
        method: "GET",
        url:    '/admin/public/ajax/atualiza.tabela.participantes.php',
        success: function(data) {
            let jsonData = JSON.parse(data);

            if (!jsonData || !jsonData.data) return;
            let content = jsonData.data;

            /* Remove rows from table */
            $tableParticipantes.find('tbody tr').remove();

            /* Add rows to table */
            for(var i in content) {
                $tableParticipantes.find('tbody').append(
                    `<tr>
                        <td>${content[i].nome}</td>
                        <td>${content[i].data_cadastro_formatada}</td>
                        <td>${content[i].status_texto}</td>
                    </tr>`
                );
            }
        }
    });

}