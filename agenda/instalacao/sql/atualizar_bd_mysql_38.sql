UPDATE versao SET versao_bd=38; 
UPDATE versao SET versao_codigo='6.7'; 

INSERT INTO config (config_nome, config_valor, config_grupo, config_tipo) VALUES 
('msg_precedencia','true','email_intranet','checkbox'),
('msg_class_sigilosa','true','email_intranet','checkbox');


DELETE FROM modelos_tipo WHERE modelo_tipo_id=67;

INSERT INTO modelos_tipo (modelo_tipo_id, modelo_tipo_nome, modelo_tipo_campos, descricao, imagem, organizacao) VALUES 
(67,'Ata',0x613A393A7B733A353A2263616D706F223B613A363A7B693A313B613A353A7B733A343A227469706F223B733A393A226361626563616C686F223B733A353A226461646F73223B733A303A22223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A323B613A353A7B733A343A227469706F223B733A353A22746578746F223B733A353A226461646F73223B733A303A22223B733A353A226578747261223B733A32303A227374796C653D2277696474683A31303070783B22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A333B613A353A7B733A343A227469706F223B733A353A22626C6F636F223B733A353A226461646F73223B733A3931343A223C703E0D0A09417461206461207265756E69266174696C64653B6F207265616C697A61646120266167726176653B73203134303020686F72617320646F20646961203137206465206A756C686F20646520323030302C206E612073616C61206465206F706572612663636564696C3B266F74696C64653B657320646F203137266F72646D3B204741432E3C2F703E0D0A3C703E0D0A0950726573656E746573206F732073656775696E746573206F666963696169733A2054656E2043656C20412C2053756220436D742C20717565207072657369646975206F732074726162616C686F732C204D616A20422C20532F332C204D616A20432C20532F342C2043617020442C20436D742031266F7264663B204269612043616E2C2043617020452C20436D742032266F7264663B204269612043616E2C2043617020462C20436D7420424353762C2031266F72646D3B2054656E20472C204F66204D6E742054726E702C20436170204D656420482C2043682046535220652043617020492C20532F312C20717565207365637265746172696F752061207265756E69266174696C64653B6F2E3C2F703E0D0A3C703E0D0A094162657274612061207265756E69266174696C64653B6F2070656C6F2054656E2043656C2053756220436D742C206573746520696E666F726D6F7520717565206F206D6F7469766F206461206D65736D6120657261206120656C61626F72612663636564696C3B266174696C64653B6F20646F2070726F6772616D612070617261206F206578657263266961637574653B63696F206465207469726F207265616C20612073657220656665747561646F2070656C6120556E6964616465206E6120736567756E6461207175696E7A656E61206465206A616E6569726F20646520323030312E3C2F703E0D0A3C703E0D0A09436F6D20612070616C61767261206F204D616A20532F332C2071756520696E666F726D6F7520736F627265206F206573626F2663636564696C3B6F2064612070726F6772616D612663636564696C3B266174696C64653B6F2070617261206F206578657263266961637574653B63696F202E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E2E3C2F703E0D0A3C703E0D0A094E616461206D61697320686176656E646F2061207472617461722C20266167726176653B732031373A303020686F7261732C20666F69206461646120706F7220656E636572726164612061207265756E69266174696C64653B6F2E3C2F703E0D0A223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A343B613A353A7B733A343A227469706F223B733A383A22656D5F6E6F5F6E61223B733A353A226461646F73223B733A323A22656D223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A353B613A353A7B733A343A227469706F223B733A363A22636964616465223B733A353A226461646F73223B733A303A22223B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D693A363B613A353A7B733A343A227469706F223B733A343A2264617461223B733A353A226461646F73223B4E3B733A353A226578747261223B733A303A22223B733A383A226C6172675F6D6178223B733A303A22223B733A31313A226F7574726F5F63616D706F223B733A303A22223B7D7D733A31313A226D6F64656C6F5F7469706F223B733A323A223637223B733A363A2265646963616F223B623A303B733A393A22696D7072657373616F223B623A303B733A393A226D6F64656C6F5F6964223B693A303B733A393A2270617261677261666F223B693A303B733A31353A226D6F64656C6F5F6461646F735F6964223B693A303B733A363A226D6F64656C6F223B4E3B733A333A22716E74223B693A363B7D,'� um documento que registra resumidamente e com clareza as ocorr�ncias, delibera��es, resolu��es e decis�es de reuni�es ou assembl�ias.','ata.gif',1);
