-- Generated with http://www.generatedata.com
--
INSERT INTO `User` (`email`,`language`,`role`,`username`,`password`) 
VALUES ('hillary@mailinator.com','en','moderator','Kameko',SHA1('asdf'))
,('tanner@mailinator.com','en','user','Logan',SHA1('asdf'))
,('daniel@mailinator.com','en','user','Nevada',SHA1('asdf'))
,('branden@mailinator.com','en','user','Thor',SHA1('asdf'))
,('aphrodite@mailinator.com','en','user','Akeem',SHA1('asdf'))
,('keith@mailinator.com','en','user','Margaret',SHA1('asdf'))
,('yuri@mailinator.com','en','user','Rose',SHA1('asdf'))
,('igor@mailinator.com','en','user','Debra',SHA1('asdf'))
,('dennis@mailinator.com','en','user','Marsden',SHA1('asdf'))
,('cooper@mailinator.com','en','user','Ava',SHA1('asdf'))
,('armando@mailinator.com','en','user','Kermit',SHA1('asdf'))
,('phelan@mailinator.com','en','user','Tamekah',SHA1('asdf'))
,('addison@mailinator.com','en','user','Charlotte',SHA1('asdf'))
,('nina@mailinator.com','en','user','Kelsie',SHA1('asdf'))
,('felicia@mailinator.com','en','user','Samuel',SHA1('asdf'))
,('maya@mailinator.com','en','user','Pearl',SHA1('asdf'))
,('arden@mailinator.com','en','user','Meredith',SHA1('asdf'))
,('skyler@mailinator.com','en','administrator','Eric',SHA1('asdf'))
,('jillian@mailinator.com','en','user','Jamal',SHA1('asdf'))
,('carissa@mailinator.com','en','user','Oprah',SHA1('asdf'))
,('clinton@mailinator.com','en','user','Clio',SHA1('asdf'))
,('cora@mailinator.com','en','user','Bryar',SHA1('asdf'))
,('lynn@mailinator.com','en','moderator','Victoria',SHA1('asdf'))
,('noelani@mailinator.com','en','user','John',SHA1('asdf'))
,('wyatt@mailinator.com','en','administrator','Roanna',SHA1('asdf'))
,('knitter@wtactics.org','pt_PT','administrator','Knitter',SHA1('asdf')) ;

-- Example data from old cardscape database, last two attributes are multivalues
INSERT INTO `Attribute` (`id`, `multivalue`) 
VALUES (1, 0), (2, 0), (3, 0), (4, 0), (5, 0), (6, 0), (7, 0), (8, 1), (9, 1) ;

INSERT INTO `AttributeI18N` (`string`, `isoCode`, `attributeId`)
VALUES ('Name', 'en', 1), ('nome', 'pt_PT', 1)
, ('Sub-type', 'en', 2), ('Sub-tipo', 'pt_PT', 2)
, ('Cost', 'en', 3), ('Custo', 'pt_PT', 3)
, ('Threshold', 'en', 4), ('Limite', 'pt_PT', 4)
, ('Attack', 'en', 5), ('Ataque', 'pt_PT', 5)
, ('Defense', 'en', 6), ('Defesa', 'pt_PT', 6)
, ('Rules', 'en', 7), ('Regras', 'pt_PT', 7)
, ('Faction', 'en', 8), ('Facção', 'pt_PT', 8)
, ('Type', 'en', 9), ('Tipo', 'pt_PT', 9) ;

INSERT INTO `AttributeOption` (`id`, `key`, `attributeId`) 
VALUES (1, 'gaia', 8), (2, 'nobles', 8), (3, 'undead', 8), (4, 'redbanner', 8), (5, 'empire', 8)
, (6, 'unit', 9), (7, 'event', 9), (8, 'spell', 9), (9, 'enchantment', 9), (10, 'equipment', 9), (11, 'artifact', 9) ;

INSERT INTO `AttributeOptionI18N` (`string`, `isoCode`, `attributeOptionId`) 
VALUES ('Gaia', 'en', 1),('Gaia', 'pt_PT', 1)
, ('House of Nobles', 'en', 2),('Casa de Nobres', 'pt_PT', 2)
, ('Undead', 'en', 3),('Mortos-vivos', 'pt_PT', 3)
, ('Red Banner', 'en', 4),('Estandarte Vermelho', 'pt_PT', 4)
, ('Empire', 'en', 5),('Império', 'pt_PT', 5)
, ('Unit', 'en', 6),('Unidade', 'pt_PT', 6)
, ('Event', 'en', 7),('Event', 'pt_PT', 7)
, ('Spell', 'en', 8),('Feitiço', 'pt_PT', 8)
, ('Enchantment', 'en', 9),('Encantamento', 'pt_PT', 9)
, ('Equipment', 'en', 10),('Equipamento', 'pt_PT', 10)
, ('Artifact', 'en', 11),('Artefacto', 'pt_PT', 11) ;

  
  
  
