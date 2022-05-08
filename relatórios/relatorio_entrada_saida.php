<?php

session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

//Sql principal
$sqlPrincipal = "SELECT *, tusai.ds_nome_usuario as usuarioSaida, tus.ds_nome_usuario as usuarioEntrada FROM tb_visita tvsta";
$sqlPrincipal .= " LEFT JOIN tb_visitante tvst ON tvst.id_visitante = tvsta.fk_visitante";
$sqlPrincipal .= " LEFT JOIN tb_tipo_visita tip ON tip.id_tipo_visita = tvsta.fk_tipo_visita";
$sqlPrincipal .= " LEFT JOIN tb_usuario tus ON tus.id_usuario = tvsta.fk_usuario_entrada";
$sqlPrincipal .= " LEFT JOIN tb_usuario tusai ON tusai.id_usuario = tvsta.fk_usuario_saida";
$sqlPrincipal .= " LEFT JOIN tb_veiculo tvei ON tvei.id_veiculo = tvsta.fk_veiculo";
$sqlPrincipal .= " LEFT JOIN tb_tipo_veiculo tpvei ON tpvei.id_tipo_veiculo = tvei.fk_tipo_veiculo";
$sqlPrincipal .= " LEFT JOIN tb_casa tcas ON tcas.id_casa = tvsta.fk_casa";
$sqlPrincipal .= " WHERE 1 = 1";

//Recepcao dos dados enviados via post para montagem da query principal

//Filtra as datas
if (isset($_POST["txtDataInicioPeriodo"], $_POST["txtDataTerminoPeriodo"])) {

	$txtDataInicioPeriodo = $_POST["txtDataInicioPeriodo"];
	$txtDataTerminoPeriodo = $_POST["txtDataTerminoPeriodo"];

	if ($txtDataInicioPeriodo != "" or $txtDataTerminoPeriodo != "") {
		$sqlPrincipal .= " AND dt_entrada_visita BETWEEN '$txtDataInicioPeriodo' AND '$txtDataTerminoPeriodo'";
	}
} else {
	$txtDataInicioPeriodo = "";
	$txtDataTerminoPeriodo = "";
}

//Filtra os porteiros pelo id
if (isset($_POST["cboNomeUsuario"])) {
	$fk_usuario_entrada = $_POST["cboNomeUsuario"];

	if ($fk_usuario_entrada != "NULL") {
		$sqlPrincipal .= " AND (fk_usuario_entrada = $fk_usuario_entrada OR fk_usuario_saida = $fk_usuario_entrada)";
	}
}

//Filtra tipo visita pelo id
if (isset($_POST["cboTipoVisita"])) {
	$fk_tipo_visita = $_POST["cboTipoVisita"];

	if ($fk_tipo_visita != "NULL") {
		$sqlPrincipal .= " AND fk_tipo_visita = $fk_tipo_visita";
	}
}

//Filtra tipo veiculo pelo id
if (isset($_POST["cboTipoVeiculo"])) {
	$fk_tipo_veiculo = $_POST["cboTipoVeiculo"];

	if ($fk_tipo_veiculo != "NULL") {
		$sqlPrincipal .= " AND fk_tipo_veiculo = $fk_tipo_veiculo";
	}
}

//Filtra casa pelo id
if (isset($_POST["cboCasa"])) {
	$fk_casa = $_POST["cboCasa"];

	if ($fk_casa != "NULL") {
		$sqlPrincipal .= " AND fk_casa = $fk_casa";
	}
}


//Inclui o ORDER BY antes do LIMIT
$sqlPrincipal .= " ORDER BY dt_entrada_visita desc, dt_hora_entrada_visita desc";

// número de registros por página
$total_reg = "15";

//Se a página não for especificada a variável "pagina" tomará o valor 1, isso evita de exibir a página 0 de início
$pagina = $_GET['pagina'];

if (!$pagina) {
	$paginaGet = "1";
} else {
	$paginaGet = $pagina;
}

//Valor inicial das sqlPrincipals limitadas
$inicio = $paginaGet - 1;
$inicio = $inicio * $total_reg;

$sql = "$sqlPrincipal LIMIT $inicio , $total_reg";


//Envio da query do filtro para o export
$_SESSION['queryPrincipal'] = $sql;

$limite = mysqli_query($conn, $sql);

$todos = mysqli_query($conn, $sqlPrincipal);

// verifica o número total de registros
$totalRegistros = mysqli_num_rows($todos);

// verifica o número total de páginas
$totalPaginas = intval($totalRegistros / $total_reg);


// agora vamos criar os botões "Anterior e próximo"
$anterior = $paginaGet - 1;
$proximo = $paginaGet + 1;


//Define o número de paginas exibidas
$limitePagina = 10;

//Define o início da contagem das paginações
$inicioPaginas = ((($paginaGet - $limitePagina) > 1) ? $paginaGet - $limitePagina : 1);

//Define o final da contagem das paginações
$fimPaginas = ((($paginaGet + $limitePagina) < $totalPaginas) ? $paginaGet + $limitePagina : $totalPaginas);




?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once $_SESSION['caminhopadrao'] . "header.php"; ?>

<body>

	<?php require_once $_SESSION['caminhopadrao'] . "nav.php"; ?>

	<div class="container" id="containeralert"> </div>

	<br>

	<div class="container">
		<h2>Relatório Entrada e Saída</h2>
		<br>
	</div>

	<form name="form_sf_system" id="form_sf_system" method="POST">

		<div class="container">
			<div class="row">

				<div class="form-group col-md-4">
					<label for="txtDataInicioPeriodo">Data Início Período</label>
					<input type="date" class="form-control" name="txtDataInicioPeriodo" id="txtDataInicioPeriodo" value="<?php echo $txtDataInicioPeriodo ?>">
				</div>

				<div class="form-group col-md-4">
					<label for="txtDataTerminoPeriodo">Data Término Período</label>
					<input type="date" class="form-control" name="txtDataTerminoPeriodo" id="txtDataTerminoPeriodo" value="<?php echo $txtDataTerminoPeriodo ?>">
				</div>

				<div class="form-group col-md-4">
					<label for="cboNomeUsuario">Porteiros</label>
					<select class="form-select" id="cboNomeUsuario" name="cboNomeUsuario">
						<option value="NULL"></option>
						<?php

						$sql = "SELECT * FROM tb_usuario WHERE fk_cargo = 2";

						$results = mysqli_query($conn, $sql) or die("Erro ao retornar PORTEIROS");

						if ($results->num_rows) {
							while ($dados = $results->fetch_array()) {

								$id_usuario = $dados['id_usuario'];
								$ds_nome_usuario = $dados['ds_nome_usuario'];

								$porteiroSelected = "";
								if ($fk_usuario_entrada == $id_usuario) {
									$porteiroSelected = "selected";
								}

								echo "'<option $porteiroSelected value=$id_usuario>$ds_nome_usuario</option>'";
							}
						} else {
							echo "'Nenhum porteiro encontrado'";
						}
						?>
					</select>
				</div>

			</div>

		</div>

		<div class="container">
			<div class="row">
				<div class="form-group col-md-4">
					<label for="cboTipoVisita">Tipo Visita</label>
					<select class="form-select" id="cboTipoVisita" name="cboTipoVisita">
						<option value="NULL"></option>
						<?php

						$sql = "SELECT * FROM tb_tipo_visita";
						$results = mysqli_query($conn, $sql) or die("Erro ao retornar TIPO VISITA");

						if ($results->num_rows) {
							while ($dados = $results->fetch_array()) {

								$id_tipo_visita = $dados['id_tipo_visita'];
								$ds_tipo_visita = $dados['ds_tipo_visita'];

								$tipoVisitaSelected = "";
								if ($fk_tipo_visita == $id_tipo_visita) {
									$tipoVisitaSelected = "selected";
								}

								echo "'<option $tipoVisitaSelected value=$id_tipo_visita>$ds_tipo_visita</option>'";
							}
						} else {
							echo "'Nenhum tipo visita encontrado'";
						}
						?>
					</select>
				</div>

				<div class="form-group col-md-4">
					<label for="cboTipoVeiculo">Tipo Veículo</label>
					<select class="form-select" id="cboTipoVeiculo" name="cboTipoVeiculo">
						<option value="NULL"></option>
						<?php

						$sql = "SELECT * FROM tb_tipo_veiculo";
						$results = mysqli_query($conn, $sql) or die("Erro ao retornar TIPO VEICULO");

						if ($results->num_rows) {
							while ($dados = $results->fetch_array()) {

								$id_tipo_veiculo = $dados['id_tipo_veiculo'];
								$ds_tipo_veiculo = $dados['ds_tipo_veiculo'];

								$tipoVeiculoSelected = "";
								if ($fk_tipo_veiculo == $id_tipo_veiculo) {
									$tipoVeiculoSelected = "selected";
								}


								echo "'<option $tipoVeiculoSelected value=$id_tipo_veiculo>$ds_tipo_veiculo</option>'";
							}
						} else {
							echo "'Nenhum tipo veiculo encontrado'";
						}
						?>
					</select>
				</div>

				<div class="form-group col-md-4">
					<label for="cboCasa">Casa</label>
					<select class="form-select" id="cboCasa" name="cboCasa">
						<option value="NULL"></option>
						<?php

						$sql = "SELECT * FROM tb_casa";
						$results = mysqli_query($conn, $sql) or die("Erro ao retornar CASA");

						if ($results->num_rows) {
							while ($dados = $results->fetch_array()) {
								
								$id_casa = $dados['id_casa'];
								$ds_numero_casa = $dados['ds_numero_casa'];

								$casaSelected = "";
								if ($fk_casa == $id_casa) {
									$casaSelected = "selected";
								}

								echo "'<option $casaSelected value=$id_casa>$ds_numero_casa</option>'";
							}
						} else {
							echo "'Nenhuma casa encontrada'";
						}
						?>
					</select>
				</div>

			</div>
		</div>

		<br>
		<br>


		<div class="container">

			<button type="button" class="btn btn-success btn-sm" name="btnGeraRelatorio" id="btnGeraRelatorio" onClick="">
				<img src="../../../bootstrap-icons/clipboard-data.svg" alt="" height="30px" width="30px"> Filtrar Relatório&nbsp;
			</button>

			<button type="button" class="btn btn-success btn-sm" name="btnExportarRelatorio" id="btnExportarRelatorio" onClick="">
				<img src="../../../bootstrap-icons/arrow-down-circle-fill.svg" alt="" height="30px" width="30px"> Exportar Relatório&nbsp;
			</button>

		</div>

		<br>
		<br>

		<div class="container">
			<div class="row table-responsive">
				<table class="table table-success table-bordered" id="tableVisitaEmAndamento">
					<thead>
						<tr>
							<th>Porteiro Entrada</th>
							<th>Data Entrada</th>
							<th>Hora Entrada</th>
							<th>Data Saída</th>
							<th>Hora Saída</th>
							<th>Nome Visitante</th>
							<th>Tipo Veículo</th>
							<th>Placa Veículo</th>
							<th>Casa</th>
						</tr>
					</thead>
					<tbody>

						<?php
						if ($totalRegistros > 0) {
							while ($dados = mysqli_fetch_array($limite)) {

								$nm_visitante = $dados['nm_visitante'];
								$ds_tipo_visita = $dados['ds_tipo_visita'];
								$dt_hora_entrada_visita = $dados['dt_hora_entrada_visita'];
								$dt_hora_saida_visita = $dados['dt_hora_saida_visita'];
								$ds_numero_casa = $dados['ds_numero_casa'];
								//Precisa-se formatar a data do padrao americano para o br
								$data = $dados['dt_entrada_visita'];
								$dataSaida = $dados['dt_saida_visita'];
								$dt_entrada_visita = date('d/m/Y', strtotime($data));

								if($dataSaida == ""){
									$dt_saida_visita = "";
								} else {
									$dt_saida_visita = date('d/m/Y', strtotime($dataSaida));
								}
								
								$obs_visita = $dados['observacao_visita'];
								$ds_placa_veiculo = $dados['ds_placa_veiculo'];
								$ds_nome_usuario_entrada = $dados['usuarioEntrada'];
								$ds_nome_usuario_saida = $dados['usuarioSaida'];
								$ds_tipo_veiculo = $dados['ds_tipo_veiculo'];

						?>
								<tr>
									<td><?php echo $ds_nome_usuario_entrada ?></td>
									<td><?php echo $dt_entrada_visita ?></td>
									<td><?php echo $dt_hora_entrada_visita ?></td>
									<td><?php echo $dt_saida_visita ?></td>
									<td><?php echo $dt_hora_saida_visita ?></td>
									<td><?php echo $nm_visitante ?></td>
									<td><?php echo $ds_tipo_veiculo ?></td>
									<td><?php echo $ds_placa_veiculo ?></td>
									<td><?php echo $ds_numero_casa ?></td>
									
								</tr>
						<?php
							}
						} else
							echo "<tr><td colspan='9' style='text-align: center'>Nenhum dado encontrado para o filtro informado.</td></tr>"
						?>
						<tr>
							<td colspan='9'>
								<nav>
									<ul class="pt-3 pagination justify-content-center pagination-sm">
										<?php
										if ($paginaGet > 1) {
											echo "<li class='page-item'><a class='page-link' href='?pagina=$anterior'>Anterior</a></li> ";
										} else {
											echo "<li class='page-item disabled'><a class='page-link'>Anterior</a></li> ";
										}
										?>

										<?php
										//Exibe número de páginas
										for ($i = $inicioPaginas; $i <= $fimPaginas; $i++) {

											if ($paginaGet == $i) {
												echo " <li class='page-item active'><a class='page-link' href='?pagina=$i'>$i</a></li>";
											} else {
												echo " <li class='page-item'><a class='page-link' href='?pagina=$i'>$i</a></li>";
											}
										}

										if ($paginaGet <= $totalPaginas) {
											echo "<li class='page-item'><a class='page-link' href='?pagina=$proximo'>Próximo</a></li> ";
										} else {
											echo "<li class='page-item disabled'><a class='page-link'>Próximo</a></li> ";
										}
										?>
									</ul>
								</nav>
							</td>
						<tr>
					</tbody>
				</table>
			</div>
		</div>
	</form>

</body>

<script>

btnExportarRelatorio

	$("#btnExportarRelatorio").click(function() {

		var form = document.getElementById("form_sf_system");
		form.action = "exportar_relatorio.php";
		form.submit();
	});							

	$("#btnGeraRelatorio").click(function() {

		//Validações

		var txtDataInicioPeriodo = $("#txtDataInicioPeriodo").val();
		var txtDataTerminoPeriodo = $("#txtDataTerminoPeriodo").val();

		if (txtDataInicioPeriodo != "" || txtDataTerminoPeriodo != "") {

			//Verifica esta vazio para impedir que o filtro nao fique sem intervalo
			$("#txtDataInicioPeriodo").html("");
			if (txtDataInicioPeriodo == "") {
				msg = "<b>Escolha a DATA INÍCIO PERÍODO</b>";
				$("#containeralert").html(exibeMensagem(msg));
				return false;
			}

			//Verifica esta vazio para impedir que o filtro nao fique sem intervalo
			$("#txtDataTerminoPeriodo").html("");
			if (txtDataTerminoPeriodo == "") {
				msg = "<b>Escolha a DATA TÉRMINO PERÍODO</b>";
				$("#containeralert").html(exibeMensagem(msg));
				return false;
			}

		}

		//Invoca a função para submeter o formulário do filtro
		submeterFormulario();

	});

	function exibeMensagem(msg) {
		mensagem = "<div class='alert alert-danger text-center' role='alert'>Falha ao filtrar: " + msg + "</div>";
		return mensagem
	}

	function submeterFormulario() {
		
		var form = document.getElementById("form_sf_system");
		form.action = "relatorio_entrada_saida.php?pagina=1";
		form.submit();
	}


</script>

</html>