<?php 

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";


//Recebe a variável pela sessao
$query = $_SESSION['queryPrincipal'];


$resultado = mysqli_query($conn, $query) or die("Erro ao retornar dados");

$totalLinhas = mysqli_num_rows($resultado);

if($totalLinhas > 0){

    $delimitador = ";";
    $nomeArquivo = "relatorio_visitantes_" . date('d/m/Y') . ".csv";

    //Ponteiro do arquivo
    $f = fopen('php://memory', 'w');

    //Informação dos campos
    $campos = array ( 
        'Nome Visitante',
        'Tipo Visita', 
        'Tipo Veículo',
        'Placa Veículo', 
        'Quantidade Pessoas no Carro',
        'Casa',
        'Porteiro Entrada', 
        'Data Entrada',
        'Hora Entrada',
        'Porteiro Saída',
        'Data Saída',
        'Hora Saída',
        'Observação Visita'   
    );
    fputcsv($f, $campos, $delimitador);

    while($dados = mysqli_fetch_array($resultado)){

        $dataEntrada = $dados['dt_entrada_visita'];
        $dataSaida = $dados['dt_saida_visita'];
		$dt_entrada_visita = date('d/m/Y', strtotime($dataEntrada));
		$dt_saida_visita = date('d/m/Y', strtotime($dataSaida));

        $linha = array(
            $dados['nm_visitante'],
            $dados['ds_tipo_visita'],
            $dados['ds_tipo_veiculo'],
            $dados['ds_placa_veiculo'],
            $dados['qt_pessoas_carro'],
            $dados['ds_numero_casa'],
            $dados['usuarioEntrada'],
            $dt_entrada_visita,
            $dados['dt_hora_entrada_visita'],
            $dados['usuarioSaida'],
            $dt_saida_visita,
            $dados['dt_hora_saida_visita'],
            $dados['observacao_visita']
        );
        fputcsv($f, $linha, $delimitador);

    }

    //Move para o inicio do arquivo
    fseek($f, 0);

    //Define o header para download do arquivo
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'. $nomeArquivo . '";');

    fpassthru($f);

}
exit;