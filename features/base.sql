INSERT INTO `scopes` (`id`, `title`)
VALUES
	(1,'FirstScope'),
	(2,'SecondScope'),
	(3,'ThirdScope');

INSERT INTO `service_categories` (`id`, `title`)
VALUES
	(1, 'Basic');

INSERT INTO `services` (`id`, `category_id`, `title`)
VALUES
	(1, 1, 'FirstService'),
	(2, 1, 'SecondService'),
	(3, 1, 'ThirdService');

INSERT INTO `places` (`id`, `title`, `address`, `latitude`, `longitude`, `description`, `is_active`, `status`, `phonenumber`, `phonenumber_hq`, `image`, `images`, `map_image`, `files`, `google_place_id`, `open_hours`, `created_at`, `updated_at`)
VALUES
	(1, 'Ukraine', 'Center of the europe', 50.44552900, 30.56972900, NULL, 1, 'Нет записи (Живая очередь)', '063 462 1208', '', NULL, NULL, 'data/places/map/2c87bbd50388da4cffc7a40203df58f1.png', NULL, 'ChIJbTf9c0_E1EARK6AEaKO-ztI', '[[\"0700\",\"2300\"],[\"0700\",\"2300\"],[\"0700\",\"2300\"],[\"0700\",\"2300\"],[\"0700\",\"2300\"],[\"0700\",\"2300\"],[\"0700\",\"2300\"]]', '2020-02-26 09:33:29', '2020-06-29 05:21:19'),
	(2, 'Germany', 'Left top europe location', 50.44656300, 30.57446700, NULL, 1, 'Есть запись и цены', '096 410 0123', '067 342 22 23 Вячеслав', 'data/places/files/2.82d44bb296485f95f3d89c12587c3717.jpeg', 'data/places/files/2.1533811c41fd45fa79fe88891ae7efc0.jpeg\ndata/places/files/2.82d44bb296485f95f3d89c12587c3717.jpeg\ndata/places/files/2.c297c58bfd5ffb1566e32458cefb2467.jpeg\ndata/places/files/2.be4c6422af95def30507ba9a62119a2a.jpeg\ndata/places/files/2.83b2c355ab56625a9781670557398d04.jpeg', 'data/places/map/069d169ecb21881cd88186c71eb7d40f.png', 'data/places/files/2.2b2c29db9fb8cad003465ad6d93130ad.jpeg\ndata/places/files/2.2ecf4d22c14e176d3a47533bb9d1dec0.jpeg\ndata/places/files/2.1533811c41fd45fa79fe88891ae7efc0.jpeg\ndata/places/files/2.82d44bb296485f95f3d89c12587c3717.jpeg\ndata/places/files/2.c297c58bfd5ffb1566e32458cefb2467.jpeg\ndata/places/files/2.b4423a60f9a07cc9733261b2a95d0c73.jpeg\ndata/places/files/2.5cdc387d9129eb39601c2e82bcc594c5.jpeg\ndata/places/files/2.6d9bf561b88bfdc9a3885a5380718e9a.jpeg\ndata/places/files/2.e1089e9bcc3113a67c7cd0b0a2e3cd18.jpeg\ndata/places/files/2.be4c6422af95def30507ba9a62119a2a.jpeg\ndata/places/files/2.83b2c355ab56625a9781670557398d04.jpeg\ndata/places/files/2.b0d3c6280292c102579d6a73daf8c764.jpeg\ndata/places/files/2.e6b4982aafc6fb3f272aadf6027232d3.jpeg\ndata/places/files/2.e9bffee651b77cc3384dd37903295987.jpeg', 'ChIJs7zigaPF1EARGT-Kf-e-zcw', '[[\"0800\",\"2200\"],[\"0800\",\"2200\"],[\"0800\",\"2200\"],[\"0800\",\"2200\"],[\"0800\",\"2200\"],[\"0800\",\"2200\"],[\"0800\",\"2200\"]]', '2020-02-26 09:33:31', '2020-07-06 07:27:25'),
	(3, 'Italy', 'Bottom of the Europe', 50.44775500, 30.57932500, NULL, 1, 'Не найдена (можно искать еще)', '098 100 7705', '', NULL, NULL, 'data/places/map/69983ed7d7723a48f8561ea83881da42.png', NULL, 'ChIJD3POlKLF1EARmr6hBNlTd9A', NULL, '2020-02-26 09:33:32', '2020-06-29 05:21:19');

INSERT INTO `menu` (`id`, `place_id`, `scope_id`, `service_id`, `price`)
VALUES
	(1, 1, 1, 1, 10),
	(2, 1, 2, 1, 20),
	(3, 1, 3, 1, 30),
	(4, 2, 1, 1, 10),
	(5, 2, 2, 1, 20),
	(6, 2, 3, 1, 30),
	(7, 3, 1, 1, 10),
	(8, 3, 2, 1, 20),
	(9, 3, 3, 1, 30);