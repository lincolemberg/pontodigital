<?
session_start();
$db2 = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=admin");
if(!$db2){

echo "erro na conexão.";
}
date_default_timezone_set('America/Sao_Paulo');
	
//Registra a frêquencia do fiscal no dia

$nome = $_POST['nome'];

$horario = $_POST['ponto'];
$data = $_POST['data'];
$data = explode("-",$data);
$ano = $data[0];
$mes = $data[1];
$dia = $data[2];
                $hora1 = strtotime('07:00');
                $hora2 = strtotime('12:30');
                $horaAtual = strtotime(date('H:i'));
                $hora3 = strtotime('12:31');
                $hora4 = strtotime('18:00');
    
	

$q1 = pg_query("SELECT * FROM frequencia WHERE nome_completo = '$nome' AND ano = '$ano' AND mes = '$mes' AND dia = '$dia'");
		if(pg_num_rows($q1)>=1){
$q4 = pg_query("SELECT * FROM frequencia WHERE nome_completo = '$nome' AND ano = '$ano' AND mes = '$mes' AND dia = '$dia' AND saida != '0'");
			if(pg_num_rows($q4)>=1){
			echo 1;
			}else{

			$nome_completo = $nome;
			

 

 

if($horaAtual > $hora1 && $horaAtual < $hora2){
    
        //TURNO DA MANHÃ
			$ho_1 = $horario;
			$ho_2 = "12:00:00";
			$saida = $ho_1;
			$saida_padrao = $ho_2;
			$hora1 = explode(":",$saida);
			$hora2 = explode(":",$saida_padrao);
			$acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60) + $hora1[2];
			$acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60) + $hora2[2];
			$resultado = $acumulador2 - $acumulador1;
			$hora_ponto = floor($resultado / 3600);
			$resultado = $resultado - ($hora_ponto * 3600);
			$min_ponto = floor($resultado / 60);
			$resultado = $resultado - ($min_ponto * 60);
			$secs_ponto = $resultado;
			//Grava na variável resultado final
			$hora_ponto = $hora_ponto * 60 * 60;
			$min_ponto = $min_ponto * 60;
			$secs_ponto = $secs_ponto;
			$tempo_em_seg = $hora_ponto + $min_ponto + $secs_ponto;

				if($tempo_em_seg>0){

					
					if($tempo_em_seg>='14400')
						$tempo_em_seg  = 14400;
					else
						$tempo_em_seg = $tempo_em_seg;

				}else{
					$desconto = 0;
					$tempo_em_seg = 0;
				}
	$tempo_em_seg = $tempo_em_seg/60;
	
			}elseif($horaAtual > $hora3 && $horaAtual < $hora4){
				//TURNO DA TARDE
			$ho_1 = $horario;
			$ho_2 = "17:00:00";
			$saida = $ho_1;
			$saida_padrao = $ho_2;
			$hora1 = explode(":",$saida);
			$hora2 = explode(":",$saida_padrao);
			$acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60) + $hora1[2];
			$acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60) + $hora2[2];
			$resultado = $acumulador2 - $acumulador1;
			$hora_ponto = floor($resultado / 3600);
			$resultado = $resultado - ($hora_ponto * 3600);
			$min_ponto = floor($resultado / 60);
			$resultado = $resultado - ($min_ponto * 60);
			$secs_ponto = $resultado;
			//Grava na variável resultado final
			$hora_ponto = $hora_ponto * 60 * 60;
			$min_ponto = $min_ponto * 60;
			$secs_ponto = $secs_ponto;
			$tempo_em_seg = $hora_ponto + $min_ponto + $secs_ponto;

				if($tempo_em_seg>0){

					
					
					if($tempo_em_seg>='14400')
						$tempo_em_seg  = 14400;
					else
						$tempo_em_seg = $tempo_em_seg;
						
				}else{
					$desconto = 0;
					$tempo_em_seg = 0;
				}
			$tempo_em_seg = $tempo_em_seg/60;
			}else{
				echo 3;
}
			
				
			//Propocional
			
$r4 = pg_fetch_assoc(pg_query("SELECT * FROM frequencia WHERE nome_completo = '$nome' AND dia = '$dia' AND mes = '$mes' AND ano = '$ano'"));
$agora = strtotime(date("H:i"));
				
$aguarde_t = strtotime($r4['entrada']) + (60*5);
 if($agora > $aguarde_t){
				pg_query("UPDATE frequencia SET saida = '$horario', atraso = atraso - $tempo_em_seg WHERE dia = '$dia' AND mes = '$mes' AND ano = '$ano'");

			echo 4;
 }else{
	 echo 5;
 }
				
			}
		}else{
			
			$nome_completo = $nome;

				//Calcula o tempo de upload
if($horaAtual > $hora1 && $horaAtual < $hora2){
					//TURNO DA MANHÃ ENTRADA
			$ho_1 = $horario;
			$ho_2 = "08:15:00";
			$entrada = $ho_1;
			$entrada_padrao = $ho_2;
			$hora1 = explode(":",$entrada);
			$hora2 = explode(":",$entrada_padrao);
			$acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60) + $hora1[2];
			$acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60) + $hora2[2];
			$resultado = $acumulador2 - $acumulador1;
			$hora_ponto = floor($resultado / 3600);
			$resultado = $resultado - ($hora_ponto * 3600);
			$min_ponto = floor($resultado / 60);
			$resultado = $resultado - ($min_ponto * 60);
			$secs_ponto = $resultado;
			//Grava na variável resultado final
			$hora_ponto = $hora_ponto * 60 * 60;
			$min_ponto = $min_ponto * 60;
			$secs_ponto = $secs_ponto;
			$tempo_em_seg = $hora_ponto + $min_ponto + $secs_ponto;

				if($tempo_em_seg<0){

					
					if($tempo_em_seg<='-14400')
						$tempo_em_seg  = -14400;
					else
						$tempo_em_seg = $tempo_em_seg;
						
					
				}else{
				
					$tempo_em_seg = 0;
				}
			$tempo_em_seg = $tempo_em_seg/60;

	

			}elseif($horaAtual > $hora3 && $horaAtual < $hora4){
				//TURNO DA TARDE
			$ho_1 = $horario;
			$ho_2 = "13:15:00";
			$entrada = $ho_1;
			$entrada_padrao = $ho_2;
			$hora1 = explode(":",$entrada);
			$hora2 = explode(":",$entrada_padrao);
			$acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60) + $hora1[2];
			$acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60) + $hora2[2];
			$resultado = $acumulador2 - $acumulador1;
			$hora_ponto = floor($resultado / 3600);
			$resultado = $resultado - ($hora_ponto * 3600);
			$min_ponto = floor($resultado / 60);
			$resultado = $resultado - ($min_ponto * 60);
			$secs_ponto = $resultado;
			//Grava na variável resultado final
			$hora_ponto = $hora_ponto * 60 * 60;
			$min_ponto = $min_ponto * 60;
			$secs_ponto = $secs_ponto;
			$tempo_em_seg = $hora_ponto + $min_ponto + $secs_ponto;

				if($tempo_em_seg<0){

					
					if($tempo_em_seg<='-14400')
						$tempo_em_seg  = -14400;
					else
						$tempo_em_seg = $tempo_em_seg;
						
					
				}else{
					
					$tempo_em_seg = 0;
				}
			$tempo_em_seg = $tempo_em_seg/60;
			}else{
				echo 3;
    exit();
}
			
				
			//Propocional
			

			$saida = '0';

			pg_query("INSERT INTO frequencia(nome_completo, entrada, dia, mes, ano, saida, atraso) VALUES ('$nome_completo', '$horario', '$dia', '$mes', '$ano', '$saida','$tempo_em_seg')");
			echo 0;
            $_SESSION['nome'] = $nome_completo;
		}
	

?>