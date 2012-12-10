
-- TIPOS DOCUMENTOS
INSERT INTO `tipos_documento` (`tipoid`,`nome`,`sigla`) VALUES 
    ('1', 'Cadastro de Pessoa Física'       , 'CPF'),
    ('2', 'Registro Geral'                  ,  'RG'),
    ('3', 'Registro Nacional de Estrangeiro', 'RNE')
;

-- PESSOAS
INSERT INTO `teste`.`pessoas` (`pessoaid`, `nome`, `sexo`) VALUES
	('1', 'Leonardo Castilhos Thibes', 'M'),
	('2', 'PHPUnit da Silva', 'M'),
	('3', 'PHPUnit dos Santos', 'F')
;

-- DOCUMENTOS DAS PESSOAS
INSERT INTO `teste`.`documentos` (`pessoaid`, `tipoid`, `valor`, `orgao_emissor`) VALUES 
	('1', '1', '83327932034', 'PF'),
	('1', '2', '308207-6583', 'SSP/RS'),
	('2', '1', '90969822588', 'PF'),
	('2', '2', '123456'     , 'SSP/SP'),
	('3', '3', '7896547/12' , 'CGPI/DIREX/DPF')
;

-- CONTATOS
INSERT INTO `teste`.`contatos` (`contatoid`, `pessoaid`, `email`, `ddd`, `telefone`) VALUES
    ('1', '1', 'lthibes@lidercap.com.br'       , '11', '31889811'),
    ('2', '2', 'phpunit-silva@lidercap.com.br' , '11', '31889845'),
    ('3', '3', 'phpunit-santos@lidercap.com.br', '11', '31881198'),
    ('4', '1', 'leonardothibes@yahoo.com.br'   , '11', '86369268')
;

-- USUÁRIOS
INSERT INTO `teste`.`usuarios` (`usuarioid`, `pessoaid`, `login`, `senha`, `ativo`, `criado`, `alterado`) VALUES
    ('1', '1', 'lthibes', MD5('123qwe')  , 'S', NOW(), NULL),
    ('2', '2', 'psilva' , MD5('qwe123')  , 'S', NOW(), NULL),
    ('3', '3', 'psantos', MD5('1234qwer'), 'S', NOW(), NULL)
;















