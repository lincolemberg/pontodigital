<?
session_start();
$db2 = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=admin");
if(!$db2){

echo "erro na conexão.";
}
date_default_timezone_set('America/Sao_Paulo');

	

	
$mes = date("m");
$ano = date("Y");
$dia = date("d");
$dia_1 = 1;
$dias = cal_days_in_month(CAL_GREGORIAN, $mes, 2022); // 31
$dias_t =  date("t");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <!-- Metatags para elaborar -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FAUS | Ponto Digital</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="css/fontawesome-free/css/all.css">
    
        
        
     
        
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">
	<link rel="stylesheet" href="css/main.css">
	<script src="js/jquery/jquery.min-3.6.0.js"></script>
    <link rel="stylesheet" href="js/leaflet/1.8/leaflet.css" />  
    <script src="js/leaflet/1.8/leaflet.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.76.0/dist/L.Control.Locate.css" />
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.76.0/src/L.Control.Locate.min.js" charset="utf-8"></script>
<style>
	
.projects .table-avatar img, .projects img.table-avatar {
    border-radius: 50%;
    display: inline;
    width: 2.5rem;
    height: 2.5rem;
}	
</style>


<script>


const options = {
  enableHighAccuracy: true,
  timeout: 5000,
  maximumAge: 0
	
};
		  
function error(err) {
  alert('ERROR(' + err.code + '): ' + err.message);
};
	


function ponto(check,nome){
	event.preventDefault();
	var data = $("#data").val();
	$("#bt").attr("disabled", true);
	$("#bt").html("Aguarde...");
	if(nome!=""){

	


        //sql
		$.ajax({
		url : "controller/frequencia.php",
		type : 'post',
		data : {
		nome : nome,
		ponto: check,
		data: data
		},
		beforeSend : function(){
			
		$("#bt").html("Aguarde...");
		}}).done(function(msg){
			if(msg==1){
			$("#bt").html("Você já confirmou presença");
            setTimeout("recarrega()", 2000);
			}else if(msg==2){
			$("#bt").html("Servidor não encontrado");
			}else if(msg == 4){
			$("#bt").html("Saída registrada às: "+ check);
			setTimeout("recarrega()", 2000);
			}else if(msg == 3){
			$("#bt").html("Fora do horário de expediente ");
			}else if(msg == 0){
			$("#bt").html("Entrada registrada às: "+ check);
			setTimeout("recarrega()", 2000);
			}else if(msg == 5){
			$("#bt").html("Você fez a entrada recentemente, aguarde 5min.");
			setTimeout("recarrega()", 8000);
			}
		}).fail(function(jqXHR, textStatus, msg){
					 
		});

}else{
	alert("Digite o seu nome");
	$("#nomecula").focus();
}
}
	
	function recarrega(){
		window.location.href = "../";
	}


		</script>
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" >
<?
if(isset($_SESSION['nome']))
$nome = $_SESSION['nome'];
else{
$_SESSION['nome'] = "admin";
$nome = $_SESSION['nome'];
}
$ano = date("Y");
$mes = date("m");
$dia = date("d");
$q1 = pg_query("SELECT * FROM frequencia WHERE nome_completo = '$nome' AND ano = '$ano' AND mes = '$mes' AND dia = '$dia'");
$q4 = pg_query("SELECT * FROM frequencia WHERE nome_completo = '$nome' AND ano = '$ano' AND mes = '$mes' AND dia = '$dia' AND saida != '0'");


	if(pg_num_rows($q4)==0){
		if(pg_num_rows($q1)!=0){
		$r4 = pg_fetch_assoc($q1);
		$registro = $r4['entrada'];
			
		$entrada = "<br> Entrada registrada às ".$registro;
		$bt = "Confirmar saída";
		}else{
		$entrada = "";
		$bt = "Confirmar entrada";
		}
	}else{
	$r5 = pg_fetch_assoc($q4);
		$registro = $r5['saida'];
		$entrada = "<br> Saída registrada às ".$registro;
		$bt = "Você já confirmou presença";	
	}
?>
<div>
	<div style="padding: 40px;">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header border-bottom-0 text-info text-bold">
                  Controle de Ponto <?=$entrada?>
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-12">
                      <input type="hidden" class="form-control col-12" placeholder="Digite a sua matrícula" id="nome" name="nome" value="<?=$_SESSION['nome']?>"  >
                      <p class="text-muted text-sm"><b>Função: </b> Fiscal Municipal da SMDUMA <BR> Frequência do mês atual</p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="big text-info">Confirmação da presença digital</li>

                      </ul>
<?
		$diaMax = date('Y-m-d', strtotime('next Friday'));
?>
				  <input type="date" min="<?=date("Y-m-d")?>" max="<?=date("Y-m-d")?>" class="form-control col-12"  value="<?=date("Y-m-d")?>" name="data" id="data" />
						<br>

					 </div>

                  </div>
                </div>


	
				  <div class="card-footer">
										
                  <div class="text-right">

                    <button id="bt" class="btn btn-sm btn-primary" onClick="ponto('<?=date('H:i:s')?>', '<?=$_SESSION['nome']?>')">
                      <i class="fas fa-user" id="p"></i> <?=$bt?>
                    </button>
                  </div>
                </div>
              </div>
            </div>
</div>

  
</div>

	<script>
	
		function reloaded(){
			window.location.href = '../';
		}

	  function mudaicon3(){
		document.getElementById('icon').className = "fa-solid fa-check text-success";

		}
	
		
</script>



<!-- jQuery -->
<script src="js/bootstrap/js/bootstrap.min.js"></script>
>
<!-- Bootstrap -->
<script src="/js/bootstrap/js/bootstrap.bundle.js"></script>

	</body>
</html>
<?
unset($_SESSION['nome']);
?>                         