<?php
include "../include/error.php";
session_start();

$_valor = utf8_decode($_POST['valor']);
if($_SESSION['login'] == ""){
   echo "<script>location.href='./';</script>";
}
//echo "<link rel='shortcut icon' href='img/ham.png'>";
// PRIMEIRAMENTE: INSTALEI A CLASSE NA PASTA FPDF DENTRO DE MEU SITE.
define('FPDF_FONTPATH','fpdf/font/'); 

// INSTALA AS FONTES DO FPDF
require('fpdf/fpdf.php');

// INSTALA A CLASSE FPDF
class PDF extends FPDF {

// CRIA UMA EXTENSÃO QUE SUBSTITUI AS FUNÇÕES DA CLASSE. 
// SOMENTE AS FUNÇÕES QUE ESTÃO DENTRO DESTE EXTENDS É QUE SERÃO SUBSTITUIDAS.


    function Header(  ){ //CABECALHO
        
        $codigo = "Variavel Codigo";
        global $_valor;
        global $codigo; // EXEMPLO DE UMA VARIAVEL QUE TERÁ O MESMO VALOR EM QUALQUER ÁREA DO PDF.
        $l=3; // DEFINI ESTA VARIAVEL PARA ALTURA DA LINHA
        $this->SetXY(10,10); // SetXY - DEFINE O X E O Y NA PAGINA
        //$this->Rect(10,10,190,280); // CRIA UM RETÂNGULO QUE COMEÇA NO X = 10, Y = 10 E 
                                    //TEM 190 DE LARGURA E 280 DE ALTURA. 
                                    //NESTE CASO, É UMA BORDA DE PÁGINA.

       // $this->Image('logo.jpg',11,11,40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
        $this->SetFont('Arial','B',8); // DEFINE A FONTE ARIAL, NEGRITO (B), DE TAMANHO 8

      //  $this->Cell(170,15,'PROTOCOLO DE JEJUM',0,0,'L'); 
        // CRIA UMA CELULA COM OS SEGUINTES DADOS, RESPECTIVAMENTE: 
        // LARGURA = 170, 
        // ALTURA = 15, 
        // TEXTO = 'INSIRA SEU TEXTO AQUI'
        // BORDA = 0. SE = 1 TEM BORDA SE 'R' = RIGTH, 'L' = LEFT, 'T' = TOP, 'B' = BOTTOM
        // QUEBRAR LINHA NO FINAL = 0 = NÃO
        // ALINHAMENTO = 'L' = LEFT
        
        //$this->Cell(20,$l,'Nº '.$codigo,1,0,'C',0); 
        // CRIA UMA CELULA DA MESMA FORMA ANTERIOR MAS COM ALTURA DEFINIDA PELA VARIAVEL $l E 
        // INSERINDO UMA VARIÁVEL NO TEXTO.

        $this->Ln(); // QUEBRA DE LINHA

        //$this->Cell(190,10,'',0,0,'L');
        //$this->Ln();
        $l = 4;
        $this->SetFont('Arial','B',12);
        $this->SetXY(10,15);
        $this->Cell(0,$l,'LISTA DE NOMES - TOTAL A RECEBER '.$_valor,'B',1,'C');
        $l=5;
        $this->SetFont('Arial','B',12);
        //$this->Cell(20,$l,'Dados 1:',0,0,'L');
        //$this->Cell(100,$l,'','B',0,'L');
        //$this->Cell(35,$l,'',0,0,'L');
        //$this->Cell(15,$l,'Data:',0,0,'L');
        //$this->Cell(20,$l,date('d/m/Y'),'B',0,'L'); // INSIRO A DATA CORRENTE NA CELULA
//
//        $this->Ln();
//        $this->Cell(20,$l,'Dados 2:',0,0,'L');
//        $this->Cell(100,$l,'','B',0,'L');
//        $this->Ln();
//        $this->Cell(20,$l,'Dados 3:',0,0,'L');
//        $this->Cell(100,$l,'','B',0,'L');
//        $this->Cell(35,$l,'',0,0,'L');
//        $this->Cell(15,$l,'Dados 4:',0,0,'L');
//        $this->Cell(20,$l,'','B',0,'L');
//        $this->Ln();

        //FINAL DO CABECALHO COM DADOS
        //ABAIXO É CRIADO O TITULO DA TABELA DE DADOS

        //$this->Cell(190,2,'',0,0,'C'); 
        //ESPAÇAMENTO DO CABECALHO PARA A TABELA
        //$this->Ln();

       // $this->SetTextColor(255,255,255);
        //$this->Cell(190,$l,'Titulo 1',1,0,'C',1);
        $this->Ln();

        //TITULO DA TABELA DE SERVIÇOS
        $this->SetFillColor(232,232,232);
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','B',7);
        $this->Cell(10,$l,'ITEM',1,0,'C',1);
        $this->Cell(12,$l, utf8_decode( 'CRACHÁ' ) ,1,0,'C',1);
        $this->Cell(80,$l, 'NOME' ,1,0,'C',1);
        $this->Cell(60,$l, 'EMPRESA' ,1,0,'C',1);
        $this->Cell(30,$l, 'TOTAL' ,1,0,'C',1);

       // $this->Ln();

    }

    function Footer(){ // CRIANDO UM RODAPE

        $this->SetXY(15,260);
        //$this->Rect(10,270,190,20);
        $this->SetFont('Arial','',10);
        //$this->Cell(70,8,'Assinatura ','T',0,'L');
        $this->Cell(40,8,' ',0,0,'L');
        //$this->Cell(70,8,'Assinatura','T',0,'L'); 
        $this->Ln();
        $this->SetFont('Arial','',7);
        $this->Cell(190,7,utf8_decode('Página '.$this->PageNo().' de {nb}'),0,0,'L');
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Manaus');
        $dia_hoje = date('d');
        $ano_hoje = date('Y');
        $hora_hoje = date('H:i:s');
        $data =  'Manaus, '.ucfirst(gmstrftime('%A')).', '.$dia_hoje.' de '.ucfirst(gmstrftime('%B')).' '.$ano_hoje.' '.$hora_hoje;
        //echo $data;
        
        $this->Cell(0,7,$data,0,0,'R');


    }


}

//CONECTE SE AO BANCO DE DADOS SE PRECISAR 
//include("config.php"); // A MINHA CONEXÃO FICOU EM CONFIG.PHP

            require_once "../controller/class.registro_controller.php";
            require_once "../services/class.registroListIterator.php";
            $registro_Controller = new registro_controller();
            $lista = $registro_Controller->listaRegistro( '%', '%' );
            $registros  = array();
            $reg_in = new registroListIterator( $lista );


            $pdf=new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
            //$pdf=new PDF('L','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
            $pdf->AddPage(); // ADICIONA UMA PAGINA
            $pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE
            $pdf->SetFont('Arial','',8);
            $y = 30; // AQUI EU COLOCO O Y INICIAL DOS DADOS 


            $l=5; // ALTURA DA LINHA
            $y = 28; //posicao no eixo Y
            $item = 0;
            $itens = 0;
            while ( $reg_in->hasNextRegistro() ){
                $item++;
                $itens++;
                $registro = $reg_in->getNextRegistro();
            // ENQUANTO OS DADOS VÃO PASSANDO, O FPDF VAI INSERINDO OS DADOS NA PAGINA

                $dados1 = $item;
                $dados2 = $registro->getPessoa()->getNrCracha(); // NESTE CASO, EU DECODIFIQUEI OS DADOS, POIS É UM CAMPO DE     TEXTO.
                $dados3 = utf8_encode( $registro->getPessoa()->getNmPessoa() ) ; // NESTE CASO, EU DECODIFIQUEI OS DADOS, POIS É UM CAMPO DE     TEXTO.
                $dados4 = utf8_encode( $registro->getSnPago() ) ; // NESTE CASO, EU DECODIFIQUEI OS DADOS, POIS É UM CAMPO DE     TEXTO.
                $dados5 = 'R$ '.number_format($registro->getVlPreco(),2);; // NESTE CASO, EU DECODIFIQUEI OS DADOS, POIS É UM CAMPO DE     TEXTO.

               /* $dataMySQL = explode('-',$pessoa->getDtNascimento());

                $dia = $dataMySQL[2];
                $mes = $dataMySQL[1];
                $ano = $dataMySQL[0];*/
               // $dados3 = $dia.'/'.$mes.'/'.$ano;


                //$l = 5 * contaLinhas($dados1,48); 
                // Eu criei a função "contaLinhas" para contar quantas linhas um campo pode conter se tiver largura = 48


            //    if($y + $l >= 230){           // 230 É O TAMANHO MAXIMO ANTES DO RODAPE
            //
            //        $pdf->AddPage();   // SE ULTRAPASSADO, É ADICIONADO UMA PÁGINA
            //        $y=59;             // E O Y INICIAL É RESETADO
            //
            //    }
                $pdf->SetFont('Arial','',8);
                //DADOS
                $pdf->SetY($y);
                $pdf->SetX(10);
            //    $pdf->Rect(10,$y,10,$l);
                $pdf->MultiCell(10,6,$dados1,1,'C',false); // ESTA É A CELULA QUE PODE TER DADOS EM MAIS DE UMA LINHA


                $pdf->SetY($y);
                $pdf->SetX(20);
                //$pdf->Rect(30,$y,80,$l);
                $pdf->MultiCell(12,6,$dados2,1,'C'); //NOME

                $pdf->SetY($y);
                $pdf->SetX(32);
                //$pdf->Rect(113,$y,16,$l);
                $pdf->MultiCell(80,6,$dados3,1,'L',false); ///CPF

                $pdf->SetY($y);
                $pdf->SetX(112);
                //$pdf->Rect(129,$y,70,$l);
                $pdf->MultiCell(60,6,$dados4,1,'C',false); //NASCIMENTO*/

                $pdf->SetY($y);
                $pdf->SetX(172);
                //$pdf->Rect(199,$y,23,$l);
                $pdf->MultiCell(30,6,$dados5,1,'C');
/*
                $pdf->SetY($y);
                $pdf->SetX(222);
                $pdf->Rect(222,$y,70,$l);
                $pdf->MultiCell(240,5,$dados6,0,2);*/
            //    $pdf->SetY($y);
            //    $pdf->SetX(900);
            //    $pdf->Rect(185,$y,15,$l);

                //$pdf->Ln();
                $y += $l;
                if($itens > 47)
                {
                    $pdf->AddPage();
                    $itens = 0;
                    $y = 28;
                }


            }
//echo "<link rel='shortcut icon' href='img/ham.png'>";

$pdf->Footer();
$pdf->Output(); // IMPRIME O PDF NA TELA

Header('Pragma: public'); // ESTA FUNÇÃO É USADA PELO FPDF PARA PUBLICAR NO IE

function contaLinhas($text, $maxwidth){	
	$lines=0;
	if($text==''){
		$cont = 1;
	}else{
		$cont = strlen($text);
	}
	if($cont < $maxwidth){
		$lines = 1;
	}else{
		if($cont % $maxwidth > 0){
			$lines = ($cont / $maxwidth) + 1; 
		}else{
			$lines = ($cont / $maxwidth); 
		}
	} 
	$lines = $lines + substr_count(nl2br($text),'
');
	return $lines;
}