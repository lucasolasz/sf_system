<?php
session_start();


//Define o timezone
date_default_timezone_set('America/Sao_Paulo');

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_usuarioLogado =  $_SESSION['usuarioID'];
$nm_usuarioLogado = $_SESSION['usuarioNome'];

if (isset($_POST["hidIdVisita"])){
    $id_visita = $_POST["hidIdVisita"];
}

//Verifica se o usuario está logado
if (!isset($_SESSION['usuarioUsuario'])) {
    header("Location: index.php");
}

if (isset($_SESSION['corMensagem'])) {
    $corMensagem = $_SESSION['corMensagem'];
}

//Atualiza a página a cada 45seg com o intuito de atualizar o tempo de visita (automaticamente)
header("Refresh:45");

//header("Refresh:900; /sair.php");

?>

<!DOCTYPE html>
<html lang="pt-br">

    <?php require_once $_SESSION['caminhopadrao'] . "header.php"; ?>

    <body>

        <?php require_once $_SESSION['caminhopadrao'] . "nav.php"; ?>

        <div class="container" id="containeralert"> </div>

        <br>

        <div class="container">
            <div class="alert alert-<?php echo $corMensagem; ?> text-center" role="alert">
                <?php
                if (isset($_SESSION['mensagem'])) {
                    echo $_SESSION['mensagem'];
                    unset(
                            $_SESSION['mensagem'],
                            $_SESSION['corMensagem']
                    );
                }
                ?>
            </div>
        </div>

        <div class="container">
            <h2>Visitas em andamento</h2>
            <button type="button" class="btn btn-success btn-sm" name="btnAdicionarVisita" id="btnAdicionarVisita" onClick="">
                <img src="../../../bootstrap-icons/plus-circle-fill.svg" alt="" height="30px" width="30px"> Registrar Nova Visita&nbsp;
            </button>
        </div>

        <br>

        <form name="form_sf_system" id="form_sf_system" method="POST">

            <input type="hidden" name="hidIdVisita" id="hidIdVisita" value="">
            <input type="hidden" name="hidIdOperacaoSaida" id="hidIdOperacaoSaida" value="">

            <div class="container">
                <table class="table table-success table-striped" id="tableVisitaEmAndamento">
                    <thead>
                        <tr>
                            <th>Nome Visitante</th>
                            <th>Tipo Visita</th>
                            <th>Data de Entrada</th>
                            <th>Hora de Entrada</th>              
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM tb_visita tvsta";
                        $sql .= " LEFT JOIN tb_visitante tvst ON tvst.id_visitante = tvsta.fk_visitante";
                        $sql .= " LEFT JOIN tb_tipo_visita tip ON tip.id_tipo_visita = tvsta.fk_tipo_visita";
                        $sql .= " LEFT JOIN tb_usuario tus ON tus.id_usuario = tvsta.fk_usuario_entrada";
                        $sql .= " LEFT JOIN tb_veiculo tvei ON tvei.id_veiculo = tvsta.fk_veiculo";
                        $sql .= " LEFT JOIN tb_tipo_veiculo tpvei ON tpvei.id_tipo_veiculo = tvei.fk_tipo_veiculo";
                        $sql .= " LEFT JOIN tb_casa tcas ON tcas.id_casa = tvsta.fk_casa";
                        $sql .= " WHERE dt_saida_visita IS NULL";
                        $sql .= " ORDER BY dt_entrada_visita asc, dt_hora_entrada_visita asc";

                        $resultsVisita = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

                        $rowcountVisita = mysqli_num_rows($resultsVisita);

                        if ($rowcountVisita > 0) {
                            while ($dados = mysqli_fetch_array($resultsVisita)) {

                                $id_visita = $dados['id_visita'];
                                $nm_visitante = $dados['nm_visitante'];
                                $ds_tipo_visita = $dados['ds_tipo_visita'];
                                $dt_hora_entrada_visita = $dados['dt_hora_entrada_visita'];
                                $ds_numero_casa = $dados['ds_numero_casa'];
                                //Precisa-se formatar a data do padrao americano para o br
                                $data = $dados['dt_entrada_visita'];
                                $dt_entrada_visita = date('d/m/Y', strtotime($data));
                                $obs_visita = $dados['observacao_visita'];
                                $ds_placa_veiculo = $dados['ds_placa_veiculo'];
                                $ds_nome_usuario = $dados['ds_nome_usuario'];
                                $ds_tipo_veiculo = $dados['ds_tipo_veiculo'];
                                    
                                
                                //Captura dos valores para o calculo do tempo decorrido
                                $dataEntrada = $data;
                                $dataAgora = date("y.m.d H:i:s");
                                
                                                               
                                //Calculo do tempo decorrido da visita 
                                $entrada = new DateTime($dataEntrada . $dt_hora_entrada_visita);
                                $saida = new DateTime('now');
                                $intervalo = $saida->diff($entrada);

                                ?>        
                                <tr>
                                    <td><?php echo $nm_visitante ?></td>
                                    <td><?php echo $ds_tipo_visita ?></td>
                                    <td><?php echo $dt_entrada_visita ?></td>
                                    <td><?php echo $dt_hora_entrada_visita ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalInformacoes<?php echo $id_visita ?>">
                                            <img src="../../../bootstrap-icons/exclamation-diamond.svg" alt=""> Informações&nbsp;
                                        </button>

                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalSaida<?php echo $id_visita ?>">
                                            <img src="../../../bootstrap-icons/arrow-up-square.svg" alt=""> Registra Saida&nbsp;
                                        </button>
                                    </td>
                                </tr>
                                <!-- Modal de informações-->
                                <div class="modal fade" id="modalInformacoes<?php echo $id_visita ?>" tabindex="-1" aria-labelledby="modalInformacoesLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalInformacoesLabel">Informações da Visita: <b><?php echo $nm_visitante ?></b></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h6>Observações:</h6>
                                                
                                                <?php if($obs_visita != "") { ?>
                                                    <p><?php echo $obs_visita ?></p>
                                                <?php }else { ?>
                                                    <p><i>Nenhuma observação</i></p>
                                               <?php } ?>

                                                <h6>Tempo de visita:</h6>
                                                <p>
                                                    <?php
                                                    if ($intervalo->m > 0){
                                                        echo $intervalo->m . " Meses " . $intervalo->d . " Dias " . $intervalo->h . " Horas " . $intervalo->i . " Minutos";
                                                    } else {
                                                        echo $intervalo->d . " Dias " . $intervalo->h . " Horas " . $intervalo->i . " Minutos";
                                                    }
                                                    ?>
                                                </p>

                                                <h6>Tipo Veículo - Placa veículo:</h6>
                                                
                                                <?php if($ds_tipo_veiculo != "") { ?>
                                                    <p><?php echo $ds_tipo_veiculo . " - " . strtoupper($ds_placa_veiculo)?></p>
                                                <?php }else { ?>
                                                    <p><i>Visitante sem placa escolhida</i></p>
                                               <?php } ?>
                                                
                                                <h6>Casa destino:</h6>
                                                <p><?php echo $ds_numero_casa ?></p>

                                                <h6>Entrada dada pelo porteiro(a):</h6>
                                                <p><?php echo $ds_nome_usuario ?></p>

                                            </div>
                                            <div class = "modal-footer">
                                                <button type = "button" class = "btn btn-secondary" data-bs-dismiss = "modal">Fechar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal de informações-->
                                <div class="modal fade" id="modalSaida<?php echo $id_visita ?>" tabindex="-1" aria-labelledby="modalSaidaLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalSaidaLabel">Confirmação saída visita</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                
                                               <h6>Confirma saída da visita: <b><?php echo $nm_visitante ?></b></h6> 
                                            </div>
                                            <div class = "modal-footer">
                                                <button type = "button" class = "btn btn-secondary" data-bs-dismiss = "modal">Fechar</button>
                                                <button type="button" class="btn btn-primary" onClick="registraSaida(<?php echo $id_visita ?>)">Confirma</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: center">Nenhuma visita em andamento</td>
                        </tr>

                    <?php } ?>  

                    </tbody>
                </table>
            </div>
        </form>

        <script>


            function registraSaida(id_visita) {

                $("#hidIdVisita").val(id_visita);
                $("#hidIdOperacaoSaida").val(true);
                var form = document.getElementById("form_sf_system");
                form.action = "delete_visita_em_andamento.php";
                form.submit();

            }
            


            $("#btnAdicionarVisita").click(function () {

                var form = document.getElementById("form_sf_system");
                form.action = "/consulta/cadastro/visitante/cad_visitante.php";
                form.submit();

            });

        </script>

    </body>

</html>