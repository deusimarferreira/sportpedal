SET FOREIGN_KEY_CHECKS=0;
UPDATE versao SET versao_codigo='8.0.14'; 
UPDATE versao SET ultima_atualizacao_bd='2012-03-18'; 
UPDATE versao SET ultima_atualizacao_codigo='2012-03-18'; 
UPDATE versao SET versao_bd=97;

DROP TABLE IF EXISTS msg_tarefa_historico;

CREATE TABLE msg_tarefa_historico (
  msg_tarefa_historico_id INTEGER(100) UNSIGNED NOT NULL AUTO_INCREMENT,
  msg_usuario_id INTEGER(100) UNSIGNED NOT NULL,
  data DATETIME DEFAULT NULL,
  progresso INTEGER(2) DEFAULT '0',
  PRIMARY KEY (msg_tarefa_historico_id),
  KEY msg_usuario_id (msg_usuario_id),
  CONSTRAINT msg_tarefa_historico_fk FOREIGN KEY (msg_usuario_id) REFERENCES msg_usuario (msg_usuario_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

ALTER TABLE msg_usuario ADD COLUMN tarefa TINYINT(1) DEFAULT NULL;
ALTER TABLE msg_usuario ADD COLUMN tarefa_progresso INTEGER(2) DEFAULT '0';
ALTER TABLE msg_usuario ADD COLUMN tarefa_data DATE DEFAULT NULL;
ALTER TABLE msg_usuario ADD COLUMN ignorar_de TINYINT(1) DEFAULT NULL;
ALTER TABLE msg_usuario ADD COLUMN ignorar_para TINYINT(1) DEFAULT NULL;

ALTER TABLE pratica_indicador_valores MODIFY pratica_indicador_valores_valor DECIMAL(20,3) DEFAULT NULL;
ALTER TABLE pratica_indicador_valores MODIFY pratica_indicador_valores_meta DECIMAL(20,3)  DEFAULT NULL;

INSERT INTO artefatos_tipo (artefato_tipo_id, artefato_tipo_nome, artefato_tipo_civil, artefato_tipo_descricao, artefato_tipo_imagem, artefato_tipo_campos) VALUES 
  (31,'�rvore de Problemas','mpog','','',0x613A393A7B733A353A2263616D706F223B613A353A7B693A313B613A323A7B733A343A227469706F223B733A343A226C6F676F223B733A353A226461646F73223B733A31313A2270726F6A65746F5F636961223B7D693A323B613A323A7B733A343A227469706F223B733A393A226361626563616C686F223B733A353A226461646F73223B733A31313A2270726F6A65746F5F636961223B7D693A333B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A31343A2270726F6A65746F5F636F6469676F223B7D693A343B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A31323A2270726F6A65746F5F6E6F6D65223B7D693A353B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A31353A226172766F72655F70726F626C656D61223B7D7D733A31313A226D6F64656C6F5F7469706F223B733A323A223331223B733A363A2265646963616F223B623A303B733A393A22696D7072657373616F223B623A303B733A393A226D6F64656C6F5F6964223B693A303B733A393A2270617261677261666F223B693A303B733A31353A226D6F64656C6F5F6461646F735F6964223B693A303B733A363A226D6F64656C6F223B4E3B733A333A22716E74223B693A353B7D),
  (32,'�rvore de Problemas','cnj','','',0x613A393A7B733A353A2263616D706F223B613A323A7B693A313B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A31323A2270726F6A65746F5F6E6F6D65223B7D693A323B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A31353A226172766F72655F70726F626C656D61223B7D7D733A31313A226D6F64656C6F5F7469706F223B733A323A223332223B733A363A2265646963616F223B623A303B733A393A22696D7072657373616F223B623A303B733A393A226D6F64656C6F5F6964223B693A303B733A393A2270617261677261666F223B693A303B733A31353A226D6F64656C6F5F6461646F735F6964223B693A303B733A363A226D6F64656C6F223B4E3B733A333A22716E74223B693A323B7D);
