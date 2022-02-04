<?php 

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

//Pega o id do usuario logado na sessao
$id_usuarioLogado =  $_SESSION['usuarioID'];
$nm_usuarioLogado = $_SESSION['usuarioNome'];


$id_visita = $_POST["hidIdVisita"];
$txtNomeVisita = trim($_POST["txtNomeVisita"]);
$txtDocumento = trim($_POST["txtDocumento"]);
$cboPlacaVisitante = trim($_POST["cboPlacaVisitante"]);
$cboTipoVisita = $_POST["cboTipoVisita"];
$txtQtdPessoas = $_POST["txtQtdPessoas"];
$cboNumeroDaCasa = $_POST["cboNumeroDaCasa"];
$txtObervacao = $_POST["txtObervacao"];

//Define o timezone para são paulo
date_default_timezone_set('America/Sao_Paulo');

//Captura o valor do ano/mes/dia - Hora/minuto/segundo
$anoMesDia = date("Y-m-d");

//echo $txtQtdPessoas;
//exit();

//Captura Hora/minuto/segundo
$horaMinutoSegundo = date("H:i:s"); 


$mensagem = "";

    //Captura valores do visitante para gravar na tabela de historico
    $sql = "SELECT * FROM tb_visitante WHERE id_visitante = " . $id_visita;
    
    $results = mysqli_query($conn, $sql) or die("Erro ao retornar dados do visitante para salvar na tabela de historico");
    
    while ($dados = mysqli_fetch_array($results)) {

        $nm_visitante = $dados['nm_visitante'];
        $telefone_um_visitante = $dados['telefone_um_visitante'];
        $telefone_dois_visitante = $dados['telefone_dois_visitante'];
    
    }
    
    //Captura valores do tipo visita para gravar na tabela de historico
    $sql = "SELECT * FROM tb_tipo_visita WHERE id_tipo_visita = " . $cboTipoVisita;
    
    $results = mysqli_query($conn, $sql) or die("Erro ao retornar dados do tipo visita para salvar na tabela de historico");
    
    while ($dados = mysqli_fetch_array($results)) {

        $ds_tipo_visita = $dados['ds_tipo_visita'];
      
    }
    
    if ($cboPlacaVisitante != ""){
        //Captura valores do tipo veiculo para gravar na tabela de historico
        $sql = "SELECT * FROM tb_veiculo tvei"
                . " JOIN tb_tipo_veiculo tpv on tpv.id_tipo_veiculo = tvei.fk_tipo_veiculo"
                . " WHERE ds_placa_veiculo = '" . $cboPlacaVisitante . "' AND fk_visitante = " . $id_visita;


        $results = mysqli_query($conn, $sql) or die("Erro ao retornar dados do tipo veiculo para salvar na tabela de historico");

        while ($dados = mysqli_fetch_array($results)) {

            $ds_tipo_veiculo = $dados['ds_tipo_veiculo'];

        }
    }
    
    
    //SQl de inserção dos dados na tabela de historico
    $sqlHst = "INSERT INTO tb_historico_relatorio_visita ("
      . " nm_visitante_hst,"
      . " telefone_um_visitante_hst,"
      . " telefone_dois_visitante_hst,"
      . " ds_placa_veiculo_visitante_hst,"
      . " ds_tipo_veiculo_hst,"
      . " ds_tipo_visita_hst,"
      . " nm_usuario_entrada_hst,"
      . " dt_entrada_visita_hst,"
      . " dt_hora_entrada_visita_hst,"
      . " qt_pessoas_carro_hst,"
      . " ds_casa_visita_hst,"
      . " observacao_visita_hst "
      . ") VALUES ("
      . "'$nm_visitante',"
      . "'$telefone_um_visitante',"
      . "'$telefone_dois_visitante',"
      . "'$cboPlacaVisitante',"
      . "'$ds_tipo_veiculo',"
      . "'$ds_tipo_visita',"
      . "'$nm_usuarioLogado',"
      . "'$anoMesDia',"
      . "'$horaMinutoSegundo',"
      . "'$txtQtdPessoas',"
      . "'$cboNumeroDaCasa',"
      . "'$txtObervacao')";
    
    mysqli_query($conn, $sqlHst) or die("Erro ao salvar dados na tabela de historico");
    
    
    

    $sql = "INSERT INTO tb_visita ("
      . "fk_visitante,"
      . " ds_placa_veiculo_visitante,"
      . " fk_tipo_visita,"
      . " fk_usuario_entrada,"
      . " dt_entrada_visita,"
      . " dt_hora_entrada_visita,"
      . " qt_pessoas_carro,"
      . " ds_casa_visita,"
      . " observacao_visita "
      . ") VALUES ("
      . "'$id_visita',"
      . "'$cboPlacaVisitante',"
      . "'$cboTipoVisita',"
      . "'$id_usuarioLogado',"
      . "'$anoMesDia',"
      . "'$horaMinutoSegundo',"
      . "'$txtQtdPessoas',"
      . "'$cboNumeroDaCasa',"
      . "'$txtObervacao')";
    
     if (!mysqli_query($conn, $sql)) {

      //Mensagem Administrativa
      // $mensagem = "Erro SQL: " . mysqli_error($conn);
      $mensagem = "Erro ao INSERIR VISITA. Contate o Administrador do Sistema";

      $_SESSION['mensagem'] = $mensagem;
      $_SESSION['corMensagem'] = "danger";
      header("Location: visitas_em_andamento.php");
    } else {

      $mensagem = "VISITA cadastrada com sucesso!";

      $_SESSION['mensagem'] = $mensagem;
      $_SESSION['corMensagem'] = "success";
      header("Location: visitas_em_andamento.php");
    };

    
//    echo $sql;


?>