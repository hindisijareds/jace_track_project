<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>JaceTrack - Create Shipment</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('images/jacelogoclean.png') }}" type="image/png"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    :root{
      --jace-blue:#00b8de;
      --jace-deep:#212244;
      --card-bg:#ffffff;
      --muted:#6c757d;
      --glass: rgba(255,255,255,0.85);
      --accent:#0d6efd;
    }
    /* Add these styles at the end of your <style> section */
#paymentProof {
  border: 2px dashed #d6eef6;
  padding: 10px;
  background: #fbffff;
}

#paymentProof:hover {
  border-color: var(--jace-blue);
}

#paymentModalContent img {
  max-width: 250px;
  border: 2px solid var(--jace-blue);
  padding: 10px;
  background: white;
}

#proofUploadSection {
  border: 1px dashed var(--jace-blue) !important;
  background: #f1fbff !important;
}
    body { background: #f6f8fb; }
    .address-wrapper { position: relative; }
    .btn-jace { background: var(--jace-blue); color: #fff; font-weight: 700; border-radius: 8px; padding: 10px 16px; border: none; }
    .btn-min { background:#343a40; color:#fff; border-radius:6px; padding:8px 14px; border:none; }
    .form-card { padding: 18px; border-radius: 12px; background: var(--card-bg); box-shadow: 0 6px 18px rgba(16,24,40,0.04); border: 1px solid rgba(0,0,0,0.03); }
    .title { font-weight: 700; margin-bottom: 10px; color: var(--jace-deep); }
    .address-input { background-color: #fbffff; border:1px solid #d6eef6; cursor: pointer; }
    .dropdown-list { position: absolute; top: 100%; left: 0; width: 100%; background: #fff; border: 1px solid #e6e9ef; border-radius: 6px; max-height: 220px; overflow-y: auto; z-index: 99999; display: none; box-shadow: 0 12px 30px rgba(13,24,45,0.06); pointer-events: auto; }
    .dropdown-list div { padding: 10px 12px; cursor: pointer; transition: background 0.12s; font-size:14px; }
    .dropdown-list div:hover { background-color: #f3f6fb; }
    .muted-small { color: var(--muted); font-size: 13px; }
    .pill { display:inline-block; padding:6px 10px; border-radius:999px; background:#f1f6ff; color:var(--jace-deep); font-weight:600; font-size:13px; }
    .calc-grid { display:grid; grid-template-columns: 1fr auto; gap:8px; align-items:center; }
    .method-card, .payment-card { cursor:pointer; user-select:none; border:1px solid #e9eef6; padding:10px; border-radius:8px; }
    .method-card.active, .payment-card.active { border-color: var(--jace-blue); background:#f1fbff; box-shadow:0 8px 20px rgba(0,184,222,0.06); }
    #fixedCostSummary { bottom:20px; right:20px; width:340px; z-index: 99998; position: fixed; }
    #fixedCostSummary .head { display:flex; justify-content:space-between; align-items:center; gap:10px; }
    .bg-jace { background: #fff; color:var(--jace-deep); border-radius:10px; border:1px solid rgba(0,0,0,0.03); }
    .payment-card, .method-card, .dropdown-list { position: relative }
    @media (max-width: 900px) { #fixedCostSummary { display:none !important; } }
    .transparent-math { font-family: monospace; font-size:13px; color:#0b3a4a; background:#fff; padding:8px; border-radius:8px; border:1px dashed rgba(0,0,0,0.04); }
    /* validation styles (inline below fields) */
    .invalid-msg { color:#d6333e; font-size:13px; margin-top:6px; display:none; }
    .is-invalid-field { border-color:#d6333e !important; box-shadow: none !important; }
    /* keep dropdowns above modals/controls */
    .dropdown-list { z-index: 2000; }
  </style>
</head>
<body class="container py-4">

<div class="mb-4">
  <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary back-btn">
    <i class="bx bx-arrow-back"></i> Back to Dashboard
  </a>
</div>

<div class="mb-3">
  <h2 class="text-primary fw-bold"><i class="bx bx-package"></i> Create Shipment</h2>
  <p class="text-muted">Fill out the form below to schedule your parcel delivery.</p>
</div>

<form id="shipmentForm" method="POST" action="{{ route('shipment.store') }}">
  @csrf

  @php
   // keep the cityBarangays and zipCodes (unchanged)
$cityBarangays = [
'Agno' => ['Allabon','Aloleng','Bangan-Oda','Baruan','Boboy','Cayungnan','Dangley','Gayusan','Macaboboni','Magsaysay','Namatucan','Patar','Poblacion East','Poblacion West','San Juan','Tupa','Viga'],
'Aguilar' => ['Bayaoas','Baybay','Bocacliw','Bocboc East','Bocboc West','Buer','Calsib','Laoag','Manlocboc','Ni\u00f1oy','Panacol','Poblacion','Pogomboa','Pogonsili','San Jose','Tampac'],
'Alcala' => ['Anulid','Atainan','Bersamin','Canarvacanan','Caranglaan','Curareng','Gualsic','Kisikis','Laoac','Macayo','Pindangan Centro','Pindangan East','Pindangan West','Poblacion East','Poblacion West','San Juan','San Nicolas','San Pedro Apartado','San Pedro Ili','San Vicente','Vacante'],
'Anda' => ['Awile','Awag','Batiarao','Cabungan','Carot','Dolaoan','Imbo','Macaleeng','Macandocandong','Mal-ong','Namagbagan','Poblacion','Roxas','Sablig','San Jose','Siapar','Tondol','Tori-tori'],
'Asingan' => ['Ariston Este','Ariston Weste','Bantog','Baro','Bobonan','Cabalitian','Calepaan','Carosucan Norte','Carosucan Sur','Coldit','Domanpot','Dupac','Macalong','Palaris','Poblacion East','Poblacion West','San Vicente Este','San Vicente Weste','Sanchez','Sobol','Toboy'],
'Balungao' => ['Angayan Norte','Angayan Sur','Capulaan','Esmeralda','Kita-kita','Mabini','Mauban','Poblacion','Pugaro','Rajal','San Andres','San Aurelio 1st','San Aurelio 2nd','San Aurelio 3rd','San Joaquin','San Julian','San Leon','San Marcelino','San Miguel','San Raymundo'],
'Bani' => ['Ambabaay','Aporao','Arwas','Ballag','Banog Norte','Banog Sur','Calabeng','Centro Toma','Colayo','Dacap Norte','Dacap Sur','Garrita','Luac','Macabit','Masidem','Poblacion','Quinaoayanan','Ranao','Ranom Iloco','San Jose','San Miguel','San Simon','San Vicente','Tiep','Tipor','Tugui Grande','Tugui Norte'],
'Basista' => ['Anambongan','Bayoyong','Cabeldatan','Dumpay','Malimpec East','Mapolopolo','Nalneran','Navatat','Obong','Osme\u00f1a Sr.','Palma','Patacbo','Poblacion'],
'Bautista' => ['Artacho','Baluyot','Cabuaan','Cacandongan','Diaz','Ketegan','Nandacan','Nibaliw Norte','Nibaliw Sur','Palisoc','Poblacion East','Poblacion West','Pogo','Poponto','Primicias','Sinabaan','Vacante','Villanueva'],
'Bayambang' => ['Alinggan','Amanperez','Amancosiling Norte','Amancosiling Sur','Ambayat I','Ambayat II','Apalen','Asin','Ataynan','Bacnono','Balaybuaya','Banaban','Bani','Batangcawa','Beleng','Bical Norte','Bical Sur','Bongato East','Bongato West','Buayaen','Buenlag 1st','Buenlag 2nd','Cadre Site','Carungay','Caturay','Darawey (Tangal)','Duera','Dusoc','Hermoza','Idong','Inanlorenzana','Inirangan','Iton','Langiran','Ligue','M. H. del Pilar','Macayocayo','Magsaysay','Maigpa','Malimpec','Malioer','Managos','Manambong Norte','Manambong Parte','Manambong Sur','Mangayao','Nalsian Norte','Nalsian Sur','Pangdel','Pantol','Paragos','Poblacion Sur','Pugo','Reynado','San Gabriel 1st','San Gabriel 2nd','San Vicente','Sancagulis','Sanlibo','Sapang','Tamaro','Tambac','Tampog','Tanolong','Tatarac','Telbang','Tococ East','Tococ West','Warding','Wawa','Zone I (Pob.)','Zone II (Pob.)','Zone III (Pob.)','Zone IV (Pob.)','Zone V (Pob.)','Zone VI (Pob.)','Zone VII (Pob.)'],
'Binalonan' => ['Balangobong','Bued','Bugayong','Camangaan','Canarvacanan','Capas','Cili','Dumayat','Linmansangan','Mangcasuy','Moreno','Pasileng Norte','Pasileng Sur','Poblacion','San Felipe Central','San Felipe Sur','San Pablo','Santa Catalina','Santa Maria Norte','Santiago','Santo Ni\u00f1o','Sumabnit','Tabuyoc','Vacante'],
'Binmaley' => ['Amancoro','Balagan','Balogo','Basing','Baybay Lopez','Baybay Polong','Biec','Buenlag','Calit','Caloocan Dupo','Caloocan Norte','Caloocan Sur','Camaley','Canaoalan','Dulag','Gayaman','Linoc','Lomboy','Nagpalangan','Malindong','Manat','Naguilayan','Pallas','Papagueyan','Parayao','Poblacion','Pototan','Sabangan','Salapingao','San Isidro Norte','San Isidro Sur','Santa Rosa','Tombor'],
'Bolinao' => ['Arnedo','Balingasay','Binabalian','Cabuyao','Catuday','Catungi','Concordia (Poblacion)','Culang','Dewey','Estanza','Germinal (Poblacion)','Goyoden','Ilog-Malino','Lambes','Liwa-liwa','Lucero','Luciente 1','Luciente 2','Luna','Patar','Pilar','Salud','Samang Norte','Samang Sur','Sampaloc','San Roque','Tara','Tupa','Victory','Zaragoza'],
'Bugallon' => ['Angarian','Asinan','B\u00f1aga','Bacabac','Bolaoen','Buenlag','Cabayaoasan','Cayanga','Gueset','Hacienda','Laguit Centro','Laguit Padilla','Magtaking','Pangascasan','Pantal','Poblacion','Polong','Portic','Salasa','Salomague Norte','Salomague Sur','Samat','San Francisco','Umanday'],
'Burgos' => ['Anapao','Cacayasen','Concordia','Don Matias','Ilio-ilio (Iliw-iliw)','Papallasen','Poblacion','Pogoruac','San Miguel','San Pascual','San Vicente','Sapa Grande','Sapa Peque\u00f1a','Tambacan'],
'Calasiao' => ['Ambonao','Ambuetel','Banaoang','Bued','Buenlag','Cabilocaan','Dinalaoan','Doyong','Gabon','Lasip','Longos','Lumbang','Macabito','Malabago','Mancup','Nagsaing','Nalsian','Poblacion East','Poblacion West','Quesban','San Miguel','San Vicente','Songkoy','Talibaew'],
'Dagupan' => ['Alonzo','Bacayao Sur', 'Bacayao Norte', 'Bacnotan', 'Bongato', 'Bonuan Gueset', 'Bonuan Boquig', 'Calmay', 'Caranglaan', 'Dawel', 'East Tapuac', 'Lasip Grande', 'Lasip Pequeno', 'Malued', 'Magsaysay', 'Pantal', 'Pogo', 'San Antonio', 'San Gabriel', 'San Isidro', 'San Jacinto', 'San Manuel', 'San Miguel', 'San Vicente', 'Santiago', 'Sison', 'Tapuac', 'Tebeng', 'Tondaligan', 'West Tapuac', 'Zaragoza'],
'Dasol' => ['Alilao','Amalbalan','Bobonot','Eguia','Gais-Guipe','Hermosa','Macalang','Magsaysay','Malacapas','Malimpin','Osme\u00f1a','Petal','Poblacion','San Vicente','Tambac','Tambobong','Uli','Viga'],
'Infanta' => ['Bamban','Batang','Bayambang','Babuyan','Cato','Doliman','Fatima','Maya','Nangalisan','Nayom','Pita','Poblacion','Potol'],
'Labrador' => ['Bolo','Bongalon','Dulig','Laois','Magsaysay','Poblacion','San Gonzalo','San Jose','Tobuan','Uyong'],
'Laoac' => ['Anis','Balligi','Banuar','Botigue','Caaringayan','D. Alarcio (Domingo Alarcio)','Cabilaoan','Cabulalaan','Calaoagan','Calmay','Casampagaan','Casanestebanan','Casantiagoan','Inmanduyan','Poblacion','Lebueg','Maraboc','Nanbagatan','Panaga','Talogtog','Turko','Yatyat'],
'Lingayen' => ['Aliwekwek','Baay','Balangobong','Balococ','Bantayan','Basing','Capandanan','Domalandan Center','Domalandan East','Domalandan West','Dorongan','Dulag','Estanza','Lasip','Libsong East','Libsong West','Malawa','Malimpuec','Maniboc','Matalava','Naguelguel','Namolan','Pangapisan North','Pangapisan Sur','Poblacion','Quibaol','Rosario','Sabangan','Talogtog','Tonton','Tumbar','Wawa'],
'Mabini' => ['Bacnit','Barlo','Caabiangaan','Cabanaetan','Cabinuangan','Calzada','Caranglaan','De Guzman','Luna (formerly Balayang)','Magalong','Nibaliw','Patar','Poblacion','San Pedro','Tagudin','Villacorta'],
'Malasiqui' => ['Abonagan','Agdao','Alacan','Aliaga','Amacalan','Anolid','Apaya','Asin Este','Asin Weste','Bacundao Este','Bacundao Weste','Bakitiw','Balite','Banawang','Barang','Bawer','Binalay','Bobon','Bolaoit','Bongar','Butao','Cabatling','Cabueldatan','Calbueg','Canan Norte','Canan Sur','Cawayan Bogtong','Don Pedro','Gatang','Goliman','Gomez','Guilig','Ican','Ingalagala','Lareg-lareg','Lasip','Lepa','Loqueb Este','Loqueb Norte','Loqueb Sur','Lunec','Mabulitec','Malimpec','Manggan-Dampay','Nancapian','Nalsian Norte','Nalsian Sur','Nansangaan','Olea','Pacuan','Palapar Norte','Palapar Sur','Palong','Pamaranum','Pasima','Payar','Poblacion','Polong Norte','Polong Sur','Potiocan','San Julian','Tabo-Sili','Tambac','Taloy','Talospatang','Tobor','Warey'],
'Manaoag' => ['Babasit','Baguinay','Baritao','Bisal','Bucao','Cabanbanan','Calaocan','Inamotan','Lelemaan','Licsi','Lipit Norte','Lipit Sur','Matolong','Mermer','Nalsian','Oraan East','Oraan West','Pantal','Pao','Parian','Poblacion','Pugaro','San Ramon','Santa Ines','Sapang','Tebuel'],
'Mangaldan' => ['Alitaya','Amansabina','Anolid','Banaoang','Bantayan','Bari','Bateng','Buenlag','David','Embarcadero','Gueguesangen','Guesang','Guiguilonen','Guilig','Inlambo','Lanas','Landas','Maasin','Macayug','Malabago','Navaluan','Nibaliw','Osiem','Palua','Poblacion','Pogo','Salaan','Salay','Tebag','Talogtog'],
'Mangatarem' => ['Andangin','Arellano Street (Poblacion)','Bantay','Bantocaling','Baracbac','Peania Pedania (Bedania)','Bogtong Bolo','Bogtong Bunao','Bogtong Centro','Bogtong Niog','Bogtong Silag','Buaya','Buenlag','Bueno','Bunagan','Bunlalacao','Burgos Street (Poblacion)','Cabaluyan 1st','Cabaluyan 2nd','Cabarabuan','Cabaruan','Cabayaoasan','Cabayugan','Cacaoiten','Calumboyan Norte','Calumboyan Sur','Calvo (Poblacion)','Casilagan','Catarataraan','Caturay Norte','Caturay Sur','Caviernesan','Dorongan Ketaket','Dorongan Linmansangan','Dorongan Punta','Dorongan Sawat','Dorongan Valerio','General Luna (Poblacion)','Lawak Langka','Linmansangan','Lopez (Poblacion)','Mabini (Poblacion)','Macarang','Malabobo','Malibong','Malunec','Maravilla (Poblacion)','Maravilla-Arellano Ext. (Poblacion)','Muelang','Naguilayan East','Naguilayan West','Nancasalan','Niog-Cabison-Bulaney','Olegario-Caoile (Poblacion)','Olo Cacamposan','Olo Cafabrosan','Olo Cagarlitan','Osme\u00f1a (Poblacion)','Pacalat','Pampano','Parian','Paul','Pogon-Aniat','Pogon-Lomboy (Poblacion)','Ponglo-Baleg','Ponglo-Muelag','Quetegan (Pogon-Baleg)','Quezon (Poblacion)','Salavante','Sapang','Sonson Ongkit','Suaco','Tagac','Takipan','Talogtog','Tococ Barikir','Torre 1st','Torre 2nd','Torres Bugallon (Poblacion)','Umangan','Zamora (Poblacion)'],
'Mapandan' => ['Amanoaoac','Apaya','Aserda','Baloling','Coral','Golden','Jimenez','Lambayan','Luyan','Nilombot','Pias','Poblacion','Primicias','Santa Maria','Torres'],
'Natividad' => ['Barangobong','Batchelor East','Batchelor West','Burgos (San Narciso)','Cacandungan','Calapugan','Canarem','Luna','Poblacion East','Poblacion West','Rizal','Salud','San Eugenio','San Macario Norte','San Macario Sur','San Maximo','San Miguel','Silag'],
'Pozorrubio' => ['Alipangpang','Amagbagan','Balacag','Banding','Bantugan','Batakil','Bobonan','Buneg','Cablong','Casanfernandoan','Casta\u00f1o','Dilan','Don Benito','Haway','Imbalbalatong','Inoman','Laoac','Maambal','Malasin','Malokiat','Manaol','Nama','Nantangalan','Palacpalac','Palguyod','Poblacion District I','Poblacion District II','Poblacion District III','Poblacion District IV','Rosario','Sugcong','Talogtog','Tulnac','Villegas'],
'Rosales' => ['Acop','Bakit-Bakit','Balincanaway','Cabalaoangan Norte','Cabalaoangan Sur','Camangaan','Capitan Tomas','Carmay East','Carmay West','Carmen East','Carmen West','Casanicolasan','Coliling','Calanutan (Don Felix Coloma)','Don Antonio Village','Guiling','Palakipak','Pangaoan','Rabago','Rizal','Salvacion','San Antonio','San Bartolome','San Isidro','San Luis','San Pedro East','San Pedro West','San Vicente','San Angel','Station District','Tumana East','Tumana West','Zone I (Poblacion)','Zone II (Poblacion)','Zone III (Poblacion)','Zone IV (Poblacion)','Zone V (Poblacion)'],
'San Fabian' => ['Alacan','Ambalangan-Dalin','Angio','Anonang','Aramal','Bigbiga','Binday','Bolaoen','Bolasi','Cabaruan','Cayanga','Colisao','Gumot','Inmalog Norte','Inmalog Sur','Lekep-Butao','Lipit-Tomeeng','Longos Central','Longos Proper','Longos-Amangonan-Parac-Parac Fabrica','Mabilao','Nibaliw Central','Nibaliw East','Nibaliw Magliba','Nibaliw Narvarte (Nibaliw West Compound)','Nibaliw Vidal (Nibaliw West Proper)','Palapad','Poblacion','Rabon','Sagud-Bahley','Sobol','Tempra-Guilig','Tiblong','Tocok'],
'San Jacinto' => ['Awai','Bolo','Capaoay (Poblacion East)','Casibong','Imelda (Decrito)','Guibel','Labney','Magsaysay (Capay)','Lobong','Macayug','Bagong Pag-asa','San Guillermo (Poblacion West)','San Jose','San Juan','San Roque','San Vicente','Santa Cruz','Santa Maria','Santo Tomas'],
'San Manuel' => ['Cabacaraan','Flores','Guiset Norte','Guiset Sur','Lapalo','Narra','Pao','San Bonifacio','San Felipe','San Guillermo','San Isidro','San Juan','San Roque','San Vicente','Santo Domingo'],
'San Nicolas' => ['Bensican','Cabitnongan','Caboloan','Cacabugaoan','Calanutian','Calaocan','Camanggaan','Camindoroan','Casaratan','Dalumpinas','Fianza','Lungao','Malico','Malilion','Nagkaysa','Nining','Poblacion East','Poblacion West','Salingcob','Salpad','San Felipe East','San Felipe West','San Isidro (Sta. Cruzan)','San Jose','San Rafael Centro','San Rafael East','San Rafael West','San Roque','Santa Maria East','Santa Maria West','Santo Tomas','Siblot','Sobol'],
'San Quintin' => ['Alac','Baligayan','Bantog','Bolintaguen','Cabangaran','Cabalaoangan','Calomboyan','Carayacan','Casantamaria-an','Gonzalo','Labuan','Lagasit','Lumayao','Mabini','Mantacdang','Nangapugan','San Pedro','Ungib','Poblacion Zone I','Poblacion Zone II','Poblacion Zone III'],
'Santa Barbara' => ['Alibago','Balingueo','Banaoang','Banzal','Botao','Cablong','Carusocan','Dalongue','Erfe','Gueguesangen','Leet','Malanay','Maningding','Maronong','Maticmatic','Minien East','Minien West','Nilombot','Patayac','Payas','Tebag East','Tebag West','Poblacion Norte','Poblacion Sur','Primicias','Sapang','Sonquil','Tuliao','Ventenilla'],
'Santa Maria' => ['Bal-loy','Bantog','Caboluan','Cal-litang','Capandanan','Cauplasan','Dalayap','Libsong','Namagbagan','Paitan','Pataquid','Pilar','Poblacion East','Poblacion West','Pugot','Samon','San Alejandro','San Mariano','San Pablo','San Patricio','San Vicente','Santa Cruz','Sta. Rosa'],
'Santo Tomas' => ['La Luna','Poblacion East','Poblacion West','Salvacion','San Agustin','San Antonio','San Jose','San Marcos','Santo Domingo','Santo Ni\u00f1o'],
'Sison' => ['Agat','Alibeng','Amagbagan','Artacho','Asan Norte','Asan Sur','Bantay Insik','Bila','Binmeckeg','Bulaoen East','Bulaoen West','Cabaritan','Calunetan','Camangaan','Cauringan','Dungon','Esperanza','Inmalog','Killo','Labayug','Paldit','Pindangan','Pinmilapil','Poblacion Central','Poblacion Norte','Poblacion Sur','Sagunto','Tara-tara'],
'Sual' => ['Baquioen','Baybay Norte','Baybay Sur','Bolaoen','Cabalitian','Calumbuyan','Camagsingalan','Caoayan','Capantolan','Macaycayawan','Paitan East','Paitan West','Pangascasan','Poblacion','Santo Domingo','Seselangen','Sioasio East','Sioasio West','Victoria'],
'Tayug' => ['Agno','Amistad','Barangobong','C. Lichauco','Carriedo','Evangelista','Guzon','Lawak','Legaspi','Libertad','Magallanes','Panganiban','Poblacion A','Poblacion B','Poblacion C','Poblacion D','Saleng','Santo Domingo','Toketec','Trenchera','Zamora'],
'Umingan' => ['Abot Molina','Alo-o','Amaronan','Annam','Bantug','Baracbac','Barat','Buenavista','Cabalitian','Cabangaran','Cabaruan','Cabatuan','Cadiz','Calitlitan','Capas','Carayungan Sur','Carosalesan','Casilan','Caurdanetaan','Concepcion','Decreto','Del Rosario','Diaz','Diket','Don Justo \u00c1balos','Don Montano','Esperanza','Evangelista','Flores','Fulgusino','Gonzales','La Paz','Labuan','Lauren','Lubong','Luna Este','Luna Weste','Mantacdang','Maseil-seil','Nampalcan','Nancalabasaan','Pangangaan','Papallasen','Pemienta','Poblacion East','Poblacion West','Prado','Resurreccion','Ricos','San Andr\u00e9s','San Juan','San Leon','San Pablo','San Vicente','Santa Mar\u00eda','Santa Rosa','Sinabaan','Tanggal Sawang'],
'Urbiztondo' => ['Angatel','Balangay','Batangcaoa','Baug','Bayaoas','Bituag','Camambugan','Dalanguiring','Duplac','Galarin','Gueteb','Malaca','Malayo','Malibong','Pasibi East','Pasibi West','Pisuac','Poblacion','Real','Salavante','Sawat'],
'Villasis' => ['Amamperez','Bacag','Barangobong','Barraca','Capulaan','Caramutan','La Paz','Labit','Lipay','Lomboy','Piaz (Plaza)','Puelay','San Blas','San Nicolas','Tombod','Unzad','Zone I (Poblacion)','Zone II (Poblacion)','Zone III (Poblacion)','Zone IV (Poblacion)','Zone V (Poblacion)']
 ];
  $zipCodes = [
'Agno' => '2408','Aguilar' => '2415','Alcala' => '2425','Anda' => '2405','Asingan' => '2439','Balungao' => '2442',
'Bani' => '2407','Basista' => '2422','Bautista' => '2424','Bayambang' => '2423','Binalonan' => '2436','Binmaley' => '2417',
'Bolinao' => '2406','Bugallon' => '2416','Burgos' => '2410','Calasiao' => '2418','Dasol' => '2411','Infanta' => '2412',
'Labrador' => '2402','Laoac' => '2437','Lingayen' => '2401','Mabini' => '2409','Malasiqui' => '2421','Manaoag' => '2430',
'Mangaldan' => '2432','Mangatarem' => '2413','Mapandan' => '2429','Natividad' => '2414','Pozorrubio' => '2435','Rosales' => '2441',
'San Fabian' => '2427','San Jacinto' => '2438','San Manuel' => '2426','San Nicolas' => '2416','San Quintin' => '2419','Santa Barbara' => '2420',
'Santa Maria' => '2410','Santo Tomas' => '2415','Sison' => '2414','Sual' => '2403','Tayug' => '2434','Umingan' => '2433',
'Urbiztondo' => '2428','Villasis' => '2431','Dagupan' => '2400'
];


   
   // we will embed these two arrays as JSON below via Blade's @json
  @endphp

  {{-- Sender & Receiver address fragments (same renderAddressInput you used before) --}}
  @php
    function renderAddressInput($prefix) {
        return '
        <div class="form-card mb-4">
            <h5 class="title">'.ucfirst($prefix).' Address</h5>
            <div class="row g-3 address-wrapper">
                <div class="col-md-6">
                    <label class="form-label">Phone Number *</label>
                    <input type="text" id="'.$prefix.'_phone" name="'.$prefix.'_phone" class="form-control" placeholder="09xxxxxxxxx" maxlength="11" required>
                    <div class="invalid-msg" id="'.$prefix.'_phone_err">Phone is required</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Name *</label>
                    <input type="text" id="'.$prefix.'_name" name="'.$prefix.'_name" class="form-control" placeholder="'.ucfirst($prefix).' name" maxlength="50" required>
                    <div class="invalid-msg" id="'.$prefix.'_name_err">Name is required</div>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Address *</label>
                    <input type="text" id="'.$prefix.'_address" name="'.$prefix.'_address" class="form-control address-input" placeholder="Region I - Pangasinan / City / Barangay" required readonly>
                    <div class="invalid-msg" id="'.$prefix.'_address_err">Address selection is required</div>
                </div>
                <div class="col-md-12" id="'.$prefix.'_detailed_wrapper" style="display:none;">
                    <label class="form-label">Detailed Address</label>
                    <input type="text" id="'.$prefix.'_detailed" name="'.$prefix.'_detailed" class="form-control" placeholder="House number, street, unit, etc." required>
                </div>
            </div>
        </div>';
    }
  @endphp

  {!! renderAddressInput('sender') !!}
  {!! renderAddressInput('receiver') !!}

  <!-- PARCEL INFORMATION & COST -->
  <div class="form-card mb-4 shadow-sm p-4 border border-light bg-white rounded-4">
    <div class="d-flex justify-content-between align-items-start mb-3">
      <div>
        <h5 class="title text-primary mb-0"><i class="bx bx-cube"></i> Parcel Information & Cost</h5>
        <div class="muted-small">Transparent calculation preview below</div>
      </div>
    </div>

    <div class="row g-3">
      <!-- Basics -->
      <div class="col-md-6">
        <label class="form-label fw-semibold">Item Name *</label>
        <input type="text" id="item_name" name="item_name" class="form-control" placeholder="Item name" required>
        <div class="invalid-msg" id="item_name_err">Item name is required</div>
      </div>

      <div class="col-md-3">
        <label class="form-label fw-semibold">Parcel Value (₱)</label>
        <input type="number" id="parcel_value" name="parcel_value" class="form-control" placeholder="e.g. 500">
        <div class="invalid-msg" id="parcel_value_err">Enter a valid value or leave blank</div>
      </div>

      <div class="col-md-3">
        <label class="form-label fw-semibold">Parcel Type *</label>
        <select id="parcelType" name="parcel_type" class="form-select" required>
          <option value="" disabled selected>Select Type</option>
          <option value="pouch">Pouch</option>
          <option value="custom">Customized Box</option>
        </select>
        <div class="invalid-msg" id="parcel_type_err">Parcel type is required</div>
      </div>

      <!-- Dimensions & weight (hidden by default; shown only when customized box selected) -->
      <div id="customOptions" class="row g-3 mt-2" style="display:none;">
        <div class="col-md-3">
          <label class="form-label">Length (cm)</label>
          <input type="number" id="customL" name="dimension_l" class="form-control" min="0" step="0.1" placeholder="L">
          <div class="invalid-msg" id="customL_err">Enter a valid length</div>
        </div>
        <div class="col-md-3">
          <label class="form-label">Width (cm)</label>
          <input type="number" id="customW" name="dimension_w" class="form-control" min="0" step="0.1" placeholder="W">
          <div class="invalid-msg" id="customW_err">Enter a valid width</div>
        </div>
        <div class="col-md-3">
          <label class="form-label">Height (cm)</label>
          <input type="number" id="customH" name="dimension_h" class="form-control" min="0" step="0.1" placeholder="H">
          <div class="invalid-msg" id="customH_err">Enter a valid height</div>
        </div>
        <div class="col-md-3">
          <label class="form-label">Weight (kg)</label>
          <input type="number" id="customWeight" name="parcel_weight" class="form-control" min="0" step="0.1" placeholder="Kg">
          <div class="invalid-msg" id="customWeight_err">Enter a valid weight</div>
        </div>
      </div>

      <!-- Pouch options -->
      <div id="pouchOptions" class="col-md-6 mt-3" style="display:none;">
        <label class="form-label fw-semibold">Pouch Size *</label>
        <select id="pouchSize" name="pouch_size" class="form-select">
          <option value="" disabled selected>Select Size</option>
          <option value="small">Small (₱55)</option>
          <option value="medium">Medium (₱65)</option>
          <option value="large">Large (₱75)</option>
        </select>
        <div class="invalid-msg" id="pouchSize_err">Choose pouch size</div>
      </div>

      <div class="col-md-6 mt-3">
        <label class="form-label fw-semibold">Distance Cost (₱)</label>
        <input type="text" id="distanceCost" class="form-control" readonly placeholder="Auto calculated">
        <div id="liveFuelRate" class="muted-small mt-1"></div>
      </div>
    </div>

    <!-- Distance Breakdown (detailed) -->
    <div id="distanceBreakdownCard" class="mt-3 p-3 border rounded-3" style="display:block; background:#fbfdff;">
      <div class="d-flex justify-content-between">
        <div class="fw-bold text-primary"><i class="bx bx-map"></i> Distance Breakdown</div>
        <!--<div class="muted-small">All costs are estimates — calculations shown</div>-->
      </div>

      <div class="row mt-2 small-muted">
        <div class="col-md-6">
          <b>Base hub:</b> <span id="baseCityLabel">Rosales</span><br>
          <b>From:</b> <span id="fromCity">-</span><br>
          <b>To:</b> <span id="toCity">-</span>
        </div>
        <div class="col-md-6 text-md-end">
          <div>🚚 <b>Total Distance:</b> <span id="distanceKm">0.00</span> km</div>
          <div>⛽ <b>Fuel needed:</b> <span id="fuelLiters">0.000</span> L</div>
        </div>
      </div>

      <hr class="my-2">

      <div class="row small-muted">
        <div class="col-md-6">
          ⛽ <b>Fuel cost:</b> ₱<span id="fuelCost">0.00</span><br>
          🔧 <b>Maintenance:</b> ₱<span id="maintenanceCost">82.19</span>
        </div>
        <div class="col-md-6 text-md-end">
          💰 <b>Total distance cost:</b> <span class="fw-bold">₱<span id="distanceCostDisplay">0.00</span></span>
        </div>
      </div>

      <!-- transparent math display 
      <div class="mt-3">
        <div class="transparent-math" id="distanceMath">
          Fuel calculation will appear here once both addresses are selected.
        </div>
      </div>
    </div>-->

    <!-- Custom Box breakdown (transparent) -->
    <div id="customBreakdown" class="mt-3 p-3 bg-light border rounded-3 text-secondary small" style="display:none;">
      <div class="fw-bold mb-2 text-primary"><i class="bx bx-cube"></i> Box Cost Breakdown</div>
      <div class="calc-grid">
        <div>⚖️ Weight charge<!-- (kg - 3) × 10-->:</div><div class="text-end">₱<span id="weightCost">0.00</span></div>
        <div>📦 Size charge<!--(L×W×H / 3500) + 95-->:</div><div class="text-end">₱<span id="volumeCost">0.00</span></div>
        <div class="mt-2"><b>Total box cost:</b></div><div class="text-end"><b>₱<span id="customCost">0.00</span></b></div>
      </div>
     <!-- <div class="mt-2 transparent-math" id="boxMath">
      </div>-->
    </div>

    <!-- TOTAL DISPLAY -->
    <div class="mt-4 text-center p-3 rounded-4 bg-jace">
      <div class="muted-small">Transparent total — distance + pouch/box</div>
      <div class="big-total fw-bold mt-2" id="grandTotalDisplay">₱0.00</div>
      <input type="hidden" id="totalCost" name="total_cost">
    </div>
  </div>

  <!-- PAYMENT OPTIONS (cards, not radio buttons) -->
  <div class="form-card mb-4">
    <h5 class="title"><i class="bx bx-wallet"></i> Payment Options</h5>

    <div class="d-flex gap-3 mb-3">
      <div id="btnPayPickup" class="payment-card flex-fill text-center p-3 selectable active" data-value="pay_pickup">
        <i class="bx bx-package fs-4"></i>
        <div class="fw-semibold mt-1">Pay on Pickup</div>
        <div class="muted-small">Pay when courier picks up (cash)</div>
      </div>
      <div id="btnPayNow" class="payment-card flex-fill text-center p-3 selectable" data-value="pay_now">
        <i class="bx bx-credit-card fs-4"></i>
        <div class="fw-semibold mt-1">Pay Now</div>
        <div class="muted-small">Online payment (GCash / Bank)</div>
      </div>
    </div>

    <input type="hidden" id="paymentOption" name="payment_option" value="pay_pickup">

    <div id="paymentMethods" style="display:none;">
      <div class="d-flex gap-3 mb-3">
        <div id="btnGCash" class="method-card flex-fill text-center p-3 selectable" data-value="gcash">
          <i class="bx bxl-gcash fs-4"></i>
          <div class="fw-semibold mt-1">GCash</div>
          <div class="muted-small">Pay with GCash</div>
        </div>
        <div id="btnBank" class="method-card flex-fill text-center p-3 selectable" data-value="bank_transfer">
          <i class="bx bx-bank fs-4"></i>
          <div class="fw-semibold mt-1">Bank Transfer</div>
          <div class="muted-small">Pay via bank</div>
        </div>
      </div>

      <input type="hidden" id="paymentMethod" name="payment_method" value="">
      <div id="paymentDetails" style="display:none;">
        <div id="gcashDetails" style="display:none;" class="p-3 border rounded">
          <div class="muted-small">Send to:</div>
          <div class="fw-bold">0917-XXX-XXXX (Jace Pick-up and Delivery Services)</div>
        </div>
        
        <div id="bankDetails" style="display:none;" class="p-3 border rounded">
          <div class="muted-small">Bank account:</div>
          <div class="fw-bold">Jace Pick-up and Delivery Services - Account #123456789</div>
        </div>
      </div>
    </div>
  </div>
<!-- Add this after the bankDetails div -->
<div id="proofUploadSection" style="display:none;" class="p-3 border rounded mt-3">
  <div class="mb-3">
    <label class="form-label fw-semibold">Upload Payment Proof *</label>
    <input type="file" id="paymentProof" name="payment_proof" class="form-control" accept="image/*,.pdf">
    <div class="invalid-msg" id="payment_proof_err">Payment proof is required for online payments</div>
    <div class="muted-small mt-1">Screenshot of payment confirmation or receipt</div>
  </div>
</div>
  <!-- Floating Total Shipment Summary (open by default) -->
  <div id="fixedCostSummary" class="shadow-lg border rounded-4 bg-white p-3 position-fixed">
    <div class="head mb-2">
      <div>
        <h6 class="mb-0 text-primary fw-bold"><i class="bx bx-calculator"></i> Total Shipment</h6>
        <div class="small-muted">Quick summary</div>
      </div>
      <div>
        <button id="toggleSummary" class="btn btn-sm btn-min" title="Expand/Collapse">
          <i id="toggleIcon" class="bx bx-chevron-up"></i>
        </button>
      </div>
    </div>
    <div id="summaryContent">
      <div class="break-row mb-2">
        <div class="small-muted">Distance</div>
        <div class="fw-bold">₱<span id="summaryDistance">0.00</span></div>
      </div>
      <div class="break-row mb-2">
        <div class="small-muted">Box/Pouch</div>
        <div class="fw-bold">₱<span id="summaryBox">0.00</span></div>
      </div>
      <hr>
      <div class="break-row">
        <div class="fw-semibold">Estimated Total</div>
        <div class="fw-bold fs-4 text-success">₱<span id="summaryTotal">0.00</span></div>
      </div>
    </div>

    {{-- Hidden inputs for breakdown to post --}}
    <input type="hidden" name="distance_km" id="distance_km">
    <input type="hidden" name="fuel_liters" id="fuel_liters">
    <input type="hidden" name="fuel_cost" id="fuel_cost">
    <input type="hidden" name="maintenance_cost" id="maintenance_cost">
    <input type="hidden" name="box_size_cost" id="box_size_cost">
    <input type="hidden" name="box_weight_cost" id="box_weight_cost">
    <input type="hidden" name="box_total_cost" id="box_total_cost">
    <input type="hidden" name="total_cost" id="totalCost">

    <div class="mt-4 d-flex justify-content-start align-items-center gap-3">
      <button type="submit" class="btn btn-dark px-4 py-2">
        <i class="bx bx-send"></i> Submit Order
      </button>
    </div>
  </div>

</form>

<!-- success modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center p-4">
        <h5 class="text-success">Order Submitted Successfully!</h5>
        <p class="muted-small">Tracking number will be emailed to you. Redirecting...</p>
        <button type="button" class="btn btn-jace mt-3" id="redirectBtn">OK</button>
      </div>
    </div>
  </div>
</div>
<!-- Add this after your successModal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center p-4">
        <h5 class="text-primary mb-3">Complete Your Payment</h5>
        <div id="paymentModalContent"></div>
        <div class="mt-3">
          <button type="button" class="btn btn-jace" id="confirmPaymentBtn">I have completed the payment</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* --- All runtime JS below --- */
const cityBarangays = @json($cityBarangays);
const zipCodes = @json($zipCodes);

// --- Rosales lookup distances (use the table you provided) ---
const rosalesDistances = {
  "Agno": 119.98, "Aguilar": 62.8, "Alaminos": 90.2, "Alcala": 12.6, "Anda": 132, "Asingan": 18.9,
  "Balungao": 8.6, "Bani": 111, "Basista": 32.6, "Bautista": 24.3, "Bayambang": 23.1, "Binalonan": 26.9,
  "Binmaley": 49.3, "Bolinao": 123, "Bugallon": 69.1, "Burgos": 117, "Calasiao": 47.8, "Dagupan": 52.7,
  "Dasol": 126, "Infanta": 110, "Labrador": 65.7, "Laoac": 28.7, "Lingayen": 55, "Mabini": 128,
  "Malasiqui": 26.9, "Manaoag": 34.7, "Mangaldan": 46.1, "Mangatarem": 51.8, "Mapandan": 37.3,
  "Natividad": 31.2, "Pozorrubio": 37.5, "Rosales": 4.7, "San Carlos": 34.6, "San Fabian": 69.9,
  "San Jacinto": 36.7, "San Manuel": 29.4, "San Nicolas": 34.2, "San Quintin": 30, "Sison": 41.5,
  "Santa Barbara": 31.3, "Santa Maria": 14.3, "Santo Tomas": 6.4, "Sual": 81.4, "Tayug": 21.3,
  "Umingan": 27.9, "Urbiztondo": 38.5, "Urdaneta": 18.8, "Villasis": 15.2, "Dagupan": 52.7
};

// Address dropdown setup
function setupAddressInput(inputId, detailedWrapperId) {
  const input = document.getElementById(inputId);
  const detailedWrapper = document.getElementById(detailedWrapperId);
  const wrapper = input.closest('.address-wrapper') || input.parentNode;
  const regionPrefix = "Region I - Pangasinan / ";

  input.readOnly = true;
  let dropdown = wrapper.querySelector('.dropdown-list');
  if (!dropdown) {
    dropdown = document.createElement('div');
    dropdown.className = 'dropdown-list';
    wrapper.appendChild(dropdown);
  }

  let selectedCity = '';
  let stage = 'city'; // city -> barangay -> done

  function showDropdown(items) {
    if (!items || items.length === 0) { dropdown.style.display = 'none'; return; }
    dropdown.innerHTML = items.map(i => `<div class="d-item">${i}</div>`).join('');
    dropdown.style.display = 'block';
  }
  function hideDropdown() { dropdown.style.display = 'none'; }

  function resetCityStage() {
    stage = 'city';
    selectedCity = '';
    input.value = regionPrefix;
    if (detailedWrapper) detailedWrapper.style.display = 'none';
    showDropdown(Object.keys(cityBarangays));
  }
  function resetBarangayStage() {
    stage = 'barangay';
    if (detailedWrapper) detailedWrapper.style.display = 'none';
    showDropdown(cityBarangays[selectedCity] || []);
  }

  input.value = regionPrefix;

  input.addEventListener('click', (ev) => {
    ev.stopPropagation();
    if (stage === 'city') showDropdown(Object.keys(cityBarangays));
    else if (stage === 'barangay') showDropdown(cityBarangays[selectedCity] || []);
  });

  dropdown.addEventListener('click', e => {
    const target = e.target.closest('.d-item');
    if (!target) return;
    const val = target.textContent.trim();
    if (stage === 'city') {
      selectedCity = val;
      input.value = `${regionPrefix}${selectedCity}`;
      stage = 'barangay';
      setTimeout(resetBarangayStage, 80);
    } else if (stage === 'barangay') {
      const zip = zipCodes[selectedCity] || '';
      input.value = `${regionPrefix}${selectedCity} / ${val} / ${zip}`;
      stage = 'done';
      if (detailedWrapper) detailedWrapper.style.display = 'block';
      hideDropdown();
      computeDistanceIfReady();
    }
  });

  input.addEventListener('dblclick', (e) => { e.stopPropagation(); resetCityStage(); });
  document.addEventListener('click', (e) => { if (!wrapper.contains(e.target)) hideDropdown(); });

  input._reset = resetCityStage;
  input._show = () => { if (stage === 'city') showDropdown(Object.keys(cityBarangays)); };
}

// initialize address inputs
setupAddressInput('sender_address', 'sender_detailed_wrapper');
setupAddressInput('receiver_address', 'receiver_detailed_wrapper');

// Constants
const BASE_CITY = 'Rosales';
const KM_PER_LITER = 15.43;
let DIESEL_PRICE = 54.00; // fallback
const MAINTENANCE_PER_TRIP = 82.19;

// coords map (used for pickup->delivery haversine if needed)
const cityCoords = {
  "Agno": [16.0800, 119.8000], "Aguilar": [15.8324, 120.2373], "Alaminos": [16.1557, 119.9808],
  "Alcala": [15.8478, 120.5234], "Anda":[16.2862,119.9468], "Asingan":[16.0022,120.6696],
  "Balungao":[15.8962,120.6987], "Bani":[16.1891,119.8655], "Basista":[15.8483,120.3979],
  "Bautista":[15.7782,120.4828], "Bayambang":[15.8129,120.4529], "Binalonan":[16.0432,120.5938],
  "Binmaley":[16.0328,120.2695], "Bolinao":[16.3875,119.8783], "Bugallon":[15.9518,120.2167],
  "Burgos":[16.0631,119.8623], "Calasiao":[16.0025,120.3564], "Dagupan":[16.0433,120.3333],
  "Dasol":[15.9913,119.8873], "Infanta":[15.8315,119.9056], "Labrador":[16.0271,120.1495],
  "Laoac":[16.0543,120.5302], "Lingayen":[16.0218,120.2313], "Mabini":[16.0755,119.9632],
  "Malasiqui":[15.9198,120.4063], "Manaoag":[16.0434,120.4858], "Mangaldan":[16.0708,120.4384],
  "Mangatarem":[15.7883,120.2922], "Mapandan":[16.0225,120.4582], "Natividad":[16.0488,120.7869],
  "Pozorrubio":[16.1152,120.5473], "Rosales":[15.8931,120.6328], "San Carlos":[15.9300,120.3500],
  "San Fabian":[16.1233,120.4515], "San Jacinto":[16.0665,120.4416], "San Manuel":[16.0704,120.6591],
  "San Nicolas":[16.0666,120.7732], "San Quintin":[15.9892,120.8366], "Sison":[16.1735,120.5194],
  "Santa Barbara":[15.9798,120.4306], "Santa Maria":[15.9789,120.7095], "Santo Tomas":[15.9194,120.5773],
  "Sual":[16.0671,120.0913], "Tayug":[16.0243,120.7431], "Umingan":[15.9158,120.7987],
  "Urbiztondo":[15.8156,120.3354], "Urdaneta":[15.9750,120.5700], "Villasis":[15.9016,120.5884]
};

// DOM elements
const distanceCostInput = document.getElementById('distanceCost');
const distanceCostDisplay = document.getElementById('distanceCostDisplay');
const distanceBreakdownCard = document.getElementById('distanceBreakdownCard');
const baseCityLabel = document.getElementById('baseCityLabel');
const fromCityLabel = document.getElementById('fromCity');
const toCityLabel = document.getElementById('toCity');
const distanceKmEl = document.getElementById('distanceKm');
const fuelLitersEl = document.getElementById('fuelLiters');
const fuelCostEl = document.getElementById('fuelCost');
const maintenanceCostEl = document.getElementById('maintenanceCost');

const pouchOptionsEl = document.getElementById('pouchOptions');
const pouchSizeEl = document.getElementById('pouchSize');

const customBreakdownEl = document.getElementById('customBreakdown');
const weightCostEl = document.getElementById('weightCost');
const volumeCostEl = document.getElementById('volumeCost');
const customCostEl = document.getElementById('customCost');

const grandTotalDisplay = document.getElementById('grandTotalDisplay');
const totalCostHidden = document.getElementById('totalCost');

const summaryDistanceEl = document.getElementById('summaryDistance');
const summaryBoxEl = document.getElementById('summaryBox');
const summaryTotalEl = document.getElementById('summaryTotal');
const fixedSummary = document.getElementById('fixedCostSummary');
const toggleSummaryBtn = document.getElementById('toggleSummary');
const toggleIcon = document.getElementById('toggleIcon');

const distanceMathEl = document.getElementById('distanceMath');
const boxMathEl = document.getElementById('boxMath');

// Payment elements
const btnPayPickup = document.getElementById('btnPayPickup');
const btnPayNow = document.getElementById('btnPayNow');
const paymentOptionInput = document.getElementById('paymentOption');
const paymentMethodsWrap = document.getElementById('paymentMethods');
const btnGCash = document.getElementById('btnGCash');
const btnBank = document.getElementById('btnBank');
const paymentMethodInput = document.getElementById('paymentMethod');
const paymentDetails = document.getElementById('paymentDetails');
const gcashDetails = document.getElementById('gcashDetails');
const bankDetails = document.getElementById('bankDetails');

// state
let state = { distanceCost:0, pouchCost:0, customCost:0, totalKm:0, fuelLiters:0 };

// fetch fuel price (optional endpoint)
async function fetchFuelPrice() {
  try {
    const res = await fetch('/api/fuel-price');
    if (!res.ok) throw new Error('no api');
    const body = await res.json();
    if (body && body.diesel_price) DIESEL_PRICE = parseFloat(body.diesel_price);
    document.getElementById('liveFuelRate').textContent = `⛽ Diesel Price: ₱${DIESEL_PRICE.toFixed(2)}`;
  } catch (err) {
    document.getElementById('liveFuelRate').textContent = `⛽ Using fallback diesel price: ₱${DIESEL_PRICE.toFixed(2)}`;
  }
}
fetchFuelPrice();

// haversine (for pickup→delivery distance)
function toRad(deg){ return deg * Math.PI / 180; }
function haversine(lat1, lon1, lat2, lon2) {
  const R = 6371;
  const dLat = toRad(lat2 - lat1);
  const dLon = toRad(lon2 - lon1);
  const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  return R * c;
}

function extractCityFromInput(str) {
  if (!str) return null;
  const parts = str.split('/').map(s => s.trim()).filter(Boolean);
  if (parts.length >= 2) return parts[1];
  for (let k of Object.keys(cityCoords)) { if (str.includes(k)) return k; }
  return null;
}

// compute distance and cost
function computeDistanceIfReady() {
  const senderVal = document.getElementById('sender_address').value || '';
  const receiverVal = document.getElementById('receiver_address').value || '';

  const senderCity = extractCityFromInput(senderVal);
  const receiverCity = extractCityFromInput(receiverVal);

  if (!senderCity || !receiverCity) {
    distanceMathEl.textContent = 'Select both addresses (city + barangay) to compute distance & fuel.';
    state.distanceCost = 0;
    updateTotalsUI();
    return;
  }

  // dist1: Rosales -> pickup from lookup; fallback to haversine if missing
  let dist1 = rosalesDistances[senderCity] ?? null;
  if (dist1 === null) {
    // fallback using coords if available
    if (cityCoords[BASE_CITY] && cityCoords[senderCity]) {
      const [rLat,rLon] = cityCoords[BASE_CITY];
      const [sLat,sLon] = cityCoords[senderCity];
      dist1 = haversine(rLat,rLon,sLat,sLon) * 1.2;
    } else {
      distanceMathEl.textContent = 'Missing coordinates for Rosales→pickup lookup.';
      state.distanceCost = 0;
      updateTotalsUI();
      return;
    }
  } else {
    // we have table value; use it directly (table values are road km)
    // still apply road factor? table already road distances — do not multiply further.
  }

  // dist2: pickup -> delivery (compute using coords if possible; fallback to difference of Rosales distances approx)
  let dist2 = null;
  if (cityCoords[senderCity] && cityCoords[receiverCity]) {
    const [sLat,sLon] = cityCoords[senderCity];
    const [dLat,dLon] = cityCoords[receiverCity];
    dist2 = haversine(sLat,sLon,dLat,dLon) * 1.2;
  } else {
    // fallback approx: |Rosales->Receiver - Rosales->Sender|
    if (rosalesDistances[receiverCity] != null && rosalesDistances[senderCity] != null) {
      dist2 = Math.abs(rosalesDistances[receiverCity] - rosalesDistances[senderCity]);
    } else {
      distanceMathEl.textContent = 'Missing coordinates to compute pickup→delivery distance.';
      state.distanceCost = 0;
      updateTotalsUI();
      return;
    }
  }

  const totalKm = Number(dist1) + Number(dist2);

  // fuel liters formula: (totalKm - 3) / 15.43 (never negative)
  const liters = Math.max((totalKm - 3), 0) / KM_PER_LITER;
  const dieselCost = liters * DIESEL_PRICE;
  const totalDistanceCost = dieselCost + MAINTENANCE_PER_TRIP;

  // update state & UI
  state.totalKm = totalKm;
  state.fuelLiters = liters;
  state.distanceCost = totalDistanceCost;

  document.getElementById('distance_km').value = totalKm.toFixed(2);
  document.getElementById('fuel_liters').value = liters.toFixed(3);
  document.getElementById('fuel_cost').value = dieselCost.toFixed(2);
  document.getElementById('maintenance_cost').value = MAINTENANCE_PER_TRIP.toFixed(2);

  document.getElementById('distanceKm').textContent = totalKm.toFixed(2);
  document.getElementById('fuelLiters').textContent = liters.toFixed(3);
  document.getElementById('fuelCost').textContent = dieselCost.toFixed(2);
  document.getElementById('maintenanceCost').textContent = MAINTENANCE_PER_TRIP.toFixed(2);
  document.getElementById('distanceCostDisplay').textContent = totalDistanceCost.toFixed(2);
  distanceCostInput.value = totalDistanceCost.toFixed(2);

  baseCityLabel.textContent = BASE_CITY;
  fromCityLabel.textContent = senderCity;
  toCityLabel.textContent = receiverCity;

 //<!-- // Build transparent math string
 // const mathLines = [];
 // mathLines.push(`Rosales→${senderCity} = ${Number(dist1).toFixed(2)} km`);
 // mathLines.push(`${senderCity}→${receiverCity} = ${Number(dist2).toFixed(2)} km`);
 // mathLines.push(`Total distance = ${Number(dist1).toFixed(2)} + ${Number(dist2).toFixed(2)} = ${totalKm.toFixed(2)} km`);
 // mathLines.push(`Fuel formula: (totalKm - 3) ÷ ${KM_PER_LITER} => (${totalKm.toFixed(2)} - 3) ÷ ${KM_PER_LITER} = ${liters.toFixed(3)} L`);
//  mathLines.push(`Diesel cost: ${liters.toFixed(3)} × ₱${DIESEL_PRICE.toFixed(2)} = ₱${dieselCost.toFixed(2)}`);
 // mathLines.push(`Maintenance: ₱${MAINTENANCE_PER_TRIP.toFixed(2)}`);
 // mathLines.push(`Total distance cost = ₱${dieselCost.toFixed(2)} + ₱${MAINTENANCE_PER_TRIP.toFixed(2)} = ₱${totalDistanceCost.toFixed(2)}`);

  distanceMathEl.innerHTML = mathLines.map(l => `<div>${l}</div>`).join('<br>');
  updateTotalsUI();
}

// pouch handling
if (pouchSizeEl) {
  pouchSizeEl.addEventListener('change', e => {
    const size = e.target.value;
    state.pouchCost = size === 'small' ? 55 : size === 'medium' ? 65 : size === 'large' ? 75 : 0;
    updateTotalsUI();
  });
}

// parcel type toggle (show/hide custom inputs)
const parcelTypeEl = document.getElementById('parcelType');
parcelTypeEl.addEventListener('change', (e) => {
  const val = e.target.value;
  if (val === 'pouch') {
    pouchOptionsEl.style.display = 'block';
    customBreakdownEl.style.display = 'none';
    document.getElementById('customOptions').style.display = 'none';
    state.customCost = 0;
    // set default weight for pouch
    const w = document.getElementById('customWeight');
    if (w) w.value = '';
  } else if (val === 'custom') {
    pouchOptionsEl.style.display = 'none';
    customBreakdownEl.style.display = 'block';
    document.getElementById('customOptions').style.display = 'flex';
    state.pouchCost = 0;
  } else {
    pouchOptionsEl.style.display = 'none';
    customBreakdownEl.style.display = 'none';
    document.getElementById('customOptions').style.display = 'none';
    state.pouchCost = 0;
    state.customCost = 0;
  }
  updateTotalsUI();
});

// custom box calculations (user requested specific formulas):
// sizeCharge = (L*W*H)/3500 + 95
// kgCharge = max((kg - 3), 0) * 10
function calcCustomCost() {
  const weight = parseFloat(document.getElementById('customWeight').value) || 0;
  const l = parseFloat(document.getElementById('customL').value) || 0;
  const w = parseFloat(document.getElementById('customW').value) || 0;
  const h = parseFloat(document.getElementById('customH').value) || 0;

  const volume = l * w * h;
  const sizeCharge = (volume / 3500) + 95;
  const kgCharge = Math.max((weight - 3), 0) * 10;
  const customTotal = sizeCharge + kgCharge;

  document.getElementById('box_size_cost').value = sizeCharge.toFixed(2);
  document.getElementById('box_weight_cost').value = kgCharge.toFixed(2);
  document.getElementById('box_total_cost').value = customTotal.toFixed(2);

  weightCostEl.textContent = kgCharge.toFixed(2);
  volumeCostEl.textContent = sizeCharge.toFixed(2);
  customCostEl.textContent = customTotal.toFixed(2);

  //const boxMathLines = [];
 // boxMathLines.push(`Dimensions: ${l}×${w}×${h} = ${volume.toFixed(2)} cm³`);
 // boxMathLines.push(`Size charge: (L×W×H ÷ 3500) + 95 => (${volume.toFixed(2)} ÷ 3500) + 95 = ${sizeCharge.toFixed(2)}`);
 // boxMathLines.push(`Weight charge: max((kg - 3), 0) × 10 => max((${weight.toFixed(2)} - 3), 0) × 10 = ${kgCharge.toFixed(2)}`);
//  boxMathLines.push(`Total box cost = ₱${sizeCharge.toFixed(2)} + ₱${kgCharge.toFixed(2)} = ₱${customTotal.toFixed(2)}`);
//  boxMathEl.innerHTML = boxMathLines.map(l => `<div>${l}</div>`).join('<br>');

  state.customCost = customTotal;
  updateTotalsUI();
}

['customWeight','customL','customW','customH'].forEach(id => {
  const el = document.getElementById(id);
  if (el) el.addEventListener('input', calcCustomCost);
});

// update totals
function updateTotalsUI() {
  const total = (state.distanceCost || 0) + (state.pouchCost || 0) + (state.customCost || 0);
  grandTotalDisplay.textContent = `₱${total.toFixed(2)}`;
  totalCostHidden.value = total.toFixed(2);
  document.getElementById('totalCost').value = total.toFixed(2);

  summaryDistanceEl.textContent = (state.distanceCost || 0).toFixed(2);
  summaryBoxEl.textContent = ((state.pouchCost || 0) + (state.customCost || 0)).toFixed(2);
  summaryTotalEl.textContent = total.toFixed(2);

  if (total > 0) fixedSummary.style.display = 'block';
  else fixedSummary.style.display = 'none';
}

// summary toggle (open by default)
toggleSummaryBtn.addEventListener('click', () => {
  const content = document.getElementById('summaryContent');
  if (content.style.display === 'none' || !content.style.display) {
    content.style.display = 'block';
    toggleIcon.className = 'bx bx-chevron-up';
  } else {
    content.style.display = 'none';
    toggleIcon.className = 'bx bx-chevron-down';
  }
});

// compute listeners
document.getElementById('sender_address').addEventListener('change', computeDistanceIfReady);
document.getElementById('receiver_address').addEventListener('change', computeDistanceIfReady);

// Payment card logic (clickable cards)
function clearActive(selector) {
  document.querySelectorAll(selector).forEach(el => el.classList.remove('active'));
}

btnPayPickup.addEventListener('click', () => {
  clearActive('.payment-card');
  btnPayPickup.classList.add('active');
  paymentOptionInput.value = 'pay_pickup';
  paymentMethodsWrap.style.display = 'none';
  paymentMethodInput.value = '';
  paymentDetails.style.display = 'none';
  gcashDetails.style.display = 'none';
  bankDetails.style.display = 'none';
});

btnPayNow.addEventListener('click', () => {
  clearActive('.payment-card');
  btnPayNow.classList.add('active');
  paymentOptionInput.value = 'pay_now';
  paymentMethodsWrap.style.display = 'block';
});

// REPLACE the existing btnGCash and btnBank event listeners with this:

btnGCash.addEventListener('click', () => {
  clearActive('.method-card');
  btnGCash.classList.add('active');
  paymentMethodInput.value = 'gcash';
  paymentDetails.style.display = 'block';
  gcashDetails.style.display = 'block';
  bankDetails.style.display = 'none';
  document.getElementById('proofUploadSection').style.display = 'block';
  
  // Show GCash QR or instructions
  document.getElementById('paymentModalContent').innerHTML = `
    <div class="mb-3">
      <p>Please send payment to:</p>
      <div class="fw-bold">GCash: 0917-XXX-XXXX</div>
      <div class="muted-small">Jace Pick-up and Delivery Services</div>
    </div>
    <div class="mb-3">
      <img src="{{ asset('images/gcash-qr.png') }}" alt="GCash QR Code" class="img-fluid border rounded" style="max-width: 250px;">
    </div>
    <div class="alert alert-info small">
      <i class="bx bx-info-circle"></i> After payment, please take a screenshot and upload it as payment proof.
    </div>
  `;
});

btnBank.addEventListener('click', () => {
  clearActive('.method-card');
  btnBank.classList.add('active');
  paymentMethodInput.value = 'bank_transfer';
  paymentDetails.style.display = 'block';
  gcashDetails.style.display = 'none';
  bankDetails.style.display = 'block';
  document.getElementById('proofUploadSection').style.display = 'block';
});

// ---------------- Client-side validation (Inline messages) ----------------
function showError(id, msg) {
  const el = document.getElementById(id);
  if (!el) return;
  el.style.display = 'block';
  // add invalid class to related input
  const input = el.previousElementSibling || el.parentNode.querySelector('input,select,textarea');
  if (input) input.classList.add('is-invalid-field');
}

function clearError(id) {
  const el = document.getElementById(id);
  if (!el) return;
  el.style.display = 'none';
  const input = el.previousElementSibling || el.parentNode.querySelector('input,select,textarea');
  if (input) input.classList.remove('is-invalid-field');
}

function validateFormClient() {
  // Clear all previous errors
  document.querySelectorAll('.invalid-msg').forEach(d => d.style.display = 'none');
  document.querySelectorAll('.is-invalid-field').forEach(i => i.classList.remove('is-invalid-field'));

  let ok = true;

  // required: sender phone/name/address
  if (!document.getElementById('sender_phone').value.trim()) { showError('sender_phone_err'); ok = false; }
  if (!document.getElementById('sender_name').value.trim()) { showError('sender_name_err'); ok = false; }
  if (!document.getElementById('sender_address').value.trim() || document.getElementById('sender_address').value.trim() === 'Region I - Pangasinan /') { showError('sender_address_err'); ok = false; }

  // receiver
  if (!document.getElementById('receiver_phone').value.trim()) { showError('receiver_phone_err'); ok = false; }
  if (!document.getElementById('receiver_name').value.trim()) { showError('receiver_name_err'); ok = false; }
  if (!document.getElementById('receiver_address').value.trim() || document.getElementById('receiver_address').value.trim() === 'Region I - Pangasinan /') { showError('receiver_address_err'); ok = false; }

  // item name
  if (!document.getElementById('item_name').value.trim()) { showError('item_name_err'); ok = false; }

  // parcel type
  const parcelType = document.getElementById('parcelType').value;
  if (!parcelType) { showError('parcel_type_err'); ok = false; }

  // if pouch selected -> pouchSize required
  if (parcelType === 'pouch') {
    const p = document.getElementById('pouchSize').value;
    if (!p) { showError('pouchSize_err'); ok = false; }
  }

  // if custom selected -> dims and weight required
  if (parcelType === 'custom') {
    // require at least weight and dims non-zero
    const l = parseFloat(document.getElementById('customL').value) || 0;
    const w = parseFloat(document.getElementById('customW').value) || 0;
    const h = parseFloat(document.getElementById('customH').value) || 0;
    const kg = parseFloat(document.getElementById('customWeight').value) || 0;
    if (!(l > 0)) { showError('customL_err'); ok = false; }
    if (!(w > 0)) { showError('customW_err'); ok = false; }
    if (!(h > 0)) { showError('customH_err'); ok = false; }
    if (!(kg > 0)) { showError('customWeight_err'); ok = false; }
  }

  // Payment validation: if pay_now -> ensure method chosen
  if (paymentOptionInput.value === 'pay_now' && !paymentMethodInput.value) {
    alert('Please choose a payment method (GCash or Bank Transfer) for "Pay Now".');
    ok = false;
  }
// Add this inside validateFormClient(), BEFORE the "return ok;" line:

// Payment proof validation
if (paymentOptionInput.value === 'pay_now') {
  const proofFile = document.getElementById('paymentProof').files[0];
  if (!proofFile) {
    showError('payment_proof_err');
    ok = false;
  } else {
    // Validate file size (max 5MB)
    if (proofFile.size > 5 * 1024 * 1024) {
      const errEl = document.getElementById('payment_proof_err');
      errEl.textContent = 'File size must be less than 5MB';
      showError('payment_proof_err');
      ok = false;
    }
    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
    if (!allowedTypes.includes(proofFile.type)) {
      const errEl = document.getElementById('payment_proof_err');
      errEl.textContent = 'Only images and PDF files are allowed';
      showError('payment_proof_err');
      ok = false;
    }
  }
}
  return ok;
}

// auto-clear errors on input
document.querySelectorAll('input,select,textarea').forEach(i => {
  i.addEventListener('input', (e) => {
    const id = i.id + '_err';
    clearError(id);
  });
});

// Form submit (AJAX + modal)
const shipmentForm = document.getElementById('shipmentForm');
const successModal = new bootstrap.Modal(document.getElementById('successModal'));
const redirectBtn = document.getElementById('redirectBtn');

// REPLACE the entire shipmentForm.addEventListener('submit', ...) block with this:

shipmentForm.addEventListener('submit', function(e) {
  e.preventDefault();

  if (!validateFormClient()) {
    window.scrollTo({ top: 150, behavior: 'smooth' });
    return;
  }

  // For Pay Now, show payment instructions first
  if (paymentOptionInput.value === 'pay_now') {
    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    paymentModal.show();
    
    // Store form data temporarily
    window.pendingFormData = new FormData(shipmentForm);
    return; // Don't submit yet
  }

  // For Pay on Pickup, submit directly
  submitForm();
});

// Add this new function after the submit handler
document.getElementById('confirmPaymentBtn').addEventListener('click', function() {
  const proofFile = document.getElementById('paymentProof').files[0];
  if (!proofFile) {
    alert('Please upload payment proof before confirming.');
    return;
  }
  
  // Close payment modal
  bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
  
  // Submit the form
  submitForm();
});

// Add this function at the end of your script section
function submitForm() {
  const fd = window.pendingFormData || new FormData(shipmentForm);
  
  // Ensure all breakdown fields are included
  fd.set('total_cost', document.getElementById('totalCost').value || '0');
  fd.set('distance_km', document.getElementById('distance_km').value || '0');
  fd.set('fuel_liters', document.getElementById('fuel_liters').value || '0');
  fd.set('fuel_cost', document.getElementById('fuel_cost').value || '0');
  fd.set('maintenance_cost', document.getElementById('maintenance_cost').value || '0');

  const parcelTypeVal = document.getElementById('parcelType').value || 'pouch';
  if (parcelTypeVal === 'pouch') {
    fd.set('item_type', 'Pouch');
    fd.set('parcel_type', 'Pouch');
    if (!fd.get('parcel_weight') || fd.get('parcel_weight') === '') fd.set('parcel_weight', '1');
    const pouchPrice = state.pouchCost || 0;
    fd.set('box_total_cost', pouchPrice.toFixed(2));
    fd.set('box_size_cost', (0).toFixed(2));
    fd.set('box_weight_cost', (0).toFixed(2));
  } else {
    fd.set('item_type', 'Custom Box');
    fd.set('parcel_type', 'Custom Box');
    fd.set('box_total_cost', document.getElementById('box_total_cost').value || '0');
    fd.set('box_size_cost', document.getElementById('box_size_cost').value || '0');
    fd.set('box_weight_cost', document.getElementById('box_weight_cost').value || '0');
  }

  fd.set('payment_option', paymentOptionInput.value || 'pay_pickup');
  fd.set('payment_method', paymentMethodInput.value || (paymentOptionInput.value === 'pay_pickup' ? 'cash_on_pickup' : ''));

  console.log('Submitting form data:', Object.fromEntries(fd.entries()));

  fetch(shipmentForm.action, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'Accept': 'application/json'
    },
    body: fd
  })
  .then(async (res) => {
    if (!res.ok) {
      const txt = await res.text().catch(()=>null);
      try {
        const json = await res.json();
        if (json && json.errors) {
          Object.keys(json.errors).forEach(k => {
            const errEl = document.getElementById(k + '_err');
            if (errEl) {
              errEl.textContent = json.errors[k].join(', ');
              errEl.style.display = 'block';
              const input = document.getElementsByName(k)[0] || document.getElementById(k);
              if (input) input.classList.add('is-invalid-field');
            }
          });
        } else {
          alert('Error submitting: ' + (txt || res.statusText));
        }
      } catch (e) {
        alert('Error submitting: ' + (txt || res.statusText));
      }
      return;
    }
    successModal.show();
    setTimeout(() => {
      window.location.href = "{{ url('/dashboard') }}";
    }, 2000);
  })
  .catch((err) => {
    console.error(err);
    alert('Something went wrong. Please try again.');
  });
}

redirectBtn.addEventListener('click', () => {
  window.location.href = "{{ url('/dashboard') }}";
});

// Initial UI behaviors
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('summaryContent').style.display = 'block';
  toggleIcon.className = 'bx bx-chevron-up';

  btnPayPickup.classList.add('active');
  paymentOptionInput.value = 'pay_pickup';
  paymentMethodsWrap.style.display = 'none';

  pouchOptionsEl.style.display = 'none';
  customBreakdownEl.style.display = 'none';
  document.getElementById('customOptions').style.display = 'none';

  // Defensive: pointer events for dropdowns
  document.querySelectorAll('.dropdown-list').forEach(el => { el.style.pointerEvents = 'auto'; el.style.zIndex = '99999'; });

  updateTotalsUI();
});
</script>
</body>
</html>
