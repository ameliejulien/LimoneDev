SET SCHEMA 'limone';

INSERT INTO adresse
(adresse, ville_adresse, code_postal_adresse, facturation_adresse)
VALUES
('56 rue du Château', 'Saint-germain-en-laye', '78100', false),
('9 rue de la République', 'Lyon', '69004', false),
('48 rue du Château', 'Saint-Etienne-du-rouvray', '76800', true),
('67 rue du Clair Bocage', 'La Teste-de-buch', '33260', false),
('44 Place Napoléon', 'Laval', '53000', false),
('1 Rue Jean Jaures', 'Quimper', '29000', false),
('9 Rue Saint-Marc', 'Brest', '29200', false),
('2 Place du Guesclin', 'Saint-Brieuc', '22000', false),
('2 Rue des Fosses', 'Rennes', '35000', false),
('70 rue Beauvau', 'Marseille', '13004', true);

INSERT into type 
(nom_type)
VALUES
('CLIENT'),
('VENDEUR'),
('GESTIONNAIRE');

INSERT INTO utilisateur
(email_utilisateur, nom_utilisateur, mdp_utilisateur, type_utilisateur, telephone_utilisateur)
VALUES
('breizhshop@contact.com','breizhShop', 'd501584ae0f8c23b0db121b36dba1d80a4ec27964e8248efe8b7fa55414b953c', 1,0605040302),
('bretagneunivers@contact.com', 'bretagne_univers', 'd501584ae0f8c23b0db121b36dba1d80a4ec27964e8248efe8b7fa55414b953c', 1,0708090100),
('ievcorp@contact.com', 'IveCorp', 'd501584ae0f8c23b0db121b36dba1d80a4ec27964e8248efe8b7fa55414b953c', 1,0203040506);

INSERT INTO vendeur
(id_vendeur, denomination_vendeur, siret_vendeur, addresse_vendeur)
VALUES
(1, 'BREIZH-SHOP', 67676767676767, 6),
(2, 'BRETAGNE-UNIVERS', 12458409162345, 7),
(3, 'IEV-CORP', 08678429865878, 8);

INSERT INTO produit
(nom_produit, description_produit, prix_ht_produit, stock_produit, catalogue_produit, promotion_produit, reduction_produit, tva_produit, produit_supprime, vendeur_produit, nb_ventes_produit)
VALUES
('Kouign-amann 400g', 'Pâtisserie boulangère et une spécialité culinaire emblématique de la cuisine bretonne, vendu en gâteau de 400g', 14.30, 100, true, false, 0.0, 20.0, false, 2, 15),
('Kouign-amann 800g', 'Pâtisserie boulangère et une spécialité culinaire emblématique de la cuisine bretonne, vendu en gâteau de 800g', 24.30, 100, true, false, 0.0, 20.0, false, 2, 12),
('Galettes au Beurre 300g', 'Galettes Bretonnes pur beurre vendues en barquette de 300g', 5.50, 300, true, false, 0.0, 20.0, false, 2, 87),
('Galettes au Beurre 500g', 'Galettes Bretonnes pur beurre vendues en barquette de 500g', 7.00, 300, true, false, 0.0, 20.0, false, 2, 67),
('Galettes au Beurre 800g', 'Galettes Bretonnes pur beurre vendues en barquette de 800g', 10.30, 300, true, false, 0.0, 20.0, false, 2, 21),
('Petites galettes blé noir et chocolat 100g', 'Petites galettes au blé noir et pépites de chocolat fabriquées à Erquy vendues en sachat de 100g', 4.20, 100, true, false, 0.0, 20.0, false, 2, 24),
('Petites galettes blé noir et chocolat 200g', 'Petites galettes au blé noir et pépites de chocolat fabriquées à Erquy vendues en sachat de 200g', 7.40, 100, true, false, 0.0, 20.0, false, 2, 1),
('Chouchenn d''Armor 37,5cl', 'Délicieuse boisson proche de l''hydromel, à base d''eau, de miel et de moût de pomme. A consommer à l''apéritif ou au digestif', 9.20, 100, true, false, 0.0, 20.0, false, 1, 4),
('Chouchenn d''Armor 75cl', 'Délicieuse boisson proche de l''hydromel, à base d''eau, de miel et de moût de pomme. A consommer à l''apéritif ou au digestif', 14.40, 200, true, false, 0.0, 20.0, false, 1, 11),
('Apéritifs Bretons', '3 mignonettes dans un coffret aux couleurs de la Bretagne : Pastis 45% 4cl, Apéritif de Bretagne 17% 4cl, Hydromel Chouchen 13% 4cl', 14.10, 150, true, false, 0.0, 20.0, false, 1, 34),
('Cidre brut 75cl', 'Cidre Breton brut parfait pour accompagner la galette', 5.10, 200, true, false, 0.0, 20.0, false, 1, 34),
('Cidre doux 75cl', 'Cidre Breton doux parfait pour accompagner la galette', 5.10, 200, true, false, 0.0, 20.0, false, 1, 90),
('Cidre rosé 75cl', 'Cidre Breton rosé parfait pour accompagner la galette', 6.90, 200, true, false, 0.0, 20.0, false, 1, 102),
('Breizh Whisky 70cl', 'Parfait équilibre entre whisky de malt et whisky de grain, un vieillisement en fûts de chêne traditionnels', 39.90, 200, true, false, 0.0, 20.0, false, 1, 34),
('Coreff Ambrée 33cl', 'Bière ambré de haute fermentation, sa mousse fine et naturelle est une invitation à la dégustation.', 3.60, 200, true, false, 0.0, 20.0, false, 1, 35),
('Coreff Blanche 33cl', 'Bière blanche coreff rafraîchissante avec des arômes de citron, d''orange et de coriandre.', 3.60, 200, true, false, 0.0, 20.0, false, 1, 78),
('Coreff Blonde 33cl', 'Bière blonde légère de haute fermentation à la robe jaune dorée, un nez malté et houblonné', 3.60, 200, true, false, 0.0, 20.0, false, 1, 12),
('Coreff Blonde Bio 33cl', 'Bière blonde légère de haute fermentation à la robe jaune dorée, un nez malté et houblonné', 3.60, 200, true, false, 0.0, 20.0, false, 1, 43),
('Coreff Brune 33cl', 'Bière de haute fermentation, la brune est la plus dense de notre gamme.', 3.60, 200, true, false, 0.0, 20.0, false, 1, 11),
('Bolée a anse noire et bleu', 'Bolée à anse en grès véritable. Magnifique couleur noir à l''extérieur et bleu à l''intérieur.', 6.90, 100, true, false, 0.0, 20.0, false, 3, 22),
('Bolée a anse noire et orange', 'Bolée à anse en grès véritable. Magnifique couleur noir à l''extérieur et orange à l''intérieur.', 6.90, 100, true, false, 0.0, 20.0, false, 3, 9),
('Bolée a anse “Abysse”', 'Bolée à anse en grès véritable. Magnifique dégradé de couleur du bleu ciel au bleu foncé.', 6.90, 100, true, false, 0.0, 20.0, false, 3, 0),
('Bolée a anse “Estran”', 'Bolée à anse en grès véritable. Magnifique couleur grès bleu turquoise et marron.', 6.90, 100, true, false, 0.0, 20.0, false, 3, 6),
('Bolée a anse bleu mouchette', 'Bolée à anse en grès véritable. Magnifique couleur bleu moucheté.', 6.90, 100, true, false, 0.0, 20.0, false, 3, 5),
('Bolée a anse vert de gris', 'Bolée à anse en grès véritable. Magnifique couleur vert de gris.', 6.90, 100, true, false, 0.0, 20.0, false, 3, 2),
('Bolée sans anse triskell gris/turquoise', 'Bolée sans anse en grès véritable. Magnifique couleur gris Triskell l''extérieur et turquoise à l''intérieur.', 6.80, 100, true, false, 0.0, 20.0, false, 3, 45),
('Bouchées caramel au beurre salé 60g', 'Une présentation originale et atypique, idéale pour disposer sur une table, offrir à votre famille, vos amis ou encore pour vous faire plaisir.', 2.50, 100, true, false, 0.0, 20.0, false, 2, 23),
('Butternut au lait de coco et citronnelle - Hénaff', 'Une découverte gustative unique ! Cette terrine associe la douceur de la butternut à l''onctuosité du lait de coco et à la fraîcheur de la citronnelle.', 4.20, 150, true, false, 0.0, 20.0, false, 1, 3),
('Financiers pistache', 'Vous allez fondre pour nos financiers à la pistache, des petits gâteaux délicats qui raviront vos papilles.', 4.50, 150, true, false, 0.0, 20.0, false, 2, 34),
('Gavottes au chocolat noir 130g', 'Les Gavottes chocolat noir sont nos compagnes, plaisir du quotidien. C''est l''alliance de la cuisine bretonne et de l''onctuosité du chocolat noir.', 5.90, 220, true, false, 0.0, 20.0, false, 2, 12),
('Gavottes au chocolat au lait 100g', 'Les Gavottes chocolat au lait sont nos compagnes, plaisir du quotidien. C''est l''alliance de la cuisine bretonne et de l''onctuosité du chocolat au lait.', 9.60, 220, true, false, 0.0, 20.0, false, 2, 88),
('Gavottes au chocolat au lait 180g', 'Les Gavottes chocolat au lait sont nos compagnes, plaisir du quotidien. C''est l''alliance de la cuisine bretonne et de l''onctuosité du chocolat au lait.', 11.90, 220, true, false, 0.0, 20.0, false, 2, 23),
('Palets Bretons - La pointe du Raz', 'Elaborés avec une pâte brisée au beurre de baratte frais, ces palets bretons à la saveur inimitable et à la délicieuse odeur, séduiront les gourmands petits comme grands !', 2.75, 210, true, false, 0.0, 20.0, false, 2, 43),
('5 crêpes au rhum', 'Ce pot de 5 crêpes au rhum, est un dessert gourmand déjà prêt qui est élaboré dans la pure tradition pâtissière française.', 14.60, 220, true, false, 0.0, 20.0, false, 2, 33),
('6 Babas à la liqueur Grand Marnier', 'Le fameux Baba à la liqueur Grand Marnier et ses multiples variantes, appelé aussi savarin, est un gâteau servi imbibé d''un sirop à l''alcool.', 11.20, 90, true, false, 0.0, 20.0, false, 2, 23),
('6 Babas au rhum', 'Le fameux Baba au rhum et ses multiples variantes, appelé aussi savarin, est un gâteau servi imbibé d''un sirop au rhum.', 7.70, 85, true, false, 0.0, 20.0, false, 2, 34),
('Mini madelaines caramel beurre salé', 'Ces madeleines au caramel beurre salé en forme de coquillage sont de véritables douceurs cuisinées avec les ingrédients les plus simples: de la farine, du beurre et des œufs.', 6.20, 104, true, false, 0.0, 20.0, false, 2, 54),
('Assortiment Verger 100g', 'BONBONS ENVELOPPES  FOURRES PUR FRUITS ASSORTIS', 9.5, 23, true, false, 0.00, 20.0, false, 2, 43),
('Gavottes nature 125', 'Les Gavottes nature sont nos compagnes, plaisir du quotidien, c''est LA recette de la crêpe dentelle dans une cuisine bretonne.', 4.20, 300, true, false, 0.0, 20.0, false, 2, 11),
('Gelée de cassis 370g', 'La Gelée de cassis en pot de 370g est un concentré de bienfaits naturels, délicieuse variante de la confiture de cassis.', 6.90, 109, true, false, 0.0, 20.0, false, 2, 34),
('Gelée de groseilles 370g', 'La Gelée de groseilles en pot de 370g est un concentré de bienfaits naturels, délicieuse variante de la confiture de groseilles.', 6.90, 81, true, false, 0.0, 20.0, false, 2, 56),
('Gelée de pommes 370g', 'La Gelée de pommes en pot de 370g est un concentré de bienfaits naturels, délicieuse variante de la confiture de pommes.', 6.90, 56, true, false, 0.0, 20.0, false, 2, 2),
('Pointe Framboise', 'Fabriqué dans notre atelier à Erquy (22), ce gâteau breton fourré à la framboise se déguste en toute saison, excellent moyen pour profiter des bienfaits des framboises toute l''année.', 7.90, 31, true, false, 0.0, 20.0, false, 2, 7),
('Pointe Pruneau', 'Fabriqué dans notre atelier à Erquy (22), ce gâteau breton fourré au pruneau se déguste en toute saison, excellent moyen pour profiter des bienfaits du pruneau toute l''année.', 7.90, 33, true, false, 0.0, 20.0, false, 2, 43),
('Punchs sachet individuel de 4', 'Le punch est une des plus anciennes galettes bretonnes commercialisées, originaire de la ville d''Uzel, dans les Côtes d''Armor. Une fine galette que l''on croque avec envie, plus fine que la galette bretonne et le palet breton pur beurre.', 9.90, 78, true, false, 0.0, 20.0, false, 2, 10),
('Bisque de homard 480g', 'La bisque de homard avec de la fleur de sel est une soupe réalisée à partir de homard et de crème fraiche.', 7.70, 24, true, false, 0.0, 20.0, false, 1, 18),
('Croûtons ail 75g', 'Délicieux croûtons à l''ail', 2.40, 12, true, false, 0.0, 20.0, false, 1, 13),
('Croûtons nature 75g', 'Délicieux croûtons nature', 2.40, 57, true, false, 0.0, 20.0, false, 1, 11),
('Filets de maquereaux marinés au vin blanc 176g', 'Délicieux filets de maquereaux marinés au vin blanc', 8.30, 89, true, false, 0.0, 20.0, false, 1, 23),
('Fleur de sel de Guérande 250g', 'La fleur de sel de Guérande en sachet de 250g, appelé aussi or blanc, est le résultat des premiers cristaux qui se forment avec l''évaporation de l''eau de mer, et ramassé très délicatement.', 6.90, 90, true, false, 0.0, 20.0, false, 1, 29),
('Fleur de sel de Guérande 500g', 'La fleur de sel de Guérande en sachet de 500g, appelé aussi or blanc, est le résultat des premiers cristaux qui se forment avec l''évaporation de l''eau de mer, et ramassé très délicatement.', 11.90, 68, true, false, 0.0, 20.0, false, 1, 9),
('Gros sel de Guérande 1Kg', 'Le sel de Guérande est bien plus que du simple sel ou du chlorure de sodium. Ce sel regorge de nutriments essentiels et contient de multiples richesses issues de la mer.', 2.30, 54, true, false, 0.0, 20.0, false, 1, 4),
('Gros sel de Guérande aux algues marines 400g', 'Sel de Guérande non traité, non raffiné 95%, algues de Bretagne 5%', 6.50, 49, true, false, 0.0, 20.0, false, 1, 52),
('Moutarde au miel 200g', 'Parfait équilibre entre l''onctuosité du miel et le piquant de la moutarde, ce pot de moutarde au miel 200g recèle de ce supplément d''âme qui, au-delà du simple assaisonnement, apportera une note acidulée à vos assiettes', 3.80, 21, true, false, 0.0, 20.0, false, 1, 45),
('Moutarde au miel à l''ancienne 200g', 'Délicieuse moutarde au miel à l''ancienne vendue en pot de 200g', 3.80, 13, true, false, 0.0, 20.0, false, 1, 78),
('Moutarde au miel à l''échalote 200g', 'Parfait équilibre entre l''onctuosité du miel, le piquant de la moutarde et la subtilité de l''échalote', 3.80, 20, true, false, 0.0, 20.0, false, 1, 90),
('Moutarde au miel aux 3 poivres 200g', 'Parfait équilibre entre l''onctuosité du miel, le piquant de la moutarde et la subtilité des 3 poivres', 3.80, 26, true, false, 0.0, 20.0, false, 1, 99),
('Moutarde au miel aux algues 200g', 'Parfait équilibre entre l''onctuosité du miel, le piquant de la moutarde et l''originalité des algues', 3.80, 38, true, false, 0.0, 20.0, false, 1, 76),
('Moutarde au miel aux oignons 200g', 'Parfait équilibre entre l''onctuosité du miel, le piquant de la moutarde et la puissance de l''oignon', 3.80, 20, true, false, 0.0, 20.0, false, 1, 89),
('Moutarde au miel, ail et persil 200g', 'Parfait équilibre entre l''onctuosité du miel, le piquant de la moutarde et la puissance de l''ail et du persil', 3.80, 59, true, false, 0.0, 20.0, false, 1, 54),
('Moutarde au pain d''épices 200g', 'Parfait équilibre le piquant de la moutarde et l''originalité du pain d''épices', 3.80, 40, true, false, 0.0, 20.0, false, 1, 23),
('Raviolis de poisson au coulis de Langoustines 400g', 'La conserve de raviolis de poisson au coulis de langoustines est un produit qui allie à merveille la culture italienne et bretonne. La légèreté des langoustines et l''incroyable texture des raviolis nous offrent un déluge de saveurs et d''arôme.', 7.90, 27, true, false, 0.0, 20.0, false, 1, 56),
('Rillettes 7 x 78g', 'Assortiment de rillettes de thon, thon à l''estragon, thon à l''algue wakamé, maquereaux aux zestes de citron, maquereaux aux fines algues, sardines aux deux épices et de saumon', 29.90, 31, true, false, 0.0, 20.0, false, 1, 88),
('Rillettes au crabe tourteau 90g', 'Dégustez ces délicieuses rillettes à base de chair de crabe tourteau pour un apéritif riche en saveurs.', 6.10, 4, true, false, 0.00, 20.0, false, 1, 64),
('Rillettes de Saint Jacques au caramel 140g', 'Cuisinées avec du délicieux caramel au beurre salé, ces rillettes de noix de saint jacques réveilleront vos papilles par leurs fibres délicates.', 7.70, 21, true, false, 0.0, 20.0, false, 1, 55),
('Rouille 90g', 'L''authentique rouille préparée en Bretagne pour accompagner vos soupes de poisson', 3.60, 200, true, false, 0.0, 20.0, false, 1, 90),
('Salade océane 45g', 'De fabrication artisanale, la salade océane dispose d''une présentation en paillettes 100% naturelles. Elle est un mélange de trois algues marines (nori, laitue de mer, dulse) récoltées sur le littoral breton', 7.40, 103, true, false, 0.0, 20.0, false, 1, 33),
('Salicornes à la marinade 21cl', 'Nous vous proposons la salicorne à la marinade qui remplace les cornichons. C''est un délicieux légume à servir revenu à la poêle ou cuit à l''eau.', 4.30, 76, true, false, 0.0, 20.0, false, 1, 44),
('Salicornes à la marinade 37cl', 'Nous vous proposons la salicorne à la marinade qui remplace les cornichons. C''est un délicieux légume à servir revenu à la poêle ou cuit à l''eau.', 5.80, 37, true, false, 0.0, 20.0, false, 1, 99),
('Salicornes au naturel 21cl', 'Nous vous proposons la salicorne au naturel qui remplace les cornichons. C''est un délicieux légume à servir revenu à la poêle ou cuit à l''eau.', 4.20, 22, true, false, 0.0, 20.0, false, 1, 19),
('Salicornes au naturel 37cl', 'Nous vous proposons la salicorne au naturel qui remplace les cornichons. C''est un délicieux légume à servir revenu à la poêle ou cuit à l''eau.', 5.50, 44, true, false, 0.0, 20.0, false, 1, 04),
('Accroche-sac breton - Drapeau breton', 'Cet objet astucieux, hygiénique et rassurant se déploie en un instant pour suspendre votre sac en toute sécurité au bord d''une table ou d''un comptoir.', 9.95, 26, true, false, 0.0, 20.0, false, 3, 6),
('Accroche-sac breton - Triskell', 'Cet objet astucieux, hygiénique et rassurant se déploie en un instant pour suspendre votre sac en toute sécurité au bord d''une table ou d''un comptoir.', 9.95, 26, true, false, 0.0, 20.0, false, 3, 41),
('Accroche-sac breton - Arbre de vie celtique', 'Cet objet astucieux, hygiénique et rassurant se déploie en un instant pour suspendre votre sac en toute sécurité au bord d''une table ou d''un comptoir.', 9.95, 26, true, false, 0.0, 20.0, false, 3, 35),
('Gressins sucrés au sarrasin - 90g', 'Ces gressins bretons sucrés au sarrasin signés Mademoiselle Breizh incarnent une revisite audacieuse de la galette bretonne de blé noir traditionnelle. Confectionnés de manière artisanale, ils se présentent sous la forme de fines cigarettes délicatement roulées.', 4.95, 12, true, false, 0.0, 20.0, false, 2, 72),
('Farine de blé noir/sarrasin - 500g', 'Elaborée de A à Z par leurs propres soins, du semis jusque dans le sachet, la farine de sarrasin artisanale de la Ferme de la Belle Noé est entièrement produite sur les terres d''Edwige et Sébastien', 2.95, 21, true, false, 0.0, 20.0, false, 2, 84),
('Caramels bretons au beurre salé Bordier 1kg', 'Préparés en Bretagne à partir de matières nobles telles que du beurre Bordier (le beurre d''exception des chefs étoilés) et de la nacre de sel de Millac. Des caramels haut-de-gamme au goût inimitable, 100% naturels et artisanaux sans additifs.', 39.95, 45, true, false, 0.0, 20.0, false, 2, 78),
('Beurrier décor Bretagne et Hermines', 'Ce joli beurrier rectangulaire affiche fièrement les couleurs de la Bretagne, avec ses lignes noires et ses hermines intemporelles.', 18.95, 33, true, false, 0.0, 20.0, false, 3, 14),
('Couteau à beurre - Hénaff Sélection', 'Ce petit couteau à tartiner estampillé Hénaff Sélection dispose d''une lame courte et arrondie parfaitement utile pour étaler facilement beurre, rilettes, fromage frais ou autres pâtés bretons', 4.95, 27, true, false, 0.0, 20.0, false, 3, 55),
('Beurrier breton rond artisanal peint main - Avel douar', 'Ce beurrier breton rond fabriqué en Bretagne apportera un charme fou à votre table tout en protégeant votre motte de beurre de l''humidité, des odeurs et de l''oxydation dans le réfrigérateur.', 48.0, 27, true, false, 0.0, 20.0, false, 3, 22),
('Beurrier breton rond artisanal peint main - Avel-Dro', 'Ce beurrier breton rond fabriqué en Bretagne apportera un charme fou à votre table tout en protégeant votre motte de beurre de l''humidité, des odeurs et de l''oxydation dans le réfrigérateur.', 48.0, 27, true, false, 0.0, 20.0, false, 3, 33),
('Beurrier breton rond artisanal peint main - Brizig Avel', 'Ce beurrier breton rond fabriqué en Bretagne apportera un charme fou à votre table tout en protégeant votre motte de beurre de l''humidité, des odeurs et de l''oxydation dans le réfrigérateur.', 48.0, 27, true, false, 0.0, 20.0, false, 3, 37),
('Beurrier breton rectangulaire artisanal - Avel-Dro', 'Ce beurrier artisanal breton Avel-Dro (Tornade, en Breton) présentera avec raffinement et élégance votre beurre sur votre table ! Son volume conviendra parfaitement aux plaquettes de beurre de 250g à 500g.', 58.0, 11, true, false, 0.0, 20.0, false, 3, 46),
('Beurrier breton rectangulaire artisanal - Avel douar', 'Ce beurrier fabriqué en Bretagne Avel douar (Vent de terre, en breton) vous charmera par son originalité sans pareille. Son volume conviendra parfaitement aux plaquettes de beurre de 250g à 500g.', 58.0, 10, true, false, 0.0, 20.0, false, 3, 45),
('Couteau à beurre marinière ancre', 'Ce petit couteau à beurre marin blanc, entouré de 3 rayures bleues et orné d''une ancre marine en dessous, vous permettra de bien tartiner beurres, rillettes et autres tartinables', 4.45, 78, true, false, 0.0, 20.0, false, 3, 78),
('Couteau à beurre drapeau breton flottant', 'Ce petit couteau à beurre est orné du célèbre drapeau de la Bretagne “Gwenn ha du” (Blanc et noir, en breton) : il sera extrêmement pratique pour tartiner du beurre, rillettes et autres tartinables', 4.45, 76, true, false, 0.0, 20.0, false, 3, 1),
('Poire Chocolat à la Fleur de Sel', 'Une délicieuse préparation de fruits riche en goût et beaucoup moins sucrée qu''une confiture. De quoi apprécier davantage la saveur du fruit ! Une combinaison gourmande qui ravira les amateurs de poire et de chocolat.', 5.60, 52, true, false, 0.0, 20.0, false, 2, 49),
('Pomme, Pommeau et Beurre Salé', 'Une délicieuse préparation de fruits riche en goût et beaucoup moins sucrée qu''une confiture. De quoi apprécier davantage la saveur du fruit ! La combinaison de la pomme, du pommeau de Bretagne et du beurre salé vous transportera vers l''Ouest !', 5.60, 31, true, false, 0.0, 20.0, false, 2, 7),
('Florentins Chocolat Noir', 'Découvrez cette spécialité bretonne composée d''une délicate nougatine d''amandes effilées, de caramel au beurre salé et de fruits confits enrobés de délicieux chocolat noir.', 3.50, 90, true, false, 0.0, 20.0, false, 2, 48),
('Florentins Chocolat au lait', 'Découvrez cette spécialité bretonne composée d''une délicate nougatine d''amandes effilées, de caramel au beurre salé et de fruits confits enrobés de délicieux chocolat au lait.', 3.50, 94, true, false, 0.0, 20.0, false, 2, 39),
('Confiture Pêche - Melon au caramel au miel', 'Savourez cette délicieuse recette artisanale et originale pour un moment ensoleillé et gourmand. Quand le melon rencontre la pêche et le caramel...', 5.95, 29, true, false, 0.0, 20.0, false, 2, 71),
('Confiture de Lait - Noisette Beurre Salé', 'Découvrez cette recette ancestrale de confiture de lait, au véritable concentré d''arômes. Obtenue en faisant cuire du sucre avec du lait, cette délicieuse confiture de lait ne vous laissera pas insensible !', 2.80, 3, true, false, 0.0, 20.0, false, 2, 80),
('Crakou Breton Caramel et Noisette', 'Véritable spécialité bretonne, le crakou est une délicieuse tuile de biscuit irrésistible et croustillante au goût de noisette caramélisée. Le crakou vous séduira par son craquant et sa finesse inimitable !', 7.20, 88, true, false, 0.0, 20.0, false, 2, 12),
('Panier Gournmand - Le Breton Sucré', 'Partez à la découverte de spécialités bretonnes sucrées à travers ce panier gourmand composé de galettes et palets bretons au beurre de baratte frais, du fameux Kouign Amann breton bio, de délicieux caramels au beurre salé, d''une savoureuse préparation de fruits bretonne et d''une onctueuse crème de caramel 100% artisanale.', 38.70, 71, true, false, 0.0, 20.0, false, 3, 56),
('Panier Gourmand - Les douceurs de Bretagne', 'Découvrez les joies sucrées de la Bretagne à travers ce panier gourmand riche en bonnes choses, de délicieux palets et galettes bretonnes au beurre frais de baratte, de savoureux caramels au beurre salé, une onctueuse crème de caramel au beurre salé et aux noisettes grillées, une mini tablette de chocolat au lait à la crème de salidou, comme la recette de nos grand-mère autrefois, ainsi que les fameux florentins au chocolat.', 29.90, 22, true, false, 0.0, 20.0, false, 3, 72),
('Box - Crêpes Partie', 'Un cidre fermier doux artisanal, une délicieuse crème de caramel au chocolat et fleur de sel pour napper vos crêpes et desserts, une douce confiture de fraise de Plougastel et une confiture de lait riche en noisettes et beurre salé, pour accompagner vos moments gourmands tout en saveur.', 28.50, 32, true, false, 0.0, 20.0, false, 3, 60),
('Panier Gourmand - Les délices de Bretagne', 'Embarquez pour un voyage sucré en plein coeur de la Bretagne avec ce panier gourmand riche en gourmandises et en saveurs. Vous y dégusterez de délicieux palets bretons, des galettes bretonnes, une onctueuse confiture de lait artisanale à la fleur de sel de Guérande, de succulents caramels tendres au beurre salé et pour les amateurs de chocolat, une mini tablette de chocolat au lait à la crème de salidou, ainsi que de délicieux œufs de mouette au chocolat et caramel.', 40.90, 29, true, false, 0.0, 20.0, false, 3, 40),
('Panier Gourmand - Bulles et Gourmandises à la Bretonne', 'A travers ce panier gourmand, nous vous invitons à partir à la découverte de la gastronomie sucrée bretonne avec un cidre doux artisanal , une délicieuse confiture de fraise de Plougastel riche en fruits et en goût, des palets et galettes bretonnes au beurre de baratte frais, une boîte de tendres caramels au beurre salé, de délicieux florentins, ainsi que des petites sardines au chocolat au lait fraichement pêchées pour le plus grand plaisir des gourmands !', 41.00, 78, true, false, 0.0, 20.0, false, 3, 28),
('Box - Chandeleur Gourmande', 'Régalez vous en tartinant sur vos crêpes une délicieuse confiture de lait noisette et beurre salé, une onctueuse crème de salidou, une délicate crème de caramel au chocolat et fleur de sel et pour finir une somptueuse combinaison de pomme, caramel à la bretonne. Pour plus de goût et de partage, un jus de pomme artisanal accompagne ces douceurs.', 33.90, 65, true, false, 0.0, 20.0, false, 3, 80),
('Panier Garni Breton - L''Original', 'Rafraîchissez vous avec un cidre fermier demi-sec et régalez vous avec les fameux Crakou Bretons, une délicieuse préparation de fruits, de croustillantes palourdes au caramel croustillant et praliné , une onctueuse crème caramel à la noisette grillée, pour le reste, nous vous laissons la surprise !', 50.90, 40, true, false, 0.0, 20.0, false, 3, 23);

INSERT INTO categorie
(id_categorie, nom_categorie)
VALUES
(1, 'Pâtisseries & Biscuits'),
(2, 'Boissons'),
(3, 'Arts de la table'),
(4, 'Épicerie salée'),
(5, 'Confitures & Gelées'),
(6, 'Paniers & Coffrets');

INSERT INTO categorie_produit
(id_produit, id_categorie)
VALUES
-- Pâtisseries & Biscuits
(1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),
(27,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),
(43,1),(44,1),(45,1),(75,1),(76,1),(77,1),(87,1),(88,1),(89,1),(90,1),(93,1),
-- Boissons
(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(17,2),(18,2),(19,2),
-- Arts de la table
(20,3),(21,3),(22,3),(23,3),(24,3),(25,3),(26,3),
(72,3),(73,3),(74,3),(78,3),(79,3),(80,3),(81,3),(82,3),(83,3),(84,3),(85,3),(86,3),
-- Épicerie salée
(28,4),(46,4),(47,4),(48,4),(49,4),(50,4),(51,4),(52,4),(53,4),(54,4),(55,4),(56,4),(57,4),
(58,4),(59,4),(60,4),(61,4),(62,4),(63,4),(64,4),(65,4),(66,4),(67,4),(68,4),(69,4),(70,4),(71,4),
-- Confitures & Gelées
(40,5),(41,5),(42,5),(91,5),(92,5),
-- Paniers & Coffrets
(94,6),(95,6),(96,6),(97,6),(98,6),(99,6),(100,6);

INSERT INTO Cle_Authentification
(clee, utilisee)
VALUES
('100100100',false),
('200200200',false);
