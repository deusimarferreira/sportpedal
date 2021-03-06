<?php
/* Copyright [2008] -  S�rgio Fernandes Reinert de Lima
Este arquivo � parte do programa gpweb
O gpweb � um software livre; voc� pode redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a P�blica Geral GNU como publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a.
Este programa � distribu�do na esperan�a que possa ser  �til, mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer  MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/GPL em portugu�s para maiores detalhes.
Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "licen�a GPL 2.odt", junto com este programa, se n�o, acesse o Portal do Software P�blico Brasileiro no endere�o www.softwarepublico.gov.br ou escreva para a Funda��o do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
*/

include_once $Aplic->getClasseBiblioteca('xajax/xajax_core/xajax.inc');
$xajax = new xajax();

function anexo_lido_ajax($anexo_id){
	global $Aplic;
	$sql = new BDConsulta;
	
	$sql->adTabela('anexo_leitura');
	$sql->adInserir('datahora_leitura', date('Y-m-d H:i:s'));
	$sql->adInserir('usuario_id', $Aplic->usuario_id);
	$sql->adInserir('anexo_id', $anexo_id);
	$sql->adInserir('download', 0);
	$sql->exec();
	$sql->limpar();
	}
	
function mudar_porcentagem_ajax($msg_usuario_id, $porcentagem){
	global $Aplic;
	$sql = new BDConsulta;
	$sql->adTabela('msg_usuario');
	$sql->adAtualizar('tarefa_progresso', $porcentagem);
	$sql->adOnde('msg_usuario_id='.$msg_usuario_id);
	$sql->exec();
	$sql->limpar();
	
	$sql->adTabela('msg_tarefa_historico');
	$sql->adInserir('progresso', (int)$porcentagem);
	$sql->adInserir('msg_usuario_id', $msg_usuario_id);
	$sql->adInserir('data', date('Y-m-d H:i:s'));
	$sql->exec();
	$sql->limpar();
	}
	

$xajax->registerFunction("mudar_porcentagem_ajax");
$xajax->registerFunction("anexo_lido_ajax");
$xajax->processRequest();

?>