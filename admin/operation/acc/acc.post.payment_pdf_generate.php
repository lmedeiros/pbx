<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require("../../framework/fwk.config.php");
require("../../framework/fwk.database.php");

function format_number($value) {
        setlocale(LC_MONETARY, 'pt_BR');
        $return = money_format('%!n', $value);

        return $return;
    }


function get_account($id) {
	$acc = $GLOBALS['db']->selectRow("SELECT 
						A.*, 
						DATE_FORMAT(B.dt_due, '%d/%m/%Y') as dt_due, 
						DATE_FORMAT(B.dt_generate, '%m/%Y') as dt_generate,
						dt_generate as dt_referencia,
						dt_due as dt_vencto,
						B.value_due
					   FROM 
						pbx.pbx_account A 
					   INNER JOIN 
						pbx.pbx_post_payment B 
						ON 
							A.pbx_account_id = B.pbx_account_id 
						AND 
							B.pbx_post_payment_id = '{$id}'");
	
	//print_r($acc);
	//exit;
	if ($acc) {
        	return $acc;
	} else {
        	return false;
	}
}

$account=get_account($_GET['id']);

function get_calls($account) {
	$calls = $GLOBALS['db']->selectAll("	SELECT 
							calldate as '0',
							dst as '1',
							cost as '2',
							location as '3',
							SEC_TO_TIME(billsec) as '4' 
						FROM 
							pbx.pbx_cdr 
						WHERE 
							accountcode = ".$account['pbx_account_id']." 
						AND 
							calldate 
							BETWEEN 
								DATE_ADD(DATE('".$account['dt_referencia']."'), INTERVAL 0 HOUR) - INTERVAL 1 MONTH 
							AND 
								DATE_ADD(DATE('".$account['dt_referencia']."'), INTERVAL 86399 SECOND)
						AND
							dst REGEXP '[0-9]'
	");

	//print_r($calls);
	//exit;
	if ($calls) {
                return $calls;
        } else {
                return false;
        }

}

function draw_header($pdf) {
        $font_text_bold=$pdf->load_font("Helvetica-Bold","winansi",""); 
  	$pdf->setfont($font_text_bold,12.0);
	$account = get_account($_GET['id']);
	
	//TITULO PDF
        $font_title=$pdf->load_font("Helvetica-Bold","winansi","");
        $pdf->setfont($font_title,16.0);
        $pdf->set_text_pos(8,820);
        $pdf->show("Othos Telecomunicações");

        //SUBTITULO PDF
        $font_subtitle=$pdf->load_font("Helvetica","winansi","");
        $pdf->setfont($font_subtitle,12.0);
        $pdf->set_text_pos(240,820);
        $pdf->show("Extrato de chamadas");

  	$font_subtitle=$pdf->load_font("Helvetica-Bold","winansi","");
  	$pdf->setfont($font_subtitle,11.0);
  	$pdf->set_text_pos(414,820);
  	$pdf->show("Othos Telecomunicações LTDA.");
  	$pdf->set_text_pos(414,805);
  	$font_subtitle=$pdf->load_font("Helvetica","winansi","");
  	$pdf->setfont($font_subtitle,10.0);
  	$pdf->show("Rua Haddock Lobo, 585, CJ. 4A");
  	$pdf->set_text_pos(414,790);
  	$pdf->show("Cerqueira Cesar - São Paulo/SP");
  	$pdf->set_text_pos(414,775);
  	$pdf->show("CNPJ/MF: 08.378.841/0001-49");
  	$pdf->set_text_pos(414,753);
  	$pdf->show("http://www.othos.com.br");

  	//Dados Cliente
  	$font_text_bold=$pdf->load_font("Helvetica-Bold","winansi","");
  	$font_text=$pdf->load_font("Helvetica","winansi","");
  	//NOME-data
  	$pdf->setfont($font_text,9.0);
  	$pdf->set_text_pos(100,790);
  	$pdf->show($account['description']);
  	//END-data
  	$pdf->set_text_pos(100,780);
  	$pdf->show("endereço...");
  	//END-data
  	$pdf->set_text_pos(100,770);
  	$pdf->show($account["email"]);

  	//NV-title
  	$pdf->setfont($font_text_bold,10.0);
  	$pdf->set_text_pos(8,800);
  	$pdf->show("NV");
  	//NV-data
  	$pdf->setfont($font_text,10.0);
  	$pdf->set_text_pos(25,800);
  	$pdf->show($account['pbx_account_id']);
  	//IDO-title
  	$pdf->setfont($font_text_bold,10.0);
  	$pdf->set_text_pos(8,788);
  	$pdf->show("IDO");
  	//IDO-data
  	$pdf->setfont($font_text,10.0);
  	$pdf->set_text_pos(30,788);
  	$pdf->show($account['pbx_account_id']);
  	//REF-title
  	$pdf->setfont($font_text_bold,10.0);
  	$pdf->set_text_pos(8,745);
  	$pdf->show("Referencia");
  	//REF-data
  	$pdf->setfont($font_text,10.0);
  	$pdf->set_text_pos(8,735);
  	$pdf->show($account['dt_generate']);
  	//TOTAL-title
  	$pdf->setfont($font_text_bold,10.0);
  	$pdf->set_text_pos(80,745);
  	$pdf->show("Total da Fatura");
  	//TOTAL-data
  	$pdf->setfont($font_text,10.0);
  	$pdf->set_text_pos(80,735);
  	$pdf->show(format_number($account['value_due']));
  	//VENC-title
  	$pdf->setfont($font_text_bold,10.0);
  	$pdf->set_text_pos(170,745);
  	$pdf->show("Vencimento");
  	//VENC-data
  	$pdf->setfont($font_text,10.0);
  	$pdf->set_text_pos(170,735);
  	$pdf->show($account['dt_due']);

}

try {
	$pdf=new PDFlib();
	$pdf->set_parameter("textformat", "utf8");
	$pdf->set_parameter("errorpolicy", "return");	
	
	if(!$pdf->begin_document("","")) {
		throw new PDFlibException("Error creating PDF document. ".$pdf->get_errmsg());
	}

	$pdf->set_info("Creator",$account['pbx_account_id']."-".$account['dt_generate']);
	$pdf->set_info("Author","Othos Telecom");
	$pdf->set_info("Title","Extrato Mensal");

	$pdf->begin_page_ext(595,842,"");
	
	$font_text_bold=$pdf->load_font("Helvetica-Bold","winansi","");
        $font_text=$pdf->load_font("Helvetica","winansi","");

	//CABEÇALHO DIREITO
        $pdf->rect(408,745,180,90);
        $pdf->rect(8,470,430,250);
        $pdf->rect(445,470,143,250);
        $pdf->stroke();

	draw_header($pdf);
  	
	//MESSAGE
  	$pdf->set_text_pos(455,700);
  	$pdf->show("Caro Cliente Othos,");
  	$pdf->set_text_pos(455,680);
  	$pdf->show("pague suas ");
  	$pdf->set_text_pos(455,660);
  	$pdf->show("contas pendentes e");
  	$pdf->set_text_pos(455,640);
  	$pdf->show("evite o bloqueio");
  	$pdf->set_text_pos(455,620);
  	$pdf->show("de sua linha.");
  	
	//MESSAGE ATENDIMENTO

  	$pdf->setfont($font_text_bold,12.0);
  	$pdf->set_text_pos(455,570);
  	$pdf->show("Atendimento");
  	$pdf->setfont($font_text,12.0);
  	$pdf->set_text_pos(455,555);
  	$pdf->show("Seg. a Sex. 9h as 18h");
  	$pdf->set_text_pos(455,530);
  	$pdf->show("(11) 4063-6069");
  	$pdf->set_text_pos(455,515);
  	$pdf->show("suporte@othos.com.br");
  	$pdf->set_text_pos(455,500);
  	$pdf->show("NV: 550-0001");
 
  	//Servicos
  	$pdf->setfont($font_text_bold,12.0);
  	$pdf->set_text_pos(18,700);
  	$pdf->show("SERVIÇOS");
  	$pdf->setfont($font_text_bold,12.0);
  	$pdf->set_text_pos(360,700);
  	$pdf->show("VALOR (R$)");

  	$servicos = array("Consumo de telefone"=>format_number($account['value_due'])); 
  
  	$servicos_height = 680;
	$soma_servicos = (float) 0.00;
		
	foreach($servicos as $servico=>$valor) {
  		$pdf->setfont($font_text,11.0);
		$pdf->set_text_pos(18, $servicos_height);
  		$pdf->show($servico);
		$pdf->set_text_pos(370, $servicos_height);
		$pdf->show($valor);
		$servicos_height = $servicos_height - 15;
		$soma_servicos = format_number($soma_servicos) + $valor;
  	}
  
  	$pdf->setfont($font_text_bold,12.0);
  	$pdf->set_text_pos(18,485);
 	$pdf->show("TOTAL A PAGAR");
  	$pdf->setfont($font_text_bold,12.0);
  	$pdf->set_text_pos(370,485);
  	//$pdf->show(format_number($soma_servicos));
	$pdf->show(format_number($account['value_due']));

	// end page0
	$pdf->end_page_ext("");
	// start page1
	$pdf->begin_page_ext(595,842,"");
	
	draw_header($pdf);

	$chamadas = get_calls($account);
	
        //Tabela Chamadas
	$table_w = 580;
	$table_h = 666;
	
	$pdf->rect(8,25,$table_w,$table_h);

	$pdf->stroke();
        $rows = count($chamadas);

	$rec_per_page=42;	
	$pages=ceil($rows/$rec_per_page);	

	$cols = 5;
	$page = 2;

	$cell_w = ($table_w-20) / $cols;
	$cell_h = 15;
	$cell_x = 16;
	$cell_y = 650;
	
	//Linhas
	$titulos = array("DATA/HORA","NÚMERO","CUSTO","LOCALIDADE","DURAÇÃO");

	for($j=0 ; $j<$rows ; $j++) {
		//NOVA PAGINA
		if($j % $rec_per_page == 0 && $j != 0) {
			$pdf->end_page_ext("");
			$pdf->begin_page_ext(595,842,"");

			 draw_header($pdf);

			$pdf->rect(8,25,$table_w,$table_h);
		        $pdf->stroke();

                        $font_text=$pdf->load_font("Helvetica","winansi","");
                        $pdf->setfont($font_text,9.0);
			
			if($page>2) {
				$pdf->set_text_pos(10, 10);
        	                $pdf->show("Página: ".$page." de ". ($pages+1));
				$page++;
			}			
			
			$cell_h = 15;
		        $cell_x = 16;
        		$cell_y = 650;
			
			for($l=0 ; $l<$cols ; $l++) {
                                switch($l) {
                                        case 2:
                                                $cell_x=$cell_x-20;
                                                break;
                                        case 3:
                                                $cell_x=$cell_x-50;
                                                break;
                                        case 4:
                                                $cell_x=$cell_x+120;
                                                break;
                                }

                                $font_text=$pdf->load_font("Helvetica","winansi","");
                                $pdf->setfont($font_text_bold,10.0);
                                $pdf->set_text_pos($cell_x, $cell_y+20);
                                $pdf->show($titulos[$l]);
                                $cell_x = $cell_x + $cell_w;
                        }
                        $cell_x = 16;
		}
		
		//Titulo tabela
		if($j==0) {
			for($l=0 ; $l<$cols ; $l++) {
				switch($l) {
        	                        case 2:
                	                        $cell_x=$cell_x-20;
                        	                break;
                               		case 3:
                                        	$cell_x=$cell_x-50;
                                        	break;
                                	case 4:
                                        	$cell_x=$cell_x+120;
                                        	break;
	                        }

				$font_text=$pdf->load_font("Helvetica","winansi","");
	                        $pdf->setfont($font_text_bold,10.0);
        	                $pdf->set_text_pos($cell_x, $cell_y+20);
	                        $pdf->show($titulos[$l]);
                        	$cell_x = $cell_x + $cell_w;
			}
			$cell_x = 16;
		}
		//Colunas
		for($i=0 ; $i<$cols ; $i++) {
			$font_text=$pdf->load_font("Helvetica","winansi","");
			$pdf->setfont($font_text,9.0);
			switch($i) {
				case 2:
					$cell_x=$cell_x-20;
					break;
				case 3:
					$cell_x=$cell_x-50;
					break;
				case 4:
					$cell_x=$cell_x+120;
					break;
			}
			$pdf->set_text_pos($cell_x, $cell_y);
        		$pdf->show($chamadas[$j][$i]);
			$cell_x = $cell_x + $cell_w;
		}
		$cell_y = $cell_y - $cell_h;
		$cell_x = 16;

		$pdf->setfont($font_text,9.0);
		
		if($page==2) {
			$pdf->set_text_pos(10, 10);
        		$pdf->show("Página: ".$page." de ". ($pages+1));
			$page++;
		}
	}


	// end page1
	$pdf->end_page_ext("");

	// end document
  	$pdf->end_document("");

	// get buffer contents
  	$buffer=$pdf->get_buffer();

	// get length of buffer
	$len=strlen($buffer);

	// display PDF document
	header("Content-type: application/pdf");
	header("Content-Length: $len");
	header("Content-Disposition: inline; filename=".$account['pbx_account_id']."-".$account['dt_generate'].".pdf");

 	echo $buffer;

} catch (PDFlibException $e) {
	echo 'Error Number:'.$e->get_errnum()."<br />";
	echo 'Error Message:'.$e->get_errmsg();
	exit();
}

?>
