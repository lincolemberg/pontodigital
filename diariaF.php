<?
session_start();
$db2 = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=admin");
if(!$db2){

echo "erro na conexão.";
}
date_default_timezone_set('America/Sao_Paulo');

	
	if(isset($_GET['dia']))
	$dia_pesquisa = $_GET['dia'];
	else
	$dia_pesquisa = date("d");
	

$mes = date("m");
$ano = date("Y");
$dia_atual = date("d");
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
<style>
	@media print{
		.content .card{
			color: black !important;
		}
		#ac_, .form-control, #complemento, #imprimir{
			display: none !important;
		}

	}

</style>
<script>
function p_dia(e){
	window.location.href = '?pagina=diariaF&dia='+e.value;
}
</script>
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" >
<section class="content">
      <div class="container-fluid">
        <div class="row justify-content-end">
          <div class="col-12"><BR><BR><BR><BR><BR><BR>
            <div class="card" id="rend_pr" >
              <div class="card-header">
                <h3 class="card-title" >FREQUÊNCIA DIÁRIA</h3>
				 <?
if(isset($_GET['dia']))
$dia = $_GET['dia'];
else
$dia = date("d");
$dia = str_pad($dia , 2 , '0' , STR_PAD_LEFT);

$mes = date("m");
$ano = date("Y");
	

				?>
				</div>


              <div class="card-body">
                <table id="produtividade" class="table table-bordered table-hover">
                  <thead>
                  <tr>

                    <th>Nº</th>
                    <th>USUÁRIO</th>
                    <th>ENTRADA</th>
                    <th>SAÍDA</th>
                    <th>ATRASO</th>
                  </tr>
                  </thead>
                  <tbody>
                  
				<?
				$ano = date("Y");
				$qtd = 1;
				$q = pg_query("SELECT * FROM frequencia WHERE dia = '$dia_pesquisa' AND mes = '$mes' AND ano = '$ano' ORDER BY entrada ASC");
				while($r = pg_fetch_assoc($q)){
				$nome_completo = $r['nome_completo'];
				$id = $r['id'];

				?>
                    <tr id="lc<?=$id?>">
                    <td><?=$qtd?></td>
                    <td><?=$nome_completo?></td>
                    <td><?=$r['entrada']?></td>
                    <td><?=$r['saida']?></td>
                    <td><?=str_replace('-', '', number_format($r['atraso'],2,'.',''))?> min.</td>

					</tr>
		
				<?
				$qtd++;
				}
				?>
                  
                
                  </tbody>
                </table><br>

				          <br><br><br>          
              </div>
              <!-- /.card-body -->
            </div>
			  
			  
			  <a href="/" style="display: table;margin: auto;text-align: center;"class="btn btn-primary justify-content-center text-center">Registrar Frequência</a><button style="margin: 5px auto;text-align: center;display: block;" name="imprimir" id="imprimir" class="btn btn-secondary justify-content-center">Imprimir</button></br></br></br></br>
            <!-- /.card -->
<script src="js/print/printThis.js"></script>	  
<script>


$("#imprimir").click(function(){
	$("#rend_pr").printThis({
	importCSS: true, 
    importStyle: true
	}
		)
});
</script>
             
          </div>
        </div>
      </div>
    </section>
</body>          
    </html>