<?php
// Exit if accessed directly.
defined('ABSPATH') || exit();

function data_currencies($key = null)
{
	$currencies =  array(
		'aed' => 'Vereinigte Arabische Emirate-Dirham',
		'afn' => 'Afghanischer Afghani',
		'all' => 'Albanischer Lek',
		'amd' => 'Armenischer Dram',
		'ang' => 'Niederländische Antillen Gulden',
		'aoa' => 'Angolanischer Kwanza',
		'ars' => 'Argentinischer Peso',
		'aud' => 'Australischer Dollar',
		'awg' => 'Aruba Florin',
		'azn' => 'Aserbaidschan-Manat',
		'bam' => 'Bosnien Herzegowina Konvertible Mark',
		'bbd' => 'Barbados Dollar',
		'bdt' => 'Bangladesch Teka',
		'bgn' => 'Bulgarische Lew',
		'bhd' => 'Bahrain Dinar',
		'bif' => 'Burundi-Franc',
		'bmd' => 'Bermuda Dollar',
		'bnd' => 'Brunei Dollar',
		'bob' => 'Bolivischer Boliviano',
		'bov' => 'Mvdol',
		'brl' => 'Brasilianischer Real',
		'bsd' => 'Bahamas Dollar',
		'btn' => 'Bhutan-Ngultrum',
		'bwp' => 'Botsuana-Pula',
		'byr' => 'Weißrussischer Rubel',
		'bzd' => 'Belize Dollar',
		'cad' => 'Kanadischer Dollar',
		'cdf' => 'Kongo Franc',
		'chf' => 'Schweizer Franken',
		'clp' => 'Chilenischer Peso',
		'cny' => 'Chinesischer Renminbi/Yuan',
		'cop' => 'Kolumbianischer Peso',
		'crc' => 'Costa Rica Colon',
		'cup' => 'Kubanischer Peso',
		'cve' => 'Kap Verde Escudo',
		'czk' => 'Tschechische Krone',
		'djf' => 'Dschibuti Franc',
		'dkk' => 'Dänische Krone',
		'dop' => 'Dominikanische Republik Peso',
		'dzd' => 'Algerischer Dinar',
		'eek' => 'Estnische Krone',
		'egp' => 'Ägyptisches Pfund',
		'ern' => 'Nakfa',
		'etb' => 'Äthiopischer Birr',
		'eur' => 'Euro',
		'fjd' => 'Fidschi Dollar',
		'fkp' => 'Falklandinseln Pfund',
		'gbp' => 'Britisches Pfund',
		'gel' => 'Georgischer Lari',
		'ghs' => 'Ghana-Cedi',
		'gip' => 'Gibraltar Pfund',
		'gmd' => 'Gambia-Dalasi',
		'gnf' => 'Guinea Franc',
		'gtq' => 'Guatemala Quetzal',
		'gwp' => 'Guinea-Bissau Peso',
		'gyd' => 'Guyana Dollar',
		'hkd' => 'Hongkong-Dollar',
		'hnl' => 'Honduras-Lempira',
		'hrk' => 'Kroatische Kuna',
		'htg' => 'Haiti Gourde',
		'huf' => 'Ungarischer Forint',
		'idr' => 'Indonesische Rupiah',
		'ils' => 'Israelischer Schekel',
		'inr' => 'Indische Rupie',
		'iqd' => 'Irakischer Dinar',
		'irr' => 'Iranischer Rial',
		'isk' => 'Isländische Krone',
		'jmd' => 'Jamaika Dollar',
		'jod' => 'Jordanischer Dinar',
		'jpy' => 'Japanischer Yen',
		'kes' => 'Kenia Schilling',
		'kgs' => 'Kirgisistan-Som',
		'khr' => 'Kambodschanischer Riel',
		'kmf' => 'Komoren Franc',
		'kpw' => 'Nordkoreanischer Won',
		'krw' => 'Südkoreanischer Won',
		'kwd' => 'Kuwaitischer Dinar',
		'kyd' => 'Kaimaninseln Dollar',
		'kzt' => 'Kasachstan-Tenge',
		'lak' => 'Laos Kip',
		'lbp' => 'Libanesisches Pfund',
		'lkr' => 'Sri Lanka Rupie',
		'lrd' => 'Liberia Dollar',
		'lsl' => 'Lesotho Loti',
		'ltl' => 'Litauischer Litas',
		'lvl' => 'Lettischer Lats',
		'lyd' => 'Libyscher Dinar',
		'mad' => 'Marokkanischer Dirham',
		'mdl' => 'Moldau-Leu',
		'mga' => 'Madagaskar-Ariary',
		'mkd' => 'Mazedonischer Denar',
		'mmk' => 'Myanmar Kyat',
		'mnt' => 'Mongolischer Tugrik',
		'mop' => 'Macao Pataca',
		'mro' => 'Mauretanischer Ouguiya',
		'mur' => 'Mauritius-Rupie',
		'mvr' => 'Malediven Rufiyaa',
		'mwk' => 'Malawi-Kwacha',
		'mxn' => 'Mexikanischer Peso',
		'myr' => 'Malaysischer Ringgit',
		'mzn' => 'Mosambik Mentical',
		'nad' => 'Namibia Dollar',
		'ngn' => 'Nigerianischer Naira',
		'nio' => 'Nicaragua Cordoba Oro',
		'nok' => 'Norwegische Krone',
		'npr' => 'Nepal Rupie',
		'nzd' => 'Neuseeländischer Dollar',
		'omr' => 'Oman-Rial',
		'pab' => 'Panama Balboa',
		'pen' => 'Peruanischer Nuevo Sol',
		'pgk' => 'Papua-Neuguinea Kina',
		'php' => 'Philippinischer Peso',
		'pkr' => 'Pakistanische Rupie',
		'pln' => 'Polnischer Zloty',
		'pyg' => 'Paraguay-Guarani',
		'qar' => 'Katar-Riyal',
		'ron' => 'Rumänischer Leu (neu)',
		'rsd' => 'Serbischer Dinar',
		'rub' => 'Russischer Rubel',
		'rwf' => 'Ruanda Franc',
		'sar' => 'Saudischer Rial (Riyal)',
		'sbd' => 'Salomonen Dollar',
		'scr' => 'Seychellen-Rupie',
		'sdg' => 'Sudanesischer Dinar',
		'sek' => 'Schwedische Krone',
		'sgd' => 'Singapur-Dollar',
		'shp' => 'St. Helena Pfund',
		'skk' => 'Slowakische Krone',
		'sll' => 'Sierra Leone Leon',
		'sos' => 'Somalischer Schilling',
		'srd' => 'Suriname Dollar',
		'std' => 'Sao Tome Principe-Dobra',
		'svc' => 'El Salvador-Colon',
		'syp' => 'Syrisches Pfund',
		'szl' => 'Swasiland-Lilangeni',
		'thb' => 'Thailändischer Baht',
		'tjs' => 'Tadschikistan-Somoni',
		'tmm' => 'Turkmenistan-Menat',
		'tnd' => 'Tunesischer Dinar',
		'top' => 'Tonga-Pa\'anga',
		'try' => 'Türkische Lira (neu)',
		'ttd' => 'Trinidad und Tobago Dollar',
		'twd' => 'Taiwanesischer Dollar',
		'tzs' => 'Tansanischer Schilling',
		'uah' => 'Ukrainischer Griwna (Hrywnja)',
		'ugx' => 'Uganda Schilling',
		'usd' => 'US Dollar',
		'uyu' => 'Uruguay-Peso',
		'uzs' => 'Usbekistan-Sum',
		'vef' => 'Venezuela Bolivar',
		'vnd' => 'Vietnamesischer Dong',
		'vuv' => 'Vanuatu-Vatu',
		'wst' => 'Samoa-Tala',
		'yer' => 'Jemenitischer Rial',
		'zar' => 'Südafrikanischer Rand',
		'zmk' => 'Sambischer Kwacha',
		'zwr' => 'Simbabwe Dollar',
	);
	
	return empty($key) ? $currencies : $currencies[$key];
}