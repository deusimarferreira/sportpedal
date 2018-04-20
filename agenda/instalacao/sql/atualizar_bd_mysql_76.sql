UPDATE versao SET versao_codigo='8.0.0'; 
UPDATE versao SET ultima_atualizacao_bd='2011-10-13'; 
UPDATE versao SET ultima_atualizacao_codigo='2011-10-13'; 
UPDATE versao SET versao_bd=76;

SET FOREIGN_KEY_CHECKS=0;

INSERT INTO artefatos_tipo (artefato_tipo_id, artefato_tipo_nome, artefato_tipo_campos, artefato_tipo_descricao, artefato_tipo_imagem) VALUES 
  (7,'Gerenciamento de Risco(GR)',0x613A393A7B733A353A2263616D706F223B613A393A7B693A313B613A323A7B733A343A227469706F223B733A343A226C6F676F223B733A353A226461646F73223B733A31313A2270726F6A65746F5F636961223B7D693A323B613A323A7B733A343A227469706F223B733A393A226361626563616C686F223B733A353A226461646F73223B733A31313A2270726F6A65746F5F636961223B7D693A333B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A31343A2270726F6A65746F5F636F6469676F223B7D693A343B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A31323A2270726F6A65746F5F6E6F6D65223B7D693A353B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A32333A2270726F6A65746F5F726973636F5F64657363726963616F223B7D693A363B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A31383A2270726F6A65746F5F726973636F5F7469706F223B7D693A373B613A323A7B733A343A227469706F223B733A31323A226E6F6D655F7573756172696F223B733A353A226461646F73223B733A32313A2270726F6A65746F5F726973636F5F7573756172696F223B7D693A383B613A323A7B733A343A227469706F223B733A31343A2266756E63616F5F7573756172696F223B733A353A226461646F73223B733A32313A2270726F6A65746F5F726973636F5F7573756172696F223B7D693A393B613A323A7B733A343A227469706F223B733A343A2264617461223B733A353A226461646F73223B733A31383A2270726F6A65746F5F726973636F5F64617461223B7D7D733A31313A226D6F64656C6F5F7469706F223B733A313A2237223B733A363A2265646963616F223B623A303B733A393A22696D7072657373616F223B623A303B733A393A226D6F64656C6F5F6964223B693A303B733A393A2270617261677261666F223B693A303B733A31353A226D6F64656C6F5F6461646F735F6964223B693A303B733A363A226D6F64656C6F223B4E3B733A333A22716E74223B693A393B7D,'',''),
  (8,'Plano de Gerenciamento do Projeto (PGP)',0x613A393A7B733A353A2263616D706F223B613A32373A7B693A313B613A323A7B733A343A227469706F223B733A343A226C6F676F223B733A353A226461646F73223B733A31313A2270726F6A65746F5F636961223B7D693A323B613A323A7B733A343A227469706F223B733A393A226361626563616C686F223B733A353A226461646F73223B733A31313A2270726F6A65746F5F636961223B7D693A333B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A31343A2270726F6A65746F5F636F6469676F223B7D693A343B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A31323A2270726F6A65746F5F6E6F6D65223B7D693A353B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A33333A2270726F6A65746F5F656D626173616D656E746F5F6A757374696669636174697661223B7D693A363B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A32383A2270726F6A65746F5F656D626173616D656E746F5F6F626A657469766F223B7D693A373B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A32363A2270726F6A65746F5F656D626173616D656E746F5F6573636F706F223B7D693A383B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A31393A226573747275747572615F616E616C6974696361223B7D693A393B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A31343A22646963696F6E6172696F5F656170223B7D693A31303B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A33303A2270726F6A65746F5F656D626173616D656E746F5F6E616F5F6573636F706F223B7D693A31313B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A32393A2270726F6A65746F5F656D626173616D656E746F5F7072656D6973736173223B7D693A31323B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A33303A2270726F6A65746F5F656D626173616D656E746F5F726573747269636F6573223B7D693A31333B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A31363A2263726F6E6F6772616D615F6D6172636F223B7D693A31343B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A393A226F7263616D656E746F223B7D693A31353B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A32373A2270726F6A65746F5F7175616C69646164655F64657363726963616F223B7D693A31363B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A32353A2270726F6A65746F5F7175616C69646164655F656E7472656761223B7D693A31373B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A31393A226F7267616E6F6772616D615F70726F6A65746F223B7D693A31383B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A31343A226571756970655F70726F6A65746F223B7D693A31393B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A31373A22726573706F6E736162696C696461646573223B7D693A32303B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A32393A2270726F6A65746F5F636F6D756E69636163616F5F64657363726963616F223B7D693A32313B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A32363A2270726F6A65746F5F636F6D756E69636163616F5F6576656E746F223B7D693A32323B613A323A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A32333A2270726F6A65746F5F726973636F5F64657363726963616F223B7D693A32333B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A31383A2270726F6A65746F5F726973636F5F7469706F223B7D693A32343B613A323A7B733A343A227469706F223B733A31343A226C697374615F657370656369616C223B733A353A226461646F73223B733A31383A22617175697369636F65735F70726F6A65746F223B7D693A32353B613A323A7B733A343A227469706F223B733A31323A226E6F6D655F7573756172696F223B733A353A226461646F73223B733A33313A2270726F6A65746F5F656D626173616D656E746F5F726573706F6E736176656C223B7D693A32363B613A323A7B733A343A227469706F223B733A31343A2266756E63616F5F7573756172696F223B733A353A226461646F73223B733A33313A2270726F6A65746F5F656D626173616D656E746F5F726573706F6E736176656C223B7D693A32373B613A323A7B733A343A227469706F223B733A343A2264617461223B733A353A226461646F73223B733A32343A2270726F6A65746F5F656D626173616D656E746F5F64617461223B7D7D733A31313A226D6F64656C6F5F7469706F223B733A313A2237223B733A363A2265646963616F223B623A303B733A393A22696D7072657373616F223B623A303B733A393A226D6F64656C6F5F6964223B693A303B733A393A2270617261677261666F223B693A303B733A31353A226D6F64656C6F5F6461646F735F6964223B693A303B733A363A226D6F64656C6F223B4E3B733A333A22716E74223B693A32373B7D,'','');

INSERT INTO sisvalores (sisvalor_titulo, sisvalor_valor, sisvalor_valor_id, sisvalor_chave_id_pai) VALUES 
	('RiscoCategoria','Mercado','mercado',NULL),
	('RiscoCategoria','Liquidez','liquidez',NULL),
	('RiscoCategoria','Operacional','operacional',NULL),
	('RiscoCategoria','Jur�dico','jur�dico',NULL),
	('RiscoCategoria','Fator humano','fator humano',NULL);