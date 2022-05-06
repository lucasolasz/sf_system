
CREATE TABLE `tb_casa` (
	`id_casa` int(2) unsigned NOT NULL AUTO_INCREMENT,
	`ds_numero_casa` varchar(10) DEFAULT NULL,
	PRIMARY KEY (`id_casa`),
	UNIQUE KEY `id_casa` (`id_casa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `tb_casa` (`id_casa`, `ds_numero_casa`) VALUES
(1	,	'001A'),
(2	,	'001B'),
(3	,	'002'),
(4	,	'003'),
(5	,	'004'),
(6	,	'005'),
(7	,	'006'),
(8	,	'007'),
(9	,	'008'),
(10	,	'009'),
(11	,	'010A'),
(12	,	'010B'),
(13	,	'011'),
(14	,	'012'),
(15	,	'013'),
(16	,	'014A'),
(17	,	'014B'),
(18	,	'015'),
(19	,	'016'),
(20	,	'017'),
(21	,	'018'),
(22	,	'019'),
(23	,	'020'),
(24	,	'021'),
(25	,	'022'),
(26	,	'023'),
(27	,	'024'),
(28	,	'025'),
(29	,	'026'),
(30	,	'027'),
(31	,	'028'),
(32	,	'029'),
(33	,	'030'),
(34	,	'031'),
(35	,	'032'),
(36	,	'033'),
(37	,	'034'),
(38	,	'035'),
(39	,	'036'),
(40	,	'037'),
(41	,	'038'),
(42	,	'039'),
(43	,	'040'),
(44	,	'041'),
(45	,	'042A'),
(46	,	'042B'),
(47	,	'043'),
(48	,	'044'),
(49	,	'045'),
(50	,	'046'),
(51	,	'047'),
(52	,	'048'),
(53	,	'049'),
(54	,	'050'),
(55	,	'051'),
(56	,	'052'),
(57	,	'053'),
(58	,	'054'),
(59	,	'055'),
(60	,	'056'),
(61	,	'057'),
(62	,	'058'),
(63	,	'059'),
(64	,	'060'),
(65	,	'061A'),
(66	,	'061B'),
(67	,	'062A'),
(68	,	'062B'),
(69	,	'063'),
(70	,	'064A'),
(71	,	'064B'),
(72	,	'065'),
(73	,	'066'),
(74	,	'067'),
(75	,	'068'),
(76	,	'069A'),
(77	,	'069B'),
(78	,	'070A'),
(79	,	'070B'),
(80	,	'071'),
(81	,	'072'),
(82	,	'073'),
(83	,	'074'),
(84	,	'075'),
(85	,	'076'),
(86	,	'077'),
(87	,	'078'),
(88	,	'079'),
(89	,	'080'),
(90	,	'081'),
(91	,	'082'),
(92	,	'083A'),
(93	,	'083B'),
(94	,	'084'),
(95	,	'085'),
(96	,	'086'),
(97	,	'087'),
(98	,	'088'),
(99	,	'089'),
(100	,	'090'),
(101	,	'091'),
(102	,	'092'),
(103	,	'093'),
(104	,	'094'),
(105	,	'095'),
(106	,	'096'),
(107	,	'097'),
(108	,	'098'),
(109	,	'099'),
(110	,	'100'),
(111	,	'101A'),
(112	,	'101B'),
(113	,	'102'),
(114	,	'103'),
(115	,	'104'),
(116	,	'105'),
(117	,	'106'),
(118	,	'107'),
(119	,	'108'),
(120	,	'109'),
(121	,	'110'),
(122	,	'111'),
(123	,	'112'),
(124	,	'113'),
(125	,	'114'),
(126	,	'115'),
(127	,	'116'),
(128	,	'117'),
(129	,	'118'),
(130	,	'119'),
(131	,	'120'),
(132	,	'121'),
(133	,	'122'),
(134	,	'123'),
(135	,	'124'),
(136	,	'125'),
(137	,	'126'),
(138	,	'127'),
(139	,	'128'),
(140	,	'129'),
(141	,	'130'),
(142	,	'131'),
(143	,	'132'),
(144	,	'133'),
(145	,	'134'),
(146	,	'135'),
(147	,	'136'),
(148	,	'137'),
(149	,	'138'),
(150	,	'139'),
(151	,	'140'),
(152	,	'141'),
(153	,	'142A'),
(154	,	'142B'),
(155	,	'143'),
(156	,	'144'),
(157	,	'145'),
(158	,	'146'),
(159	,	'147'),
(160	,	'148'),
(161	,	'149'),
(162	,	'150'),
(163	,	'151'),
(164	,	'152'),
(165	,	'153'),
(166	,	'154'),
(167	,	'155'),
(168	,	'156'),
(169	,	'157'),
(170	,	'158'),
(171	,	'159'),
(172	,	'160'),
(173	,	'161'),
(174	,	'162'),
(175	,	'163'),
(176	,	'164'),
(177	,	'165'),
(178	,	'166'),
(179	,	'167'),
(180	,	'168'),
(181	,	'169'),
(182	,	'170'),
(183	,	'171'),
(184	,	'172'),
(185	,	'173'),
(186	,	'174'),
(187	,	'175'),
(188	,	'176'),
(189	,	'177'),
(190	,	'178'),
(191	,	'179'),
(192	,	'180'),
(193	,	'181'),
(194	,	'182'),
(195	,	'183'),
(196	,	'184'),
(197	,	'185'),
(198	,	'186'),
(199	,	'187'),
(200	,	'188'),
(201	,	'189'),
(202	,	'190'),
(203	,	'191'),
(204	,	'192'),
(205	,	'193'),
(206	,	'194'),
(207	,	'195'),
(208	,	'196A'),
(209	,	'196B'),
(210	,	'197'),
(211	,	'198A'),
(212	,	'198B'),
(213	,	'199'),
(214	,	'200'),
(215	,	'201'),
(216	,	'202'),
(217	,	'203'),
(218	,	'204'),
(219	,	'205'),
(220	,	'206'),
(221	,	'207'),
(222	,	'208A'),
(223	,	'208B'),
(224	,	'209'),
(225	,	'210'),
(226	,	'211'),
(227	,	'212'),
(228	,	'213'),
(229	,	'214'),
(230	,	'215'),
(231	,	'216'),
(232	,	'217'),
(233	,	'218'),
(234	,	'219'),
(235	,	'220'),
(236	,	'221'),
(237	,	'222'),
(238	,	'223'),
(239	,	'224'),
(240	,	'225'),
(241	,	'226'),
(242	,	'227'),
(243	,	'228'),
(244	,	'229'),
(245	,	'230'),
(246	,	'231'),
(247	,	'232'),
(248	,	'233'),
(249	,	'234'),
(250	,	'235'),
(251	,	'236'),
(252	,	'237'),
(253	,	'238'),
(254	,	'239'),
(255	,	'240');


UPDATE tb_parametro SET vl_parametro = 'v0006' 
WHERE grupo_parametro = 'banco_dados' 
AND chave_parametro = 'versao';