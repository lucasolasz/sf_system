<?php 

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

//Pega o id do usuario logado na sessao
$id_usuarioLogado =  $_SESSION['usuarioID'];
$nm_usuarioLogado = $_SESSION['usuarioNome'];


$id_visita = $_POST["hidIdVisita"];
$cboPlacaVisitante = $_POST["cboPlacaVisitante"];
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


    $sql = "INSERT INTO tb_visita ("
      . "fk_visitante,"
      . " fk_veiculo,"
      . " fk_tipo_visita,"
      . " fk_usuario_entrada,"
      . " dt_entrada_visita,"
      . " dt_hora_entrada_visita,"
      . " qt_pessoas_carro,"
      . " fk_casa,"
      . " observacao_visita "
      . ") VALUES ("
      . "$id_visita,"
      . "$cboPlacaVisitante,"
      . "$cboTipoVisita,"
      . "$id_usuarioLogado,"
      . "'$anoMesDia',"
      . "'$horaMinutoSegundo',"
      . "'$txtQtdPessoas',"
      . "$cboNumeroDaCasa,"
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


?>