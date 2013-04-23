-- Generated with http://www.generatedata.com
--
INSERT INTO `User` (`email`,`language`,`role`,`username`,`password`) 
VALUES ('hillary@mailinator.com','en_US','moderator','Kameko',SHA1('asdf'))
,('tanner@mailinator.com','en_US','user','Logan',SHA1('asdf'))
,('daniel@mailinator.com','en_US','user','Nevada',SHA1('asdf'))
,('branden@mailinator.com','en_US','user','Thor',SHA1('asdf'))
,('aphrodite@mailinator.com','en_US','user','Akeem',SHA1('asdf'))
,('keith@mailinator.com','en_US','user','Margaret',SHA1('asdf'))
,('yuri@mailinator.com','en_US','user','Rose',SHA1('asdf'))
,('igor@mailinator.com','en_US','user','Debra',SHA1('asdf'))
,('dennis@mailinator.com','en_US','user','Marsden',SHA1('asdf'))
,('cooper@mailinator.com','en_US','user','Ava',SHA1('asdf'))
,('armando@mailinator.com','en_US','user','Kermit',SHA1('asdf'))
,('phelan@mailinator.com','en_US','user','Tamekah',SHA1('asdf'))
,('addison@mailinator.com','en_US','user','Charlotte',SHA1('asdf'))
,('nina@mailinator.com','en_US','user','Kelsie',SHA1('asdf'))
,('felicia@mailinator.com','en_US','user','Samuel',SHA1('asdf'))
,('maya@mailinator.com','en_US','user','Pearl',SHA1('asdf'))
,('arden@mailinator.com','en_US','user','Meredith',SHA1('asdf'))
,('skyler@mailinator.com','en_US','administrator','Eric',SHA1('asdf'))
,('jillian@mailinator.com','en_US','user','Jamal',SHA1('asdf'))
,('carissa@mailinator.com','en_US','user','Oprah',SHA1('asdf'))
,('clinton@mailinator.com','en_US','user','Clio',SHA1('asdf'))
,('cora@mailinator.com','en_US','user','Bryar',SHA1('asdf'))
,('lynn@mailinator.com','en_US','moderator','Victoria',SHA1('asdf'))
,('noelani@mailinator.com','en_US','user','John',SHA1('asdf'))
,('wyatt@mailinator.com','en_US','administrator','Roanna',SHA1('asdf'))
,('knitter@wtactics.org','pt','administrator','Knitter',SHA1('asdf')) ;

-- Example data from old cardscape database, last two attributes are multivalues
INSERT INTO `Attribute` (`id`, `multivalue`) 
VALUES (1, 0), (2, 0), (3, 0), (4, 0), (5, 0), (6, 0), (7, 0), (8, 1), (9, 1) ;

INSERT INTO `AttributeI18N` (`string`, `isoCode`, `attributeId`)
VALUES ('Name', 'en_US', 1), ('nome', 'pt', 1)
, ('Sub-type', 'en_US', 2), ('Sub-tipo', 'pt', 2)
, ('Cost', 'en_US', 3), ('Custo', 'pt', 3)
, ('Threshold', 'en_US', 4), ('Limite', 'pt', 4)
, ('Attack', 'en_US', 5), ('Ataque', 'pt', 5)
, ('Defense', 'en_US', 6), ('Defesa', 'pt', 6)
, ('Rules', 'en_US', 7), ('Regras', 'pt', 7)
, ('Faction', 'en_US', 8), ('Facção', 'pt', 8)
, ('Type', 'en_US', 9), ('Tipo', 'pt', 9) ;

INSERT INTO `AttributeOption` (`id`, `key`, `attributeId`) 
VALUES (1, 'gaia', 8), (2, 'nobles', 8), (3, 'undead', 8), (4, 'redbanner', 8), (5, 'empire', 8)
, (6, 'unit', 9), (7, 'event', 9), (8, 'spell', 9), (9, 'enchantment', 9), (10, 'equipment', 9), (11, 'artifact', 9) ;

INSERT INTO `AttributeOptionI18N` (`string`, `isoCode`, `attributeOptionId`) 
VALUES ('Gaia', 'en_US', 1),('Gaia', 'pt', 1)
, ('House of Nobles', 'en_US', 2),('Casa de Nobres', 'pt', 2)
, ('Undead', 'en_US', 3),('Mortos-vivos', 'pt', 3)
, ('Red Banner', 'en_US', 4),('Estandarte Vermelho', 'pt', 4)
, ('Empire', 'en_US', 5),('Império', 'pt', 5)
, ('Unit', 'en_US', 6),('Unidade', 'pt', 6)
, ('Event', 'en_US', 7),('Event', 'pt', 7)
, ('Spell', 'en_US', 8),('Feitiço', 'pt', 8)
, ('Enchantment', 'en_US', 9),('Encantamento', 'pt', 9)
, ('Equipment', 'en_US', 10),('Equipamento', 'pt', 10)
, ('Artifact', 'en_US', 11),('Artefacto', 'pt', 11) ;

  
  
  
