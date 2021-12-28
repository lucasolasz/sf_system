<?php
session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_visitante = $_POST["hidIdVisitante"];

// echo $id_visitante;
//exit();


$sql = "SELECT * FROM tb_visitante";
$sql .= " WHERE id_visitante = " . $id_visitante;

// echo $sql;
// exit();
$resultsVisitante = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

while ($dados = mysqli_fetch_array($resultsVisitante)) {


    $nm_visitante = $dados['nm_visitante'];
    $documento_visitante = $dados['documento_visitante'];
    $telefone_um_visitante = $dados['telefone_um_visitante'];
    $telefone_dois_visitante = $dados['telefone_dois_visitante'];
    
   
    
    $titulo_tela = "Nova visita";
    
    
}
?>


<!DOCTYPE html>
<html lang="pt-br">

    <?php require_once $_SESSION['caminhopadrao'] . "header.php"; ?>

    <style>
        #contentLoading {
            position: absolute;
            z-index: 1;
            left: 50%;
            top: 20%;
            margin-left: -110px;
            margin-top: -40px;
        }
    </style>

    <body>

        <?php require_once $_SESSION['caminhopadrao'] . "nav.php"; ?>

        <form name="form_sf_system" id="form_sf_system" method="POST">

            <input type="hidden" name="hidIdVisita" id="hidIdVisita" value="<?php echo $id_visitante ?>">

            <div class="container" id="containeralert"></div>
            
            <div class="container py-3">

                <!-- Div para mostrar o loading do ajax -->
                <div id="contentLoading">
                    <div id="loading"></div>
                </div>

                <h2><?php echo $titulo_tela ?></h2>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="txtNomeVisita">Nome Visita</label>
                        <input type="text" class="form-control" name="txtNomeVisita" id="txtNomeVisita" value="<?php
                        if (isset($nm_visitante)) {
                            echo $nm_visitante;
                        }
                        ?>" placeholder="Digite o nome">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtDocumento">Documento</label>
                        <input type="text" class="form-control" name="txtDocumento" id="txtDocumento" value="<?php
                        if (isset($documento_visitante)) {
                            echo $documento_visitante;
                        }
                        ?>" maxlength="11" placeholder="Digite o Documento">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtPlacaVeiculo">Placa do Veículo</label>
                        <input type="text" class="form-control" name="txtPlacaVeiculo" id="txtPlacaVeiculo" value="" maxlength="11" placeholder="Digite a placa (Somente Número e Letra)">
                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="cboCorVeiculo">Cor Veículo</label>
                        <select class="form-select" name="cboCorVeiculo" id="cboCorVeiculo">
                            <option value="0"></option>
                            <?php
                            $sql = "SELECT * FROM tb_cor_veiculo ORDER BY ds_cor_veiculo";
                            $results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

                            if ($results->num_rows) {
                                while ($dados = $results->fetch_array()) {

                                    $id_cor_veiculo = $dados['id_cor_veiculo'];
                                    $ds_cor_veiculo = $dados['ds_cor_veiculo'];

                                    echo "<option value=$id_cor_veiculo>$ds_cor_veiculo</option>";
                                }
                            } else
                                echo "Nenhuma cor encontrada";
                            ?>
                        </select>
                    </div>


                    <div class="form-group col-md-4">
                        <label for="cboTipoVisita">Tipo Visita</label>
                        <select class="form-select" name="cboTipoVisita" id="cboTipoVisita">
                            <option value="0"></option>
                            <?php
                            $sql = "SELECT * FROM tb_tipo_visita ORDER BY ds_tipo_visita";
                            $results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

                            if ($results->num_rows) {
                                while ($dados = $results->fetch_array()) {

                                    $id_tipo_visita = $dados['id_tipo_visita'];
                                    $ds_tipo_visita = $dados['ds_tipo_visita'];

                                    echo "<option value=$id_tipo_visita>$ds_tipo_visita</option>";
                                }
                            } else
                                echo "Nenhum Tipo de Visita encontrada";
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="txtQtdPessoas">Quantidade pessoas no carro</label>
                        <input type="text" class="form-control" name="txtQtdPessoas" id="txtQtdPessoas" value="" placeholder="Digite a quantidade">
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="txtNumeroCasa">N° Casa a ser visitada</label>
                        <input type="text" class="form-control" name="txtNumeroCasa" id="txtNumeroCasa" value="" maxlength="3" placeholder="Informe o número da casa">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="txtObervacao">Obervação</label>
                        <textarea class="form-control" name="txtObervacao" id="txtObervacao" rows="3" placeholder="Digite a observação"></textarea>
                    </div>
                </div>

                <br>
                <br>

                <button type="button" class="btn btn-success btn-lg" name="btnRegistraEntrada" id="btnRegistraEntrada">
                    <img src="../../../bootstrap-icons/check-square-fill.svg" alt="" height="30px"> Registrar Entrada&nbsp;
                </button>

                <button type="button" class="btn btn-success btn-lg" name="btnCancelaNovaVisita" id="btnCancelaNovaVisita" onClick="">
                    <img src="../../../bootstrap-icons/arrow-left-square-fill.svg" alt="" height="30px"> Cancelar&nbsp;
                </button>            

            </div>

        </form>


        <script>
            $(document).ready(function () {

                $("#txtCep").mask("99.999-999");

                //Força usuário a digitar somente números
                $("#txtDocumento").keyup(function () {
                    $("#txtDocumento").val(this.value.match(/[0-9]*/));
                });

                //Força usuário a digitar somente números
                $("#txtPlacaVeiculo").keyup(function () {
                    $("#txtPlacaVeiculo").val(this.value.match(/[A-Za-z0-9]*/));
                });

                //Força usuário a digitar somente números
                $("#txtNumeroCasa").keyup(function () {
                    $("#txtNumeroCasa").val(this.value.match(/[0-9]*/));
                });

            });

            function exibeMensagem(msg) {
                mensagem = "<div class='alert alert-danger text-center' role='alert'>Falha ao criar visita: " + msg + "</div>";
                return mensagem
            }


            $("#btnRegistraEntrada").click(function () {

                var txtDocumento = $("#txtDocumento").val();
                var cboTipoVisita = $("#cboTipoVisita").val();
                var txtNumeroCasa = $("#txtNumeroCasa").val();

                //Verifica se campos estão vazios para salvar
                $("#containeralert").html("");
                if (txtDocumento == "") {
                    msg = "<b>Digite um DOCUMENTO</b>";
                    $("#containeralert").html(exibeMensagem(msg));
                    return false;
                }

                $("#containeralert").html("");
                if (cboTipoVisita == 0) {
                    msg = "<b>Selecione um TIPO DE VISITA</b>";
                    $("#containeralert").html(exibeMensagem(msg));
                    return false;
                }

                $("#containeralert").html("");
                if (txtNumeroCasa == "") {
                    msg = "<b>Digite um NÚMERO DE CASA a ser visitada</b>";
                    $("#containeralert").html(exibeMensagem(msg));
                    return false;
                }

                var form = document.getElementById("form_sf_system");
                form.action = "/entrada_saida/grava_visita_em_andamento.php";
                form.submit();


            });



            $("#btnCancelaNovaVisita").click(function () {

                var form = document.getElementById("form_sf_system");
                form.action = "/consulta/cadastro/visitante/cad_visitante.php";
                form.submit();

            });
        </script>

    </body>

</html>