<?
	
$data = date('Y-m-d');
$data2 = strftime('%B', strtotime($data));
$data3 = strftime('%d', strtotime($data));
$data4 = strftime('%Y', strtotime($data));
$mes_pt = $data2;
if($mes_pt == "January")
	$mes_pt = "Janeiro";
elseif($mes_pt == "February")
	$mes_pt = "Fevereiro";
elseif($mes_pt == "March")
	$mes_pt = "Março";
elseif($mes_pt == "April")
	$mes_pt = "Abril";
elseif($mes_pt == "May")
	$mes_pt = "Maio";
elseif($mes_pt == "June")
	$mes_pt = "Junho";
elseif($mes_pt == "July")
	$mes_pt = "Julho";
elseif($mes_pt == "August")
	$mes_pt = "Agosto";
elseif($mes_pt == "September")
	$mes_pt = "Setembro";
elseif($mes_pt == "October")
	$mes_pt = "Outubro";
elseif($mes_pt == "November")
	$mes_pt = "Novembro";
elseif($mes_pt == "December")
	$mes_pt = "Dezembro";
	
	
	if(isset($_GET['dia']))
	$dia_pesquisa = $_GET['dia'];
	else
	$dia_pesquisa = date("d");
	

$mes = date("m");
$ano = date("Y");
$dia_atual = date("d");
$dias_t =  date("t");
	
?>
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
<section class="content">
      <div class="container-fluid">
        <div class="row justify-content-end">
          <div class="col-10"><BR><BR><BR><BR><BR><BR>
            <div class="card" id="rend_pr" >
              <div class="card-header">
                <h3 class="card-title" >ASSIDUIDADE DIÁRIA</h3>
				 <?
if(isset($_GET['dia']))
$dia = $_GET['dia'];
else
$dia = date("d");
$dia = str_pad($dia , 2 , '0' , STR_PAD_LEFT);

$mes = date("m");
$ano = date("Y");
	
				$q = pg_query("SELECT * FROM visto WHERE dia = '$dia' AND mes = '$mes' AND ano = '$ano'");
				if(pg_num_rows($q)=='1'){
				?>
                <h3 class="card-title text-danger" style="float: right;font-size: 1.4em;" >[ VISTO ]</h3>
				 <?
				}
				?>
				</div>
              <!-- /.card-header -->
<select class="form-control" onChange="p_dia(this)" name="dia">
	<?
	for($dia_1 = 1;$dia_1 <= $dia_atual;$dia_1++){
		$dia_1 =  str_pad($dia_1 , 2 , '0' , STR_PAD_LEFT);
		if(date("D",strtotime("$ano-$mes-$dia_1"))!="Sat" and date("D",strtotime("$ano-$mes-$dia_1"))!="Sun"){
	if($dia_1 == $dia_pesquisa){
	?>
      <option value="<?=$dia_1?>" selected><?=$mes_pt?>: dia  <?=$dia_1?>.</option>
	<?
			}else{
	?>
      <option value="<?=$dia_1?>"><?=$mes_pt?>: dia  <?=$dia_1?>.</option>
	<?
			}
		}
	}
	?>
</select>

              <div class="card-body">
                <table id="produtividade" class="table table-bordered table-hover">
                  <thead>
                  <tr>

                    <th>Nº</th>
                    <th>FISCAL</th>
                    <th>ENTRADA</th>
                    <th>SAÍDA</th>
                    <th>ATRASO</th>
                    <th>DESCONTO</th>
                    <th>JUSTIFICATIVA</th>
                    <th  id="ac_">AÇÃO</th>

                  </tr>
                  </thead>
                  <tbody>
                  
				<?
				$ano = date("Y");
				$qtd = 1;
				$q = pg_query("SELECT * FROM frequencia WHERE dia = '$dia_pesquisa' AND mes = '$mes' AND ano = '$ano' ORDER BY entrada ASC");
				while($r = pg_fetch_assoc($q)){
				$matricula = $r['matricula'];
				$nome_completo = $r['nome_completo'];
				$id = $r['id'];
				$produtividade = str_replace('-', '', number_format($r['iqef'],2,',','.'));
				?><tr id="lc<?=$id?>">
                    <td><?=$qtd?></td>
                    <td><?=$nome_completo?></td>
                    <td><?=$r['entrada']?></td>
                    <td><?=$r['saida']?></td>
                    <td><?=str_replace('-', '', number_format($r['atraso'],2,'.',''))?> min.</td>
                    <td>R$ <?=$produtividade?></td>
					<?
					if($r['justificativa']=='1'){
					?>
					  
                    <td><label class="btn btn-info" style="margin: auto;text-align: center;display: block;" data-toggle="modal" data-target="#ver<?=$id?>">Ver</label></td>
					  
					<td id="ac_">
					<?
					if($r['aprov_just']=='1'){
					?>
					<div class="custom-control custom-switch" >
                      <input onclick="aprov('<?=$_SESSION['matricula']?>', '<?=$id?>')" type="checkbox" class="custom-control-input" id="aprov<?=$id?>"checked>
                      <label class="custom-control-label" for="aprov<?=$id?>"> Justificado </label>
                    </div>
					<?
					}else{
					?>
					<div class="custom-control custom-switch" >
                      <input onclick="aprov('<?=$_SESSION['matricula']?>', '<?=$id?>')" type="checkbox" class="custom-control-input" id="aprov<?=$id?>">
                      <label class="custom-control-label" for="aprov<?=$id?>"> Justificado </label>
                    </div>
					<?
					}
					?>
					<?
					if($r['nega_just']=='1'){
					?>
					<div class="custom-control custom-switch custom-switch-on-danger" >
                      <input onclick="nega('<?=$_SESSION['matricula']?>', '<?=$id?>')" type="checkbox" class="custom-control-input" id="nega<?=$id?>" checked>
                      <label class="custom-control-label" for="nega<?=$id?>"> Negado </label>
                    </div>
					<?
					}else{
					?>
					<div class="custom-control custom-switch custom-switch-on-danger" >
                      <input onclick="nega('<?=$_SESSION['matricula']?>', '<?=$id?>')"  type="checkbox" class="custom-control-input" id="nega<?=$id?>" >
                      <label class="custom-control-label" for="nega<?=$id?>"> Negado </label>
                    </div>
					<?
					}
					?>
					<?
					}else{
					$q3 = pg_query("SELECT * FROM frequencia WHERE dia = '$dia_pesquisa' AND mes = '$mes' AND ano = '$ano' AND matricula = '$matricula' AND DESCONTO = 1");
						if(pg_num_rows($q3)==0){
					?>
					 <td></td>
					<td id="ac_">
					<div class="custom-control custom-switch" >
                      <input onclick="desc('<?=$_SESSION['matricula']?>', '<?=$id?>')" type="checkbox" class="custom-control-input" id="desc<?=$id?>">
                      <label class="custom-control-label" for="desc<?=$id?>"> Descontar </label>
                    </div>		  
					</td>
					<?
						}else{
					?>
					 <td></td>
					<td id="ac_">
					<div class="custom-control custom-switch" >
                      <input onclick="desc('<?=$_SESSION['matricula']?>', '<?=$id?>')" type="checkbox" class="custom-control-input" id="desc<?=$id?>" checked>
                      <label class="custom-control-label" for="desc<?=$id?>"> Descontar </label>
                    </div>		  
					</td>					<?
						}
					}
					?>
					</tr>
		<div class="modal fade" id="ver<?=$id?>">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
			  <form  method="post" onSubmit="return false" >
            <div class="modal-header">
              <h4 class="modal-title">Justificativa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
				  
            <div class="modal-body">
               <div  class="input-group mb-12 proc_2">
					<div class="input-group-prepend">
                    <span class="input-group-text" style="padding: 0 4px;"><i class="fal fa-table" style="font-size: 1.5em"></i></span>
						<label class="input-group-text">Referente a data: <?=$r['dia']?> de <?=$mes_pt?> de <?=$r['ano']?>.</label>
                 </div>

                  
					
                </div>
            </div>
				  
            <div class="modal-body">
			<div class="callout callout-info text-left italic">
              <label style="display: block;color: #5faee3;font-weight: normal;"><i class="fas fa-info"></i> Justificativa:</label>
			<span style="font-style: italic"><?=$r['descricao']?>
				</span>
				<br>
				<img src="../justificativa/<?=$_SESSION['matricula']?>/<?=$r['just_image']?>" width="100%" />
				</div>
               Horario da justificativa: <?=$r['hora_justificativa']?>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

            </div>
			</form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
				<?
				$qtd++;
				}
				?>
                  
                
                  </tbody>
                </table><br>
				  <div class="custom-control custom-switch" style="float: right">
                      <input type="checkbox" class="custom-control-input" id="customSwitch5" onChange="visto('<?=$_GET['dia']?>')">
                      <label class="custom-control-label" for="customSwitch5" id="status">Marcar como visto</label>
                    </div>
				          <br><br><br>          
<p class="text-right p-4">Arapiraca, <?=date('d')?> de <?=$mes_pt?> de <?=$ano?>.</p>
              </div>
              <!-- /.card-body -->
            </div>
			  
			  
			  <button style="margin: 5px auto;text-align: center;display: block;" name="imprimir" id="imprimir" class="btn btn-primary justify-content-center">Imprimir</button></br></br></br></br>
            <!-- /.card -->
<script src="../plugins/print/printThis.js"></script>	  
<script>
	function visto(dia){
		$.ajax({
		url : "controllers/visto.php",
		type : 'post',
		data : {
		dia : dia
		},
		beforeSend : function(){
			
		$("#status").html("Aguarde...");
		}}).done(function(msg){
			if(msg==1){
			$("#status").html("Visto");
			}else{
			$("#status").html("Erro");			}
		}).fail(function(jqXHR, textStatus, msg){
					 
		});
		
	}
	
	
		function desc(matricula, idd){
		$.ajax({
		url : "controllers/desc.php",
		type : 'post',
		data : {
		id : idd,
		matricula: matricula
		},
		beforeSend : function(){
			
		$("#desc"+idd).attr("disabled", true);
		}}).done(function(msg){
			if(msg==1){
			$("#desc"+idd).attr("checked", true);
			}else{
			$("#desc"+idd).attr("checked", false);
			}
		}).fail(function(jqXHR, textStatus, msg){
					 
		});
		
	}

	function nega(matricula, idd){
		$.ajax({
		url : "controllers/nega.php",
		type : 'post',
		data : {
		id : idd,
		matricula: matricula
		},
		beforeSend : function(){
			
		$("#nega"+idd).attr("disabled", true);
		}}).done(function(msg){
			if(msg==1){
			$("#nega"+idd).attr("checked", true);
			}else{
			$("#nega"+idd).attr("checked", false);
			}
		}).fail(function(jqXHR, textStatus, msg){
					 
		});
		
	}
	
	
	function aprov(matricula, idd){
		$.ajax({
		url : "controllers/aprova.php",
		type : 'post',
		data : {
		id : idd,
		matricula: matricula
		},
		beforeSend : function(){
			
		$("#aprov"+idd).attr("disabled", true);
		}}).done(function(msg){
			if(msg==1){
			$("#aprov"+idd).attr("checked", true);
			}else{
			$("#aprov"+idd).attr("checked", false);
			}
		}).fail(function(jqXHR, textStatus, msg){
					 
		});
		
	}
	
	
	
$("#imprimir").click(function(){
	$("#rend_pr").printThis({
	importCSS: true, 
    importStyle: true
	}
		)
});
</script>
             
            <!-- /.card -->
          </div>
          <!-- /.col -->
			 
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
