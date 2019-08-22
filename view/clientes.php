<?php
session_start();
if (isset($_SESSION['usuario'])) {

	?>


<!DOCTYPE html>
<html>

<head>
	<title>Clientes</title>
	<?php require_once "menu.php"; ?>
</head>

<body>
	<div class="container">
		<h1>Clientes</h1>
		<div class="row">
			<div class="col-sm-4">
				<form id="frmCliente">
					<label>Nome</label>
					<input type="text" class="form-control input-sm" id="nome" name="nome">
					<label>Sobrenome</label>
					<input type="text" class="form-control input-sm" id="sobrenome" name="sobrenome">
					<label>Endereço</label>
					<input type="text" class="form-control input-sm" id="endereco" name="endereco">
					<label>Email</label>
					<input type="text" class="form-control input-sm" id="email" name="email">
					<label>Telefone</label>
					<input type="text" class="form-control input-sm" id="telefone" name="telefone">
					<label>CPF</label>
					<input type="text" class="form-control input-sm" id="cpf" name="cpf">
					<p></p>
					<span class="btn btn-primary" id="btnAdicionarCliente">Salvar</span>
				</form>
			</div>
			<div class="col-sm-8">
				<div id="tabelaClientesLoad"></div>
			</div>
		</div>
	</div>

	<!-- Button trigger modal -->


	<!-- Modal -->
	<div class="modal fade" id="abremodalClienteUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Atualizar cliente</h4>
				</div>
				<div class="modal-body">
					<form id="frmClienteU">
						<input type="text" hidden="" id="idclienteU" name="idclienteU">
						<label>Nome</label>
						<input type="text" class="form-control input-sm" id="nomeU" name="nomeU">
						<label>Sobrenome</label>
						<input type="text" class="form-control input-sm" id="sobrenomeU" name="sobrenomeU">
						<label>Endereço</label>
						<input type="text" class="form-control input-sm" id="enderecoU" name="enderecoU">
						<label>Email</label>
						<input type="text" class="form-control input-sm" id="emailU" name="emailU">
						<label>Telefone</label>
						<input type="text" class="form-control input-sm" id="telefoneU" name="telefoneU">
						<label>CPF</label>
						<input type="text" class="form-control input-sm" id="cpfU" name="cpfU">
					</form>
				</div>
				<div class="modal-footer">
					<button id="btnAdicionarClienteU" type="button" class="btn btn-primary" data-dismiss="modal">Atualizar</button>

				</div>
			</div>
		</div>
	</div>

</body>

</html>

<script type="text/javascript">
	function adicionarDado(idcliente) {

		$.ajax({
			type: "POST",
			data: "idcliente=" + idcliente,
			url: "../procedimentos/clientes/obterDadosCliente.php",
			success: function(r) {

				dado = jQuery.parseJSON(r);


				$('#idclienteU').val(dado['id_cliente']);
				$('#nomeU').val(dado['nome']);
				$('#sobrenomeU').val(dado['sobrenome']);
				$('#enderecoU').val(dado['endereco']);
				$('#emailU').val(dado['email']);
				$('#telefoneU').val(dado['telefone']);
				$('#cpfU').val(dado['cpf']);



			}
		});
	}

	function eliminarCliente(idcliente) {
		alertify.confirm('Deseja Excluir este cliente?', function() {
			$.ajax({
				type: "POST",
				data: "idcliente=" + idcliente,
				url: "../procedimentos/clientes/eliminarCliente.php",
				success: function(r) {


					if (r == 1) {
						$('#tabelaClientesLoad').load("clientes/tabelaClientes.php");
						alertify.success("Excluido com sucesso!!");
					} else {
						alertify.error("Não foi possível excluir");
					}
				}
			});
		}, function() {
			alertify.error('Cancelado !')
		});
	}
</script>

<script type="text/javascript">
	$(document).ready(function() {

		$('#tabelaClientesLoad').load("clientes/tabelaClientes.php");

		$('#btnAdicionarCliente').click(function() {

			vazios = validarFormVazio('frmCliente');

			if (vazios > 0) {
				alertify.alert("Preencha os Campos!!");
				return false;
			}

			dados = $('#frmCliente').serialize();

			$.ajax({
				type: "POST",
				data: dados,
				url: "../procedimentos/clientes/adicionarCliente.php",
				success: function(r) {

					if (r == 1) {
						$('#frmCliente')[0].reset();
						$('#tabelaClientesLoad').load("clientes/tabelaClientes.php");
						alertify.success("Cliente Adicionado");
					} else {
						alertify.error("Não foi possível adicionar");
					}
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#btnAdicionarClienteU').click(function() {
			dados = $('#frmClienteU').serialize();

			$.ajax({
				type: "POST",
				data: dados,
				url: "../procedimentos/clientes/atualizarCliente.php",
				success: function(r) {



					if (r == 1) {
						$('#frmCliente')[0].reset();
						$('#tabelaClientesLoad').load("clientes/tabelaClientes.php");
						alertify.success("Cliente atualizado com sucesso!");
					} else {
						alertify.error("Não foi possível atualizar cliente");
					}
				}
			});
		})
	})
</script>


<?php
} else {
	header("location:../index.php");
}
?>