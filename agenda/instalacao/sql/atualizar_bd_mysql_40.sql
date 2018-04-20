UPDATE versao SET versao_bd=40; 
UPDATE versao SET versao_codigo='7.1'; 

UPDATE pratica_modelo SET pratica_modelo_nome='FNQ 2010 1000 pontos' WHERE pratica_modelo_id=1; 

INSERT INTO pratica_modelo (pratica_modelo_id, pratica_modelo_nome, pratica_modelo_pontos, pratica_modelo_obs) VALUES 
	(8,'FNQ 2011 1000 pontos',1000,'Os Crit�rios de Excel�ncia da FNQ incorporam a seus requisitos as t�cnicas mais inovadoras e bem-sucedidas de administra��o de organiza��es. O Modelo de Excel�ncia da Gest�o� (MEG) da FNQ 2010 foi aperfei�oado principalmente para fortalecer os temas gest�o do conhecimento, inova��o e desenvolvimento de parcerias.');


INSERT INTO pratica_criterio (pratica_criterio_id, pratica_criterio_modelo, pratica_criterio_numero, pratica_criterio_nome, pratica_criterio_pontos, pratica_criterio_obs, pratica_criterio_resultado) VALUES 
 	(57,8,1,'Lideran�a',110,'Este Crit�rio aborda os processos gerenciais relativos � orienta��o filos�fica da organiza��o e controle externo sobre sua dire��o; ao engajamento, pelas lideran�as, das pessoas e partes interessadas na sua causa; e ao controle de resultados pela dire��o.',0),
  (58,8,2,'Estrat�gias e planos',60,'Este Crit�rio aborda os processos gerenciais relativos � concep��o e � execu��o das estrat�gias, inclusive aqueles referentes ao estabelecimento de metas e � defi ni��o e ao acompanhamento de planos necess�rios para o �xito das estrat�gias.',0),
  (59,8,3,'Clientes',60,'Este Crit�rio aborda os processos gerenciais relativos ao tratamento de informa��es de clientes e mercado e � comunica��o com o mercado e clientes atuais e potenciais.',0),
  (60,8,4,'Sociedade',60,'Este Crit�rio aborda os processos gerenciais relativos ao respeito e tratamento das demandas da sociedade e do meio ambiente e ao desenvolvimento social das comunidades mais infl uenciadas pela organiza��o.',0),
  (61,8,5,'Informa��o e conhecimento',60,'Este Crit�rio aborda os processos gerenciais relativos ao tratamento organizado da demanda por informa��es na organiza��o e ao desenvolvimento controlado dos ativos intang�veis geradores de diferenciais competitivos, especialmente os de conhecimento.',0),
  (62,8,6,'Pessoas',90,'Este Crit�rio aborda os processos gerenciais relativos � confi gura��o de equipes de alto desempenho, ao desenvolvimento de compet�ncias das pessoas e � manuten��o do seu bem-estar.',0),
  (63,8,7,'Processos',110,'Este Crit�rio aborda os processos gerenciais relativos aos processos principais do neg�cio e aos de apoio, tratando separadamente os relativos a fornecedores e os econ�mico-financeiros.',0),
  (64,8,8,'Resultados',450,'Este Crit�rio aborda os resultados da organiza��o na forma de s�ries hist�ricas e acompanhados de referenciais comparativos pertinentes, para avaliar o n�vel alcan�ado, e de n�veis de desempenho associados aos principais requisitos de partes interessadas, para verificar o atendimento.',1);


INSERT INTO pratica_item (pratica_item_id, pratica_item_criterio, pratica_item_numero, pratica_item_nome, pratica_item_pontos, pratica_item_obs, pratica_item_oculto) VALUES 
	(145,57,1,'Governan�a corporativa',40,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para o estabelecimento do n�vel de compromisso da organiza��o com a excel�ncia e a sustentabilidade e para a transpar�ncia e o aumento do n�vel de confian�a das partes interessadas.',0),
  (146,57,2,'Exerc�cio da lideran�a e promo��o da cultura da excel�ncia',40,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para o engajamento da for�a de trabalho e demais partes interessadas no �xito das estrat�gias e na promo��o da cultura da excel�ncia.',0),
  (147,57,3,'An�lise do desempenho da organiza��o',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para avaliar o desempenho operacional e estrat�gico da organiza��o em rela��o a metas e a informa��es comparativas do setor ou do mercado.',0),
  (148,58,1,'Formula��o das estrat�gias',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para a gera��o de estrat�gias consistentes e coerentes e de um modelo de neg�cio competitivo.',0),
  (149,58,2,'Implementa��o das estrat�gias',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para assegurar o desdobramento, a realiza��o e a atualiza��o das estrat�gias da organiza��o.',0),
  (150,59,1,'Imagem e conhecimento de mercado',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para entender as necessidades e expectativas dos clientes-alvo, para tornar produtos e marcas conhecidas e a imagem favor�vel para conquistar clientes e mercados.',0),
  (151,59,2,'Relacionamento com clientes',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para a satisfa��o dos clientes e sua fideliza��o aos produtos e marcas.',0),
  (152,60,1,'Responsabilidade socioambiental',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para a gera��o de produtos, processos e instala��es seguros aos usu�rios, � popula��o e ao meio ambiente, promovendo o desenvolvimento sustent�vel.',0),
  (153,60,2,'Desenvolvimento social',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para estimular o desenvolvimento social e para promover uma imagem favor�vel da organiza��o perante a sociedade, incluindo, eventualmente, comunidades vizinhas �s instala��es da organiza��o.',0),
  (154,61,1,'Informa��es da organiza��o',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para a disponibiliza��o sistem�tica de informa��es atualizadas, precisas e seguras para os usu�rios, com apoio da tecnologia da informa��o.',0),
  (155,61,2,'Ativos intang�veis e conhecimento organizacional',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para o aumento do diferencial competitivo da organiza��o por meio do desenvolvimento e da prote��o dos ativos intang�veis e, particularmente, dos conhecimentos que sustentam o desenvolvimento das estrat�gias e opera��es.',0),
  (156,62,1,'Sistemas de trabalho',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para o alto desempenho das pessoas e das equipes.',0),
  (157,62,2,'Capacita��o e desenvolvimento',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para a capacita��o e o desenvolvimento dos membros da for�a de trabalho',0),
  (158,62,3,'Qualidade de vida',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para a cria��o de um ambiente seguro e saud�vel e a obten��o do bem-estar, da satisfa��o e do comprometimento das pessoas.',0),
  (159,63,1,'Processos principais do neg�cio e processos de apoio',50,'Este Item aborda a implementa��o de processos gerenciais relativos aos processos principais do neg�cio e aos de apoio, cujas atividades operacionais contribuem diretamente para assegurar a gera��o de produtos excelentes para os clientes, atendendo �s necessidades e expectativas de todas as partes interessadas.',0),
  (160,63,2,'Processos relativos a fornecedores',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para o desenvolvimento e a melhoria da cadeia de suprimentos e para o comprometimento dos fornecedores e parceiros com a excel�ncia.',0),
  (161,63,3,'Processos econ�mico-financeiros',30,'Este Item aborda a implementa��o de processos gerenciais que contribuem diretamente para a sustentabilidade econ�mico-financeira da organiza��o.',0),
  (162,64,1,'Resultados econ�mico-financeiros',100,'Este Item aborda os resultados econ�mico-financeiros da organiza��o, incluindo os relativos � estrutura, � liquidez, � atividade e � rentabilidade.',0),
  (163,64,2,'Resultados relativos a clientes e ao mercado',100,'Este Item aborda os resultados relativos aos clientes e aos mercados, incluindo os referentes � imagem da organiza��o.',0),
  (164,64,3,'Resultados relativos � sociedade',60,'Este Item aborda os resultados relativos � sociedade, incluindo os referentes � responsabilidade socioambiental e ao desenvolvimento social.',0),
  (165,64,4,'Resultados relativos �s pesoas',60,'Este Item aborda os resultados relativos �s pessoas, incluindo os referentes aos sistemas de trabalho, � capacita��o e desenvolvimento e � qualidade de vida e os referentes � lideran�a de pessoas e de promo��o da cultura da excel�ncia.',0),
  (166,64,5,'Resultados relativos a processos',100,'Este Item aborda os resultados relativos ao produto e a processos principais do neg�cio e processos de apoio, bem como outros resultados de processos de gest�o.',0),
  (167,64,6,'Resultados relativos a fornecedores',30,'Este Item aborda os resultados relativos aos produtos recebidos dos fornecedores e � gest�o de fornecedores.',0);



INSERT INTO pratica_maturidade (pratica_maturidade_id, pratica_modelo_id, minimo, maximo, descricao) VALUES 
 	(29,8,0,150,'Est�gios preliminares de desenvolvimento de enfoques, quase todos reativos, associados aos fundamentos da excel�ncia, considerando os requisitos dos Crit�rios. A aplica��o � local, muitas em in�cio de uso, apresentando poucos padr�es de trabalho associados aos enfoques desenvolvidos.  O aprendizado ocorre de forma isolada, podendo haver inova��o espor�dica. N�o ocorre o refinamento e a integra��o. Ainda n�o existem resultados relevantes decorrentes de enfoques implementados. Requisitos importantes para partes interessadas n�o s�o atendidos ou monitorados.'),
  (30,8,151,250,'Os enfoques encontram-se nos primeiros est�gios de desenvolvimento para alguns itens, com pr�ticas proativas, em considera��o aos fundamentos da excel�ncia, existindo lacunas significativas na aplica��o da maioria deles. Algumas pr�ticas apresentam integra��o. Come�am a aparecer alguns resultados relevantes decorrentes da aplica��o de enfoques implementados. Muitos dos requisitos importantes para partes interessadas j� s�o atendidos.'),
  (31,8,251,350,'Enfoques adequados aos requisitos de muitos itens com proatividade, estando disseminados em algumas �reas, processos, produtos e/ou partes interessadas. Existem incoer�ncias entre as pr�ticas de gest�o e as estrat�gias, assim como existem muitas lacunas no inter-relacionamento entre as pr�ticas de gest�o. O aprendizado, o refinamento e a integra��o ocorrem para alguns itens.  Alguns resultados relevantes decorrentes da aplica��o dos enfoques, avalia��es e melhorias s�o apresentados com algumas tend�ncias favor�veis. Muitos dos requisitos importantes para partes interessadas j� s�o atendidos.'),
  (32,8,351,450,'Enfoques adequados para os requisitos da maioria dos itens, sendo alguns proativos, disseminados na maioria das �reas, processos, produtos e/ou partes interessadas, com controle das pr�ticas para muitos itens. Uso continuado para a maioria das pr�ticas. O aprendizado e a integra��o ocorrem para muitos itens. As pr�ticas de gest�o s�o coerentes com a maioria das estrat�gias da organiza��o, mas existem lacunas signifcativas no inter-relacionamento entre as pr�ticas de gest�o. Muitos resultados relevantes s�o apresentados como decorr�ncia da aplica��o dos enfoques. Alguns resultados apresentam tend�ncias favor�veis. In�cio de uso de informa��es comparativas. A maioria dos requisitos importantes para partes interessadas � atendida.'),
  (33,8,451,550,'Enfoques adequados para os requisitos de quase todos os itens, sendo v�rios deles proativos, disseminados pelas principais �reas, processos, produtos e/ou partes interessadas. Uso continuado em quase todas as pr�ticas, com controles atuantes. Existem algumas inova��es e muitos refinamentos decorrentes do aprendizado. As pr�ticas de gest�o s�o coerentes com as estrat�gias da organiza��o, existem algumas lacunas no inter-relacionamento entre as pr�ticas de gest�o, e existem muitas lacunas de coopera��o entre �reas e/ou com partes interessadas, afetando regularmente a integra��o. A maioria dos resultados apresenta tend�ncia favor�vel. N�vel atual � igual ou superior aos referenciais pertinentes para alguns resultados. A maioria dos requisitos importantes para partes interessadas � atendida.'),
  (34,8,551,650,'Enfoques adequados para os requisitos de todos os itens, sendo alguns refinados e a maioria proativos, bem disseminados pelas principais �reas, processos, produtos e/ou partes interessadas. Uso continuado em quase todas as pr�ticas. As pr�ticas de gest�o s�o coerentes com as estrat�gias da organiza��o, o refinamento decorre do aprendizado e inova��o para muitas pr�ticas do Item. Existe inter-relacionamento entre as pr�ticas de gest�o, mas ainda existem algumas lacunas de coopera��o entre �reas e/ou com partes interessadas, afetando em parte a integra��o. Quase todos os resultados apresentam tend�ncia favor�vel. O n�vel atual � igual ou superior aos referenciais pertinentes para a maioria dos resultados, podendo ser considerado l�der do ramo. Quase todos os requisitos importantes para partes interessadas s�o atendidos.'),
  (35,8,651,750,'Enfoques adequados para os requisitos de todos os itens, sendo a maioria refinada a partir de aprendizado e inova��o para muitos itens. Quase todos os requisitos s�o atendidos de forma proativa. Uso continuado em quase todas as pr�ticas, disseminadas pelas principais �reas, processos, produtos e/ou partes interessadas.Existem algumas lacunas na coopera��o entre �reas e/ou com partes interessadas, afetando eventualmente a integra��o. Quase todos os resultados apresentam tend�ncia favor�vel e nenhum apresenta tend�ncia desfavor�vel. N�vel atual superior aos referenciais pertinentes para a maioria dos resultados, sendo considerado l�der do ramo e referencial de excel�ncia em algumas �reas, processos ou produtos. Quase todos os requisitos importantes para partes interessadas s�o atendidos.'),
  (36,8,751,850,'Enfoques muito refinados, alguns inovadores proativos, com uso continuado e muito bem disseminados pelas �reas, processos, produtos e/ou partes interessadas. O aprendizado promove fortemente a inova��o. As pr�ticas entre itens e crit�rios s�o na maioria integradas. Tend�ncias favor�veis em todos os resultados. N�vel atual igual ou superior aos referenciais pertinentes para quase todos os resultados, sendo referencial de excel�ncia em muitas �reas, processos ou produtos.  Os principais requisitos para partes interessadas s�o atendidos.'),
  (37,8,851,1000,'Enfoques altamente proativos, refinados, inovadores, totalmente disseminados, com uso continuado, sustentados por um aprendizado permanente e plenamente integrados. Tend�ncias favor�veis em todos os resultados. N�vel atual igual ou superior aos referenciais pertinentes para quase todos os indicadores. Lideran�a no setor reconhecida como ?referencial de excel�ncia? na maioria das �reas, processos ou produtos. Os principais requisitos para partes interessadas s�o atendidos.');


INSERT INTO pratica_mod_campo ( pratica_mod_campo_modelo, pratica_mod_campo_nome) VALUES 
  (8,'pratica_adequada'),
  (8,'pratica_proativa'),
  (8,'pratica_continuada'),
  (8,'pratica_abrage_pertinentes'),
  (8,'pratica_refinada'),
  (8,'pratica_melhoria_aprendizado'),
  (8,'pratica_arte'),
  (8,'pratica_inovacao'),
  (8,'pratica_coerente'),
  (8,'pratica_interrelacionada'),
  (8,'pratica_cooperacao'),
  (8,'pratica_cooperacao_partes'),
  (8,'pratica_indicador_relevante'),
  (8,'pratica_indicador_favoravel'),
  (8,'pratica_indicador_superior'),
  (8,'pratica_indicador_estrategico'),
  (8,'pratica_indicador_lider'),
  (8,'pratica_indicador_excelencia'),
  (8,'pratica_indicador_atendimento');