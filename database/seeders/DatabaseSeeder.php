<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Category;
use App\Models\Role;
use App\Models\TypeDocument;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //User::factory(1000)->create();
        // \App\Models\User::factory(10)->create();

        //crear roles
        $roles = [
            ['name' => 'ADMIN'],
            ['name' => 'RRHH'],
            ['name' => 'VENTAS'],
        ];

        Role::query()->insert($roles);

        //crear usuario admin
        User::query()->create([
            'rol_id' => 1,
            'username' => 'admin',
            'password' => bcrypt(123456),
            'email' => 'admin@gmail.com',
         ]);

        //crear categorias
        $categories = [
            [
                "name" => "DESAYUNO",
                "color" => "#3498db",
                "code" => "DES"
            ],
            [
                "name" => "ALMUERZO",
                "color"=> "#2ecc71",
                 "code" => "ALM"
            ],
            [
                "name" => "CENA",
                "color" => "#e74c3c",
                "code" => "CEN"
            ],
            [
                "name" => "EXTRAS",
                "color"=> "#f1c40f",
                "code" => "EXT"
            ],
            [
                "name" => "SNACKS",
                "color" => "#9b59b6",
                "code" => "SNK"
            ],
            [
                "name" => "BEBIDAS",
                "color" => "#e67e22",
                "code" => "BEB"
            ],
            [
                "name" => "GASEOSAS",
                "color" => "#1abc9c",
                "code" => "GAS"
            ],
            [
                "name" => "TORTAS",
                "color" => "#34495e",
                "code" => "TOR"
            ]
        ];
        Category::query()->insert($categories);

        //crear tipos de document
        $typesDocuments = [
            ['name' => 'DNI'],
            ['name' => 'CARNET DE EXTRANJERIA'],
            ['name' => 'PASAPORTE'],
            ['name' => 'RUC'],
        ];
        TypeDocument::query()->insert($typesDocuments);

        //crear areas
        $areas = [
            ["name" => "ALMACEN"],
            ["name" => "PRODUCCION"],
            ["name" => "LIMPIEZA"],
        ];

        Area::query()->insert($areas);

        //trabajadores
        $workes = [
            ["dni" => "48844052", "nombres" => "ACHO LASERNA SAUL", "area" => "PRODUCCION"],
            ["dni" => "60376006", "nombres" => "ACUY GUTIERREZ JEFRI MANASES", "area" => "PRODUCCION"],
            ["dni" => "76407900", "nombres" => "ALVAREZ PALACIOS CHIRTS YERICOI", "area" => "PRODUCCION"],
            ["dni" => "46534913", "nombres" => "ANCON LOPEZ WILMER GILBERTO", "area" => "PRODUCCION"],
            ["dni" => "60114635", "nombres" => "ANDRADE FABABA KELVIN", "area" => "PRODUCCION"],
            ["dni" => "60110566", "nombres" => "ARBILDO MONTOYA DELCIO ABEL", "area" => "PRODUCCION"],
            ["dni" => "75213595", "nombres" => "ATACHI VASQUEZ NELVIN", "area" => "PRODUCCION"],
            ["dni" => "46292735", "nombres" => "BELEN ZAVALETA CLIMACO DARIO", "area" => "PRODUCCION"],
            ["dni" => "42152585", "nombres" => "BERMEJO CORDOVA CRISTHIAM DIONICIO", "area" => "PRODUCCION"],
            ["dni" => "42733928", "nombres" => "BONILLA PAUCAR MARCELINA LEONOR", "area" => "PRODUCCION"],
            ["dni" => "17637616", "nombres" => "BUSTAMANTE SAMAME ALEJANDRO", "area" => "PRODUCCION"],
            ["dni" => "32029704", "nombres" => "BRITO CORDERO RAYMUNDO YOEL", "area" => "PRODUCCION"],
            ["dni" => "44123410", "nombres" => "CAHUAZA CUESPAN MOISES", "area" => "PRODUCCION"],
            ["dni" => "76360171", "nombres" => "CAMASCA LEON RUSBELL MARCIAL", "area" => "PRODUCCION"],
            ["dni" => "47293277", "nombres" => "CAPCHA MODRAGON CESAR EDUARDO", "area" => "PRODUCCION"],
            ["dni" => "45144142", "nombres" => "CARMIN CONDOR MOISES", "area" => "PRODUCCION"],
            ["dni" => "74925876", "nombres" => "CASAFRANCA GUTIERREZ YULI", "area" => "PRODUCCION"],
            ["dni" => "70089630", "nombres" => "CASTILLO CHAVEZ JORGE ENRIQUE", "area" => "PRODUCCION"],
            ["dni" => "70161836", "nombres" => "CASTILLO LUNA LEONEL RICHARD", "area" => "PRODUCCION"],
            ["dni" => "48548897", "nombres" => "CASTRO VALLES BRUCE", "area" => "PRODUCCION"],
            ["dni" => "77417961", "nombres" => "CASTRO VILLAFUERTE JESUS ALBERTO", "area" => "PRODUCCION"],
            ["dni" => "47308387", "nombres" => "CERCADO CRUZADO WILDER FERNANDO", "area" => "PRODUCCION"],
            ["dni" => "48588209", "nombres" => "CORDOVA ROJAS MACEDONIO", "area" => "PRODUCCION"],
            ["dni" => "47867053", "nombres" => "CORONADO ESPINO VANESSA", "area" => "PRODUCCION"],
            ["dni" => "76496204", "nombres" => "CUMARI UTIA JOSIAS LUIS", "area" => "PRODUCCION"],
            ["dni" => "43162534", "nombres" => "CHOQUE MARCAS WILLIAM JAVIER", "area" => ""],
            ["dni" => "77015415", "nombres" => "CHUNA AYALA JULIO CESAR", "area" => "PRODUCCION"],
            ["dni" => "45372767", "nombres" => "CHUQUIVIGUEL HUAMAN LUIS EDILBERTO", "area" => "PRODUCCION"],
            ["dni" => "80232243", "nombres" => "CRUZ SILVANO LIMBER", "area" => "PRODUCCION"],
            ["dni" => "45132091", "nombres" => "DE LAMA MENA DENISSE LISET", "area" => "PRODUCCION"],
            ["dni" => "48201701", "nombres" => "DIAZ CHUJUTALLI LANDER HULISES", "area" => "PRODUCCION"],
            ["dni" => "71068915", "nombres" => "DUENDE JIPA NEXDEA", "area" => "PRODUCCION"],
            ["dni" => "42572245", "nombres" => "ELIAS DIAZ JOSE ALEXANDER", "area" => "PRODUCCION"],
            ["dni" => "000001944", "nombres" => "ESCALONA LINARES LUIS ALBERTO", "area" => "PRODUCCION"],
            ["dni" => "81633167", "nombres" => "FALCON LASERNA MIRLA ESTER", "area" => "PRODUCCION"],
            ["dni" => "43076272", "nombres" => "FASABI CASTILLO EDINSON", "area" => "PRODUCCION"],
            ["dni" => "75960445", "nombres" => "FERNANDEZ AMPUERO ALEX YONER", "area" => "PRODUCCION"],
            ["dni" => "43872989", "nombres" => "FERRO CARPIO ESPERANZA", "area" => "PRODUCCION"],
            ["dni" => "41328090", "nombres" => "FLORES CONDORI ELMER", "area" => "PRODUCCION"],
            ["dni" => "80592562", "nombres" => "FLORES GARCIA CARLOS", "area" => "PRODUCCION"],
            ["dni" => "46260714", "nombres" => "FLORES GARCIA DAVID", "area" => "PRODUCCION"],
            ["dni" => "09927457", "nombres" => "FLORES MORALES CARLOS ALBERTO", "area" => "PRODUCCION"],
            ["dni" => "43089238", "nombres" => "FLORES ROJAS LUIS", "area" => "PRODUCCION"],
            ["dni" => "46680293", "nombres" => "GARCIA LOPEZ LLEYKER ROY", "area" => "PRODUCCION"],
            ["dni" => "75223294", "nombres" => "GONZALES FLORES CLEVER", "area" => "PRODUCCION"],
            ["dni" => "47731817", "nombres" => "GONZALES ISUIZA RICARDO", "area" => "PRODUCCION"],
            ["dni" => "63336396", "nombres" => "GONZALES FERNANDEZ JIMMY STALYN", "area" => "PRODUCCION"],
            ["dni" => "48147253", "nombres" => "GONZALES MARIN RONAL", "area" => "PRODUCCION"],
            ["dni" => "76133662", "nombres" => "GUEVARA PECHE AUSTIN ALEJANDRO", "area" => "PRODUCCION"],
            ["dni" => "43118319", "nombres" => "GUTIERREZ VARGAS RITMER", "area" => "PRODUCCION"],
            ["dni" => "76417289", "nombres" => "GUZMAN MEZA JOEL ISMAEL", "area" => "PRODUCCION"],
            ["dni" => "73449787", "nombres" => "HUACHO OLAVE BELL KATRINA", "area" => "PRODUCCION"],
            ["dni" => "71442393", "nombres" => "HUALINGA RUIZ MOISES JOSEPH", "area" => "PRODUCCION"],
            ["dni" => "48841850", "nombres" => "HUAMAN LANDEO JULIAN YERSON", "area" => "PRODUCCION"],
            ["dni" => "73933563", "nombres" => "HUAMANI MEDRANO LUIS ENRIQUE", "area" => "PRODUCCION"],
            ["dni" => "76994897", "nombres" => "HUARANGA NARCISO JERSON", "area" => "PRODUCCION"],
            ["dni" => "44316429", "nombres" => "ISUIZA REATEGUI JAMES", "area" => "PRODUCCION"],
            ["dni" => "60409309", "nombres" => "JARA AMAO RONALD EDGARD ALEXANDER", "area" => "PRODUCCION"],
            ["dni" => "42641708", "nombres" => "JIMENEZ CAHUACHI CARLOS", "area" => "PRODUCCION"],
            ["dni" => "48762161", "nombres" => "JIMPI CHUNKUNT TSANIM", "area" => "PRODUCCION"],
            ["dni" => "61243012", "nombres" => "LEMOS VALLES XAVI WALTER", "area" => "PRODUCCION"],
            ["dni" => "77277919", "nombres" => "LOPEZ TECO LINDER", "area" => "PRODUCCION"],
            ["dni" => "75111633", "nombres" => "MACEDO OLORTEGUI ARDRI FRANCHE", "area" => "PRODUCCION"],
            ["dni" => "74748334", "nombres" => "MAGAN ZAPATA JOSUE ANTONIO", "area" => "PRODUCCION"],
            ["dni" => "43179994", "nombres" => "MANDRUNI VELA MAVILO", "area" => "PRODUCCION"],
            ["dni" => "47859534", "nombres" => "MAYNAS AMPUERO TIMOTEO", "area" => "PRODUCCION"],
            ["dni" => "76207621", "nombres" => "MAYTA ROMAYNA RICHARD", "area" => "PRODUCCION"],
            ["dni" => "62179548", "nombres" => "MEJIA REYES LEONEL ALEXANDER", "area" => "PRODUCCION"],
            ["dni" => "71079114", "nombres" => "MELO VIZCARRA JUNIOR ALEJANDRO", "area" => "PRODUCCION"],
            ["dni" => "73159607", "nombres" => "MILLAN RODRIGUEZ WILFREDO JESUS", "area" => "PRODUCCION"],
            ["dni" => "47919536", "nombres" => "MORE ROSAS EDSON ERNESTO", "area" => "PRODUCCION"],
            ["dni" => "62075306", "nombres" => "MURAYARI GONZALES CALEB", "area" => "PRODUCCION"],
            ["dni" => "00000000", "nombres" => "NARCIZO CESPEDES MAVEL", "area" => "PRODUCCION"],
            ["dni" => "62673316", "nombres" => "NOLE MADRID DOUGLAS LEONEL", "area" => "PRODUCCION"],
            ["dni" => "60737783", "nombres" => "ODICIO MURAYARI TITO ALEX", "area" => ""],
            ["dni" => "41072576", "nombres" => "OSORES ALCOCER EDWIN JEAN", "area" => "PRODUCCION"],
            ["dni" => "41951880", "nombres" => "OSORES ISLA JAVIER ABNER", "area" => "PRODUCCION"],
            ["dni" => "09957167", "nombres" => "PAJUELO RONDAN MARIO CESAR", "area" => "PRODUCCION"],
            ["dni" => "42743508", "nombres" => "PALOMINO ALBINO JIMMY", "area" => "PRODUCCION"],
            ["dni" => "46133016", "nombres" => "PALOMINO LOAYZA LUIS ALFREDO", "area" => "PRODUCCION"],
            ["dni" => "80902414", "nombres" => "PANDURO GARCIA FREDDY JAIR", "area" => "PRODUCCION"],
            ["dni" => "76698756", "nombres" => "PANDURO RODRIGUEZ GESSLER ARTEMIO", "area" => "PRODUCCION"],
            ["dni" => "45420574", "nombres" => "PANDURO TANGOA JULIO CESAR", "area" => "PRODUCCION"],
            ["dni" => "43126473", "nombres" => "PAREDES PACAYA REISER", "area" => "PRODUCCION"],
            ["dni" => "46098747", "nombres" => "PEREZ FARFAN OSCAR CRISTHIAN", "area" => "PRODUCCION"],
            ["dni" => "47852034", "nombres" => "PICOTA ANCON SILA", "area" => "PRODUCCION"],
            ["dni" => "40173262", "nombres" => "POMA GARCIA JENNY", "area" => "PRODUCCION"],
            ["dni" => "75823650", "nombres" => "PONCE LOPEZ KEINS", "area" => "PRODUCCION"],
            ["dni" => "61503695", "nombres" => "PORRO DURAND WILLIAN ISIDRO", "area" => "PRODUCCION"],
            ["dni" => "41218556", "nombres" => "QUISPE CHUÑOCCA REYNA", "area" => "PRODUCCION"],
            ["dni" => "74397034", "nombres" => "QUISPE HUACAL DREYSI ANABELY", "area" => "PRODUCCION"],
            ["dni" => "44309481", "nombres" => "RAMIREZ HUAYAMA ALZAMENY", "area" => "PRODUCCION"],
            ["dni" => "76539574", "nombres" => "RAMOS SAVILVINO LEONCIO", "area" => "PRODUCCION"],
            ["dni" => "47992511", "nombres" => "RICARDO MUÑICO ALAN NIKE", "area" => "PRODUCCION"],
            ["dni" => "44807502", "nombres" => "RICRA YACHACHIN YANNET ELSA", "area" => "PRODUCCION"],
            ["dni" => "43579238", "nombres" => "RODRIGUEZ ANCON SAUL", "area" => "PRODUCCION"],
            ["dni" => "76679216", "nombres" => "ROMAINA BARBARAN SANTIAGO", "area" => "PRODUCCION"],
            ["dni" => "77798955", "nombres" => "RUIZ SHUPINGAHUA ARON ALDAIR", "area" => "PRODUCCION"],
            ["dni" => "47495571", "nombres" => "SALAS AMASIFUEN GUINGLER RONIN", "area" => "PRODUCCION"],
            ["dni" => "45119163", "nombres" => "SALDAÑA YASPANA JULIO CESAR", "area" => "PRODUCCION"],
            ["dni" => "46387716", "nombres" => "SALVADOR CALLE GREMILDA", "area" => "PRODUCCION"],
            ["dni" => "77074656", "nombres" => "SAMPAYO MORI EULER LEODAN", "area" => "PRODUCCION"],
            ["dni" => "80573249", "nombres" => "SAMPAYO VASQUEZ GERMAN", "area" => "PRODUCCION"],
            ["dni" => "46488511", "nombres" => "SANCHEZ TAPIA ROSALINA", "area" => "PRODUCCION"],
            ["dni" => "47902100", "nombres" => "SANCHEZ TINEO ALEX WILLIAM", "area" => "PRODUCCION"],
            ["dni" => "60185651", "nombres" => "SANDA PANDURO ORLANDO", "area" => "PRODUCCION"],
            ["dni" => "46225848", "nombres" => "SANGAMA SANGAMA AUBER", "area" => "PRODUCCION"],
            ["dni" => "44881353", "nombres" => "SANTIAGO PERALES WILLIAMS EDWIN", "area" => "PRODUCCION"],
            ["dni" => "75624835", "nombres" => "SAUÑE QUICAÑA MARIA ESTHER", "area" => "PRODUCCION"],
            ["dni" => "08160380", "nombres" => "SILVA PACHECO ALBERTO MERCEDES", "area" => "PRODUCCION"],
            ["dni" => "08147929", "nombres" => "SILVA PACHECO ROMMEL EDGARDO", "area" => "PRODUCCION"],
            ["dni" => "43445246", "nombres" => "SUYON CAVERO CARLOS ALEJANDRO", "area" => "PRODUCCION"],
            ["dni" => "72116487", "nombres" => "TERRONES PAJARES JOSE GAUDENCIO", "area" => "PRODUCCION"],
            ["dni" => "46504848", "nombres" => "TORRES PALACIOS JULIO CESAR", "area" => "PRODUCCION"],
            ["dni" => "72872176", "nombres" => "TORRES RODAS OSCAR ANTONIO", "area" => "PRODUCCION"],
            ["dni" => "75602487", "nombres" => "TUMBAY ROMERO JHORDY", "area" => "PRODUCCION"],
            ["dni" => "46301119", "nombres" => "TUNQUI TAPARA OSCAR VIDAL", "area" => "PRODUCCION"],
            ["dni" => "42341023", "nombres" => "VIGAY HUAYNACARY WENINGER", "area" => "PRODUCCION"],
            ["dni" => "70398607", "nombres" => "VILLAVICENCIO PANTOJA RAFAEL FRANCO", "area" => "PRODUCCION"],
            ["dni" => "48145650", "nombres" => "YANAMARI IMUNDA GABRIEL", "area" => "PRODUCCION"],
            ["dni" => "48125113", "nombres" => "YUIMACHI YUMBATO JOEL", "area" => "PRODUCCION"],
            ["dni" => "43982757", "nombres" => "YUPANQUI LLACTAHUAMAN RAFAEL", "area" => "PRODUCCION"],
            ["dni" => "44529970", "nombres" => "ZAMORA CHAVEZ ALFREDO", "area" => "PRODUCCION"],
            ["dni" => "74255610", "nombres" => "ZARATE CONDORI JESSICA", "area" => "PRODUCCION"],
            ["dni" => "47918566", "nombres" => "AGUIRRE AHUANARI LUIS FERNANDO", "area" => "ALMACEN"],
            ["dni" => "47386519", "nombres" => "ALFARO ACUÑA PILAR", "area" => "ALMACEN"],
            ["dni" => "75653442", "nombres" => "ALMERCO MAMANI LUIS MIGUEL", "area" => "ALMACEN"],
            ["dni" => "73937691", "nombres" => "ALONZO ASTO LUIS MIGUEL", "area" => "ALMACEN"],
            ["dni" => "61014735", "nombres" => "ALVARADO TELLO LEANDRO LEONARDO", "area" => "ALMACEN"],
            ["dni" => "78690501", "nombres" => "ANCO BERROCAL EDWIN MIGUEL", "area" => "ALMACEN"],
            ["dni" => "48030885", "nombres" => "APAZA CASTELLANOS JOSELIN JENNI", "area" => "ALMACEN"],
            ["dni" => "47635934", "nombres" => "ASCONA CCOPE JUAN CARLOS", "area" => "ALMACEN"],
            ["dni" => "75087866", "nombres" => "ASCENCIO SOTO ANGELO MIRCKO", "area" => "ALMACEN"],
            ["dni" => "77163128", "nombres" => "ASTO HUARCAYA LUCERO CANDY", "area" => "ALMACEN"],
            ["dni" => "71806446", "nombres" => "AYALA SOLANO JHOSELYN YHORLIN", "area" => "ALMACEN"],
            ["dni" => "74568375", "nombres" => "BARDALES HOYOS EFER", "area" => "PRODUCCION"],
            ["dni" => "78288290", "nombres" => "CALDERON CONDORI JUAN CARLOS", "area" => "PRODUCCION"],
            ["dni" => "75072916", "nombres" => "CARAHUANCO LAIME YERUSA JOSELYN", "area" => "PRODUCCION"],
            ["dni" => "46806466", "nombres" => "CARDENAS POMA ANGELA STEPHANY", "area" => "ALMACEN"],
            ["dni" => "41643366", "nombres" => "CHARCA LUCIANO RENE", "area" => "ALMACEN"],
            ["dni" => "47525112", "nombres" => "CHAVEZ ROJAS ZULEMA EBELIN", "area" => "ALMACEN"],
            ["dni" => "80591998", "nombres" => "CHOQUE MACHUCA MARCELINA", "area" => "ALMACEN"],
            ["dni" => "47423109", "nombres" => "CLEMENTE ROMERO ABEL", "area" => "ALMACEN"],
            ["dni" => "44983231", "nombres" => "CONDORI CASTRO VANESSA", "area" => "ALMACEN"],
            ["dni" => "44754113", "nombres" => "CORNELIO ARELLANO KARINA", "area" => "ALMACEN"],
            ["dni" => "73752358", "nombres" => "DEL AGUILA ALVARADO YAHELET SAVIOLA", "area" => "ALMACEN"],
            ["dni" => "25562800", "nombres" => "DIAZ AGUILAR LUIS ALBERTO", "area" => "ALMACEN"],
            ["dni" => "47745000", "nombres" => "FLORES FERNANDEZ JUAN JHAROL", "area" => "ALMACEN"],
            ["dni" => "44699663", "nombres" => "FLORES MEDINA JHONATAN ALFONSO", "area" => "ALMACEN"],
            ["dni" => "77189749", "nombres" => "GARCIA LARA NINO CALEB", "area" => "ALMACEN"],
            ["dni" => "63336397", "nombres" => "GONZALES FERNANDEZ JACK ENRIQUE", "area" => "ALMACEN"],
            ["dni" => "72235024", "nombres" => "IHUARAQUI RIOS NERIO JOSUE", "area" => "ALMACEN"],
            ["dni" => "71625766", "nombres" => "INGA CHAPOÑAN SEBASTIAN", "area" => "ALMACEN"],
            ["dni" => "74944496", "nombres" => "JAUNI ALVARADO LEONCIO ENRIQUE", "area" => "ALMACEN"],
            ["dni" => "48867900", "nombres" => "JUSTO CHUNOJA ROSA ANGELICA", "area" => "ALMACEN"],
            ["dni" => "5411499", "nombres" => "LOPEZ NARO PEDRO JOSE", "area" => "ALMACEN"],
            ["dni" => "46006211", "nombres" => "MARTINEZ SILVERIO JONATHAN HUBERT", "area" => "ALMACEN"],
            ["dni" => "45621999", "nombres" => "MEDINA BAUTISTA JOSE LUIS", "area" => "ALMACEN"],
            ["dni" => "75704025", "nombres" => "MEDINA NIZAMA RICHARD ALEXIS", "area" => "ALMACEN"],
            ["dni" => "76758233", "nombres" => "MENDOZA REYES DIEGO ARMANDO", "area" => "ALMACEN"],
            ["dni" => "43483477", "nombres" => "MILLA VALENCIA LEONIDAS RICARDINA", "area" => "ALMACEN"],
            ["dni" => "60004859", "nombres" => "MIGUEL VILLALVA JEENSI JOHAN", "area" => "ALMACEN"],
            ["dni" => "42118785", "nombres" => "MORALES VASQUEZ ROXANA ESTHER", "area" => "ALMACEN"],
            ["dni" => "72208475", "nombres" => "NATIVIDAD ROCA JOSFE CAYO", "area" => "ALMACEN"],
            ["dni" => "76064253", "nombres" => "NUÑEZ GARAY LUIS JAVIER", "area" => "ALMACEN"],
            ["dni" => "76096420", "nombres" => "OCHAVANO FLORES JUNIOR ALEXANDER", "area" => "ALMACEN"],
            ["dni" => "42109629", "nombres" => "PACHERRE CHAVEZ DUBER", "area" => "ALMACEN"],
            ["dni" => "72497569", "nombres" => "PARIONA ARANDA ALEXANDRA EVA", "area" => "ALMACEN"],
            ["dni" => "76206164", "nombres" => "PERALTA CONTRERAS JENYFER SOFIA", "area" => "ALMACEN"],
            ["dni" => "77015172", "nombres" => "PRIETO VALVERDE REBECA ANAYS", "area" => "ALMACEN"],
            ["dni" => "71082554", "nombres" => "QUISPE GARCIA MACK QUEEN", "area" => "ALMACEN"],
            ["dni" => "45320119", "nombres" => "QUISPE QUISPE GIANCARLOS SIMON", "area" => "ALMACEN"],
            ["dni" => "60226554", "nombres" => "RAMIREZ MAYHUA YOSELY JOBITA", "area" => "ALMACEN"],
            ["dni" => "75344434", "nombres" => "RAMIREZ PINEDO FLAVIO JAIR", "area" => "ALMACEN"],
            ["dni" => "71978762", "nombres" => "RAMOS CAMPOS LUZ REYNA", "area" => "ALMACEN"],
            ["dni" => "1023191", "nombres" => "RODRIGUEZ MUÑOZ PIERO ALEXANDER", "area" => "ALMACEN"],
            ["dni" => "48472363", "nombres" => "RODRIGUEZ PUJALLA FRANK JOHEL", "area" => "ALMACEN"],
            ["dni" => "71261042", "nombres" => "ROJAS RUBIO PIERO ALESSANDRO", "area" => "ALMACEN"],
            ["dni" => "72276058", "nombres" => "ROMANI VARGAS CIRILA", "area" => "ALMACEN"],
            ["dni" => "74818842", "nombres" => "SAAVEDRA MEZONES ROSMERY ESTHER", "area" => "ALMACEN"],
            ["dni" => "47622032", "nombres" => "SALDAÑA SABOYA JUAN LUIS", "area" => "ALMACEN"],
            ["dni" => "74923217", "nombres" => "SANCHEZ BAEZ JAIRO ROBERTO", "area" => "ALMACEN"],
            ["dni" => "40039403", "nombres" => "SANTISTEBAN DIAZ ELVIRA DEL MILAGRO", "area" => "ALMACEN"],
            ["dni" => "70993427", "nombres" => "SANTOS JIMENEZ ALDAIR FELIX", "area" => "ALMACEN"],
            ["dni" => "20070014", "nombres" => "SEGOVIA SOVERO LUIS ANTONIO", "area" => "ALMACEN"],
            ["dni" => "76320145", "nombres" => "SHAPIAMA MANIHUARI JEAN PIER'S ANDRES", "area" => "ALMACEN"],
            ["dni" => "70541486", "nombres" => "SHAPIAMA ZUMBA MAYKO DOUGLAS", "area" => "ALMACEN"],
            ["dni" => "60182850", "nombres" => "SOCA SAUÑE JOSEPH ZACH", "area" => "ALMACEN"],
            ["dni" => "70056923", "nombres" => "TAIPE BONIFACIO MILNER JAIRO", "area" => "ALMACEN"],
            ["dni" => "73673637", "nombres" => "TICLLACURI GONZALES ESTEFANI BRIGGITE", "area" => "ALMACEN"],
            ["dni" => "76071974", "nombres" => "TUNQUE CAHUANA JOSEPH WILLIAM", "area" => "ALMACEN"],
            ["dni" => "63422866", "nombres" => "TRIGOZO CANELAO YESSENIA", "area" => "ALMACEN"],
            ["dni" => "46894980", "nombres" => "VALENCIA CHILE SUSAN SOFIA", "area" => "ALMACEN"],
            ["dni" => "40823765", "nombres" => "VASQUEZ PALOMINO OSCAR", "area" => "ALMACEN"],
            ["dni" => "74244850", "nombres" => "VILLEGAS JIMENEZ JANET", "area" => "ALMACEN"],
            ["dni" => "23558568", "nombres" => "YURA BRAVO BELISARIO", "area" => "ALMACEN"],
            ["dni" => "73883523", "nombres" => "ZUÑIGA PARDO JOMIRA", "area" => "ALMACEN"],
            ["dni" => "5393572", "nombres" => "CUMARI RAYO CASIMIRO LUIS", "area" => "LIMPIEZA"],
            ["dni" => "10601970", "nombres" => "MAYORGA ANCHO ROSELIM JESSENIA", "area" => "LIMPIEZA"],
            ["dni" => "44959049", "nombres" => "MORALES GARCIA ROBERTO AUGUSTO", "area" => "LIMPIEZA"],
            ["dni" => "43909199", "nombres" => "SUAREZ UNTIVEROS ESTHER MARIA", "area" => "LIMPIEZA"]
        ];

        foreach ($workes as $w) {
            Worker::query()->create([
                'type_document_id' => 1,//DNI
                'numdoc' => $w['dni'],
                'names' => $w['nombres'],
                'area_id' => Area::query()->where('name', $w['area'])->first()->id ?? null,
                'admission_date' => now()->format('Y-m-d'),
                'allowed_meals' => ['2'],
                'grant_complete' => 1,
            ]);
        }

    }


}
