SET FOREIGN_KEY_CHECKS=0;
UPDATE versao SET versao_codigo='8.0.5'; 
UPDATE versao SET ultima_atualizacao_bd='2011-11-15'; 
UPDATE versao SET ultima_atualizacao_codigo='2011-11-15'; 
UPDATE versao SET versao_bd=84;

DROP FUNCTION IF EXISTS diferenca_tempo;