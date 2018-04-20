UPDATE versao SET versao_bd=34; 
UPDATE versao SET versao_codigo='6.1'; 

INSERT INTO usuario_preferencias(pref_usuario, pref_nome, pref_valor)
(SELECT DISTINCT usuario_id, 'MSG_ENTRADA' AS nome, 1 AS valor FROM usuarios);

CREATE TABLE parafazer_usuarios (
  usuario_id INTEGER(100) UNSIGNED NOT NULL DEFAULT '0',
  id INTEGER(100) UNSIGNED NOT NULL DEFAULT '0',
  aceito TINYINT(3) DEFAULT '0',
  data DATETIME DEFAULT NULL,
  PRIMARY KEY (usuario_id, id),
  KEY uek2 (id, usuario_id)
)ENGINE=InnoDB  DEFAULT CHARSET=latin1;

UPDATE modelos_tipo SET modelo_tipo_campos=0x613A393A7B733A353A2263616D706F223B613A31343A7B693A313B613A353A7B733A343A227469706F223B733A393A226361626563616C686F223B733A353A226461646F73223B733A3131393A223C70207374796C653D22746578742D616C69676E3A2063656E7465723B223E0D0A093C7374726F6E673E4D494E495354264561637574653B52494F204441204445464553413C6272202F3E0D0A094558264561637574653B524349544F2042524153494C4549524F3C2F7374726F6E673E3C2F703E0D0A223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A323B613A353A7B733A343A227469706F223B733A393A2270726F746F636F6C6F223B733A353A226461646F73223B733A303A22223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A333B613A353A7B733A343A227469706F223B733A363A22636964616465223B733A353A226461646F73223B733A303A22223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A343B613A353A7B733A343A227469706F223B733A343A2264617461223B733A353A226461646F73223B4E3B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A353B613A353A7B733A343A227469706F223B733A323A22646F223B733A353A226461646F73223B733A323A22446F223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A363B613A353A7B733A343A227469706F223B733A393A2272656D6574656E7465223B733A353A226461646F73223B733A303A22223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A373B613A353A7B733A343A227469706F223B733A323A22616F223B733A353A226461646F73223B733A323A22416F223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A383B613A353A7B733A343A227469706F223B733A31333A2264657374696E61746172696F73223B733A353A226461646F73223B733A303A22223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A393B613A353A7B733A343A227469706F223B733A353A22626C6F636F223B733A353A226461646F73223B733A3230373A223C70207374796C653D22746578742D696E64656E743A2031303070783B223E0D0A09312E20526571756572696D656E746F20656D20717565206F204361706974266174696C64653B6F202E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2C20646573746520426174616C68266174696C64653B6F20706C656974656961202E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E202E3C2F703E0D0A223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A31303B613A353A7B733A343A227469706F223B733A353A22626C6F636F223B733A353A226461646F73223B733A313032373A223C70207374796C653D22746578742D696E64656E743A2031303070783B223E0D0A09322E20494E464F524D412643636564696C3B264174696C64653B4F3C2F703E0D0A3C70207374796C653D22746578742D696E64656E743A2031303070783B223E0D0A09266E6273703B266E6273703B266E6273703B20612E203C753E416D7061726F20646F20526571756572656E74653C2F753E3C2F703E0D0A3C70207374796C653D22746578742D696E64656E743A2031303070783B223E0D0A09266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B20457374266161637574653B20616D70617261646F2070656C6F206172742E203130206461204C6569206E266F72646D3B202E2E2E2E2C206465202E2E2E2E2E2E206465202E2E2E2E2E2E2E2E2064652032302E2E2E2E202E3C2F703E0D0A3C70207374796C653D22746578742D696E64656E743A2031303070783B223E0D0A09266E6273703B266E6273703B266E6273703B20622E203C753E45737475646F2046756E64616D656E7461646F3C2F753E3C2F703E0D0A3C70207374796C653D22746578742D696E64656E743A2031303070783B223E0D0A09266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B203129204461646F7320696E666F726D617469766F7320736F627265206F20726571756572656E74653A3C2F703E0D0A3C70207374796C653D22746578742D696E64656E743A2031303070783B223E0D0A09266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B202872656C6163696F6E6172206F73207175652073656A616D2070657274696E656E746573293C2F703E0D0A3C70207374796C653D22746578742D696E64656E743A2031303070783B223E0D0A09266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B20322920417072656369612663636564696C3B266174696C64653B6F3C2F703E0D0A3C70207374796C653D22746578742D696E64656E743A2031303070783B223E0D0A09266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B266E6273703B204F20726571756572656E746520706C656974656961202E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2C20686176656E646F20636F65722665636972633B6E63696120656E747265206F2071756520736F6C69636974612065206F28732920646973706F73697469766F2873292063697461646F28732920636F6D6F3C2F703E0D0A223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A31313B613A353A7B733A343A227469706F223B733A353A22626C6F636F223B733A353A226461646F73223B733A35303A223C70207374796C653D22746578742D696E64656E743A2031303070783B223E0D0A09332E20504152454345523C2F703E0D0A223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A31323B613A353A7B733A343A227469706F223B733A353A22626C6F636F223B733A353A226461646F73223B733A3135343A223C70207374796C653D22746578742D696E64656E743A2031303070783B223E0D0A09342E4F2070726573656E746520726571756572696D656E746F207065726D616E65636575202E2E2E2E2E20646961287329206E65737461204F4D20706172612066696E7320646520696E666F726D612663636564696C3B266174696C64653B6F206520656E63616D696E68616D656E746F2E3C2F703E0D0A223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A31333B613A353A7B733A343A227469706F223B733A31303A22617373696E6174757261223B733A353A226461646F73223B733A303A22223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A31343B613A353A7B733A343A227469706F223B733A31333A22626C6F636F5F73696D706C6573223B733A353A226461646F73223B733A303A22223B733A353A226578747261223B733A32303A227374796C653D2277696474683A32373070783B22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D7D733A31313A226D6F64656C6F5F7469706F223B733A313A2238223B733A363A2265646963616F223B623A303B733A393A22696D7072657373616F223B623A303B733A393A226D6F64656C6F5F6964223B693A303B733A393A2270617261677261666F223B693A303B733A31353A226D6F64656C6F5F6461646F735F6964223B693A303B733A363A226D6F64656C6F223B4E3B733A333A22716E74223B693A31343B7D WHERE modelo_tipo_id=8;
