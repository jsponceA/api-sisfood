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
    ["dni" => "47918566", "nombres" => "AGUIRRE AHUANARI LUIS FERNANDO"],
    ["dni" => "76304359", "nombres" => "ALIAGA IPARRAGUIRRE JHON MARLON"],
    ["dni" => "47386519", "nombres" => "ALFARO ACUÑA PILAR"],
    ["dni" => "75653442", "nombres" => "ALMERCO MAMANI LUIS MIGUEL"],
    ["dni" => "73937691", "nombres" => "ALONZO ASTO LUIS MIGUEL"],
    ["dni" => "78690501", "nombres" => "ANCO BERROCAL EDWIN MIGUEL"],
    ["dni" => "48030885", "nombres" => "APAZA CASTELLANOS JOSELIN JENNI"],
    ["dni" => "47635934", "nombres" => "ASCONA CCOPE JUAN CARLOS"],
    ["dni" => "75087866", "nombres" => "ASCENCIO SOTO ANGELO MIRCKO"],
    ["dni" => "77163128", "nombres" => "ASTO HUARCAYA LUCERO CANDY"],
    ["dni" => "71806446", "nombres" => "AYALA SOLANO JHOSELYN YHORLIN"],
    ["dni" => "74568375", "nombres" => "BARDALES HOYOS EFER"],
    ["dni" => "72583853", "nombres" => "BARRANTES GARCIA CARLOS STEVE"],
    ["dni" => "78288290", "nombres" => "CALDERON CONDORI JUAN CARLOS"],
    ["dni" => "75072916", "nombres" => "CARAHUANCO LAIME YERUSA JOSELYN"],
    ["dni" => "46806466", "nombres" => "CARDENAS POMA ANGELA STEPHANY"],
    ["dni" => "41643366", "nombres" => "CHARCA LUCIANO RENE"],
    ["dni" => "47525112", "nombres" => "CHAVEZ ROJAS ZULEMA EBELIN"],
    ["dni" => "80591998", "nombres" => "CHOQUE MACHUCA MARCELINA"],
    ["dni" => "47423109", "nombres" => "CLEMENTE ROMERO ABEL"],
    ["dni" => "75075420", "nombres" => "CRISANTO MARQUEZ HUGO SANDRO"],
    ["dni" => "44983231", "nombres" => "CONDORI CASTRO VANESSA"],
    ["dni" => "60301100", "nombres" => "CUSICHE HUAIRA YURY"],
    ["dni" => "74810496", "nombres" => "CUTI SENCIA JOEL FRANKS"],
    ["dni" => "73752358", "nombres" => "DEL AGUILA ALVARADO YAHELET SAVIOLA"],
    ["dni" => "75171208", "nombres" => "DE LA CRUZ HUAMANI ALEXIS JAIR"],
    ["dni" => "25562800", "nombres" => "DIAZ AGUILAR LUIS ALBERTO"],
    ["dni" => "61124334", "nombres" => "DIAZ VIERA WILMER SEGUNDO"],
    ["dni" => "44699663", "nombres" => "FLORES MEDINA JHONATAN ALFONSO"],
    ["dni" => "74702683", "nombres" => "GONZALES CAPRISTANO ANTHONY DANIEL"],
    ["dni" => "63336397", "nombres" => "GONZALES FERNANDEZ JACK ENRIQUE"],
    ["dni" => "72235024", "nombres" => "IHUARAQUI RIOS NERIO JOSUE"],
    ["dni" => "71625766", "nombres" => "INGA CHAPOÑAN SEBASTIAN"],
    ["dni" => "74944496", "nombres" => "JAUNI ALVARADO LEONCIO ENRIQUE"],
    ["dni" => "48867900", "nombres" => "JUSTO CHUNOJA ROSA ANGELICA"],
    ["dni" => "5411499", "nombres" => "LOPEZ NARO PEDRO JOSE"],
    ["dni" => "70261929", "nombres" => "MANIZARI SOZA JHORLIN MAURICIO"],
    ["dni" => "46006211", "nombres" => "MARTINEZ SILVERIO JONATHAN HUBERT"],
    ["dni" => "45621999", "nombres" => "MEDINA BAUTISTA JOSE LUIS"],
    ["dni" => "75704025", "nombres" => "MEDINA NIZAMA RICHARD ALEXIS"],
    ["dni" => "76758233", "nombres" => "MENDOZA REYES DIEGO ARMANDO	"],
    ["dni" => "43483477", "nombres" => "MILLA VALENCIA LEONIDAS RICARDINA"],
    ["dni" => "60004859", "nombres" => "MIGUEL VILLALVA JEENSI JOHAN"],
    ["dni" => "42118785", "nombres" => "MORALES VASQUEZ ROXANA ESTHER"],
    ["dni" => "72208475", "nombres" => "NATIVIDAD ROCA JOSFE CAYO"],
    ["dni" => "76064253", "nombres" => "NUÑEZ GARAY LUIS JAVIER"],
    ["dni" => "76096420", "nombres" => "OCHAVANO FLORES JUNIOR ALEXANDER"],
    ["dni" => "42109629", "nombres" => "PACHERRE CHAVEZ DUBER"],
    ["dni" => "72497569", "nombres" => "PARIONA ARANDA ALEXANDRA EVA"],
    ["dni" => "76206164", "nombres" => "PERALTA CONTRERAS JENYFER SOFIA"],
    ["dni" => "77015172", "nombres" => "PRIETO VALVERDE REBECA ANAYS"],
    ["dni" => "71082554", "nombres" => "QUISPE GARCIA MACK QUEEN"],
    ["dni" => "45320119", "nombres" => "QUISPE QUISPE GIANCARLOS SIMON"],
    ["dni" => "60226554", "nombres" => "RAMIREZ MAYHUA YOSELY JOBITA"],
    ["dni" => "75344434", "nombres" => "RAMIREZ PINEDO FLAVIO JAIR"],
    ["dni" => "71978762", "nombres" => "RAMOS CAMPOS LUZ REYNA"],
    ["dni" => "1023191", "nombres" => "RODRIGUEZ MUÑOZ PIERO ALEXANDER"],
    ["dni" => "48472363", "nombres" => "RODRIGUEZ PUJALLA FRANK JOHEL"],
    ["dni" => "71261042", "nombres" => "ROJAS RUBIO PIERO ALESSANDRO"],
    ["dni" => "74818842", "nombres" => "SAAVEDRA MEZONES ROSMERY ESTHER"],
    ["dni" => "47622032", "nombres" => "SALDAÑA SABOYA JUAN LUIS"],
    ["dni" => "74923217", "nombres" => "SANCHEZ BAEZ JAIRO ROBERTO"],
    ["dni" => "40039403", "nombres" => "SANTISTEBAN DIAZ ELVIRA DEL MILAGRO"],
    ["dni" => "70993427", "nombres" => "SANTOS JIMENEZ ALDAIR FELIX"],
    ["dni" => "20070014", "nombres" => "SEGOVIA SOVERO LUIS ANTONIO"],
    ["dni" => "76320145", "nombres" => "SHAPIAMA MANIHUARI JEAN PIER'S ANDRES"],
    ["dni" => "70541486", "nombres" => "SHAPIAMA ZUMBA MAYKO DOUGLAS"],
    ["dni" => "60182850", "nombres" => "SOCA SAUÑE JOSEPH ZACH"],
    ["dni" => "70056923", "nombres" => "TAIPE BONIFACIO MILNER JAIRO"],
    ["dni" => "73673637", "nombres" => "TICLLACURI GONZALES ESTEFANI BRIGGITE"],
    ["dni" => "76071974", "nombres" => "TUNQUE CAHUANA JOSEPH WILLIAM"],
    ["dni" => "63422866", "nombres" => "TRIGOZO CANELAO YESSENIA"],
    ["dni" => "46894980", "nombres" => "VALENCIA CHILE SUSAN SOFIA"],
    ["dni" => "76656742", "nombres" => "VASQUEZ NEPIRE DANY JHAILETH"],
    ["dni" => "40823765", "nombres" => "VASQUEZ PALOMINO OSCAR"],
    ["dni" => "74244850", "nombres" => "VILLEGAS JIMENEZ JANET"],
    ["dni" => "23558568", "nombres" => "YURA BRAVO BELISARIO"],
    ["dni" => "73883523", "nombres" => "ZUÑIGA PARDO JOMIRA"],
    ["dni" => "5393572", "nombres" => "CUMARI RAYO CASIMIRO LUIS"],
    ["dni" => "10601970", "nombres" => "MAYORGA ANCHO ROSELIM JESSENIA"],
    ["dni" => "44959049", "nombres" => "MORALES GARCIA ROBERTO AUGUSTO"],
    ["dni" => "43909199", "nombres" => "SUAREZ UNTIVEROS ESTHER MARIA"],
    ["dni" => "48844052", "nombres" => "ACHO LASERNA SAUL"],
    ["dni" => "41368139", "nombres" => "ALIAGA HUAYTA DAVID MIGUEL"],
    ["dni" => "76407900", "nombres" => "ALVAREZ PALACIOS CHIRTS YERICOI"],
    ["dni" => "60114635", "nombres" => "ANDRADE FABABA KELVIN"],
    ["dni" => "60110566", "nombres" => "ARBILDO MONTOYA DELCIO ABEL"],
    ["dni" => "75213595", "nombres" => "ATACHI VASQUEZ NELVIN  "],
    ["dni" => "46292735", "nombres" => "BELEN ZAVALETA CLIMACO DARIO"],
    ["dni" => "70573430", "nombres" => "BELLIDO QUISPE JAIME DARIO"],
    ["dni" => "42152585", "nombres" => "BERMEJO CORDOVA CRISTHIAM DIONICIO"],
    ["dni" => "42733928", "nombres" => "BONILLA PAUCAR MARCELINA LEONOR"],
    ["dni" => "17637616", "nombres" => "BUSTAMANTE SAMAME ALEJANDRO"],
    ["dni" => "76360171", "nombres" => "CAMASCA LEON RUSBELL MARCIAL   "],
    ["dni" => "47293277", "nombres" => "CAPCHA MODRAGON CESAR EDUARDO"],
    ["dni" => "45144142", "nombres" => "CARMIN CONDOR MOISES"],
    ["dni" => "74925876", "nombres" => "CASAFRANCA GUTIERREZ YULI"],
    ["dni" => "70089630", "nombres" => "CASTILLO CHAVEZ JORGE ENRIQUE"],
    ["dni" => "70161836", "nombres" => "CASTILLO LUNA LEONEL RICHARD"],
    ["dni" => "48548897", "nombres" => "CASTRO VALLES BRUCE"],
    ["dni" => "77417961", "nombres" => "CASTRO VILLAFUERTE JESUS ALBERTO"],
    ["dni" => "47308387", "nombres" => "CERCADO CRUZADO WILDER FERNANDO"],
    ["dni" => "48588209", "nombres" => "CORDOVA ROJAS MACEDONIO"],
    ["dni" => "76496204", "nombres" => "CUMARI UTIA JOSIAS LUIS"],
    ["dni" => "46684079", "nombres" => "CHAVEZ PRADO LIZET ANTONIA"],
    ["dni" => "43162534", "nombres" => "CHOQUE MARCAS WILLIAM JAVIER"],
    ["dni" => "77015415", "nombres" => "CHUNA AYALA JULIO CESAR"],
    ["dni" => "45372767", "nombres" => "CHUQUIVIGUEL HUAMAN LUIS EDILBERTO"],
    ["dni" => "80232243", "nombres" => "CRUZ SILVANO LIMBER"],
    ["dni" => "45132091", "nombres" => "DE LAMA MENA DENISSE LISET"],
    ["dni" => "47912681", "nombres" => "DOSANTOS VALDERRAMA SADAN"],
    ["dni" => "71068915", "nombres" => "DUENDE JIPA NEXDEA"],
    ["dni" => "000001944", "nombres" => "ESCALONA LINARES LUIS ALBERTO"],
    ["dni" => "81633167", "nombres" => "FALCON LASERNA MIRLA ESTER"],
    ["dni" => "43076272", "nombres" => "FASABI CASTILLO EDINSON"],
    ["dni" => "75960445", "nombres" => "FERNANDEZ AMPUERO ALEX YONER"],
    ["dni" => "43872989", "nombres" => "FERRO CARPIO ESPERANZA"],
    ["dni" => "41328090", "nombres" => "FLORES CONDORI ELMER"],
    ["dni" => "80592562", "nombres" => "FLORES GARCIA CARLOS"],
    ["dni" => "46260714", "nombres" => "FLORES GARCIA DAVID"],
    ["dni" => "09927457", "nombres" => "FLORES MORALES CARLOS ALBERTO"],
    ["dni" => "43089238", "nombres" => "FLORES ROJAS LUIS"],
    ["dni" => "46680293", "nombres" => "GARCIA LOPEZ LLEYKER ROY	"],
    ["dni" => "76148495", "nombres" => "GARCIA OCHOA CESAR BENJAMIN"],
    ["dni" => "75223294", "nombres" => "GONZALES FLORES CLEVER"],
    ["dni" => "47731817", "nombres" => "GONZALES ISUIZA RICARDO"],
    ["dni" => "63336396", "nombres" => "GONZALES FERNANDEZ JIMMY STALYN"],
    ["dni" => "48147253", "nombres" => "GONZALES MARIN RONAL"],
    ["dni" => "76133662", "nombres" => "GUEVARA PECHE AUSTIN ALEJANDRO"],
    ["dni" => "40564004", "nombres" => "GUINEA OVALLE MARCIAL"],
    ["dni" => "43118319", "nombres" => "GUTIERREZ VARGAS RITMER"],
    ["dni" => "76417289", "nombres" => "GUZMAN MEZA JOEL ISMAEL"],
    ["dni" => "73449787", "nombres" => "HUACHO OLAVE BELL KATRINA"],
    ["dni" => "71442393", "nombres" => "HUALINGA RUIZ MOISES JOSEPH"],
    ["dni" => "48841850", "nombres" => "HUAMAN LANDEO JULIAN YERSON"],
    ["dni" => "73933563", "nombres" => "HUAMANI MEDRANO LUIS ENRIQUE"],
    ["dni" => "76994897", "nombres" => "HUARANGA NARCISO JERSON"],
    ["dni" => "61526523", "nombres" => "INOCENTE QUISPE HANS JHOBERT"],
    ["dni" => "44316429", "nombres" => "ISUIZA REATEGUI JAMES"],
    ["dni" => "40282193", "nombres" => "ISHUIZA SINARAHUA ABNER"],
    ["dni" => "60409309", "nombres" => "JARA AMAO RONALD EDGARD ALEXANDER"],
    ["dni" => "42641708", "nombres" => "JIMENEZ CAHUACHI CARLOS"],
    ["dni" => "48762161", "nombres" => "JIMPI CHUNKUNT TSANIM"],
    ["dni" => "61243012", "nombres" => "LEMOS VALLES XAVI WALTER   "],
    ["dni" => "77277919", "nombres" => "LOPEZ TECO LINDER"],
    ["dni" => "75111633", "nombres" => "MACEDO OLORTEGUI ARDRI FRANCHE "],
    ["dni" => "74748334", "nombres" => "MAGAN ZAPATA JOSUE ANTONIO"],
    ["dni" => "43179994", "nombres" => "MANDRUNI VELA MAVILO"],
    ["dni" => "47859534", "nombres" => "MAYNAS AMPUERO TIMOTEO"],
    ["dni" => "62179548", "nombres" => "MEJIA REYES LEONEL ALEXANDER"],
    ["dni" => "71079114", "nombres" => "MELO VIZCARRA JUNIOR ALEJANDRO"],
    ["dni" => "73159607", "nombres" => "MILLAN RODRIGUEZ WILFREDO JESUS"],
    ["dni" => "47919536", "nombres" => "MORE ROSAS EDSON ERNESTO"],
    ["dni" => "PRODUCCION", "nombres" => "NARCIZO CESPEDES MAVEL"],
    ["dni" => "45116076", "nombres" => "NOLORBE MAFALDO DIANA CAROLINA"],
    ["dni" => "60737783", "nombres" => "ODICIO MURAYARI TITO ALEX"],
    ["dni" => "44985630", "nombres" => "ORTIZ MUÑOZ VICTOR EDUARDO"],
    ["dni" => "41072576", "nombres" => "OSORES ALCOCER EDWIN JEAN"],
    ["dni" => "41951880", "nombres" => "OSORES ISLA JAVIER ABNER"],
    ["dni" => "09957167", "nombres" => "PAJUELO RONDAN MARIO CESAR"],
    ["dni" => "42743508", "nombres" => "PALOMINO ALBINO JIMMY"],
    ["dni" => "46133016", "nombres" => "PALOMINO LOAYZA LUIS ALFREDO"],
    ["dni" => "80902414", "nombres" => "PANDURO GARCIA FREDDY JAIR"],
    ["dni" => "76698756", "nombres" => "PANDURO RODRIGUEZ GESSLER ARTEMIO"],
    ["dni" => "45420574", "nombres" => "PANDURO TANGOA JULIO CESAR"],
    ["dni" => "43126473", "nombres" => "PAREDES PACAYA REISER"],
    ["dni" => "46098747", "nombres" => "PEREZ FARFAN OSCAR CRISTHIAN"],
    ["dni" => "47852034", "nombres" => "PICOTA ANCON SILA"],
    ["dni" => "40173262", "nombres" => "POMA GARCIA JENNY"],
    ["dni" => "61503695", "nombres" => "PORRO DURAND WILLIAN ISIDRO"],
    ["dni" => "41218556", "nombres" => "QUISPE CHUÑOCCA REYNA"],
    ["dni" => "74397034", "nombres" => "QUISPE HUACAL DREYSI ANABELY"],
    ["dni" => "44309481", "nombres" => "RAMIREZ HUAYAMA ALZAMENY"],
    ["dni" => "76539574", "nombres" => "RAMOS SAVILVINO LEONCIO"],
    ["dni" => "47992511", "nombres" => "RICARDO MUÑICO ALAN NIKE"],
    ["dni" => "44807502", "nombres" => "RICRA YACHACHIN YANNET ELSA"],
    ["dni" => "43579238", "nombres" => "RODRIGUEZ ANCON SAUL"],
    ["dni" => "49079247", "nombres" => "RODRIGUEZ FERNANDEZ ALEX GABRIEL"],
    ["dni" => "76679216", "nombres" => "ROMAINA BARBARAN SANTIAGO"],
    ["dni" => "77798955", "nombres" => "RUIZ SHUPINGAHUA ARON ALDAIR"],
    ["dni" => "47495571", "nombres" => "SALAS AMASIFUEN GUINGLER RONIN"],
    ["dni" => "45119163", "nombres" => "SALDAÑA YASPANA JULIO CESAR"],
    ["dni" => "46387716", "nombres" => "SALVADOR CALLE GREMILDA"],
    ["dni" => "46488511", "nombres" => "SANCHEZ TAPIA ROSALINA"],
    ["dni" => "47902100", "nombres" => "SANCHEZ TINEO ALEX WILLIAM"],
    ["dni" => "60185651", "nombres" => "SANDA PANDURO ORLANDO"],
    ["dni" => "46225848", "nombres" => "SANGAMA SANGAMA AUBER"],
    ["dni" => "75624835", "nombres" => "SAUÑE QUICAÑA MARIA ESTHER"],
    ["dni" => "08160380", "nombres" => "SILVA PACHECO ALBERTO MERCEDES"],
    ["dni" => "08147929", "nombres" => "SILVA PACHECO ROMMEL EDGARDO"],
    ["dni" => "43445246", "nombres" => "SUYON CAVERO CARLOS ALEJANDRO"],
    ["dni" => "73368743", "nombres" => "TAIPE PACHECO DORIS"],
    ["dni" => "74549231", "nombres" => "TAPULLIMA PASHANASI ELISEO"],
    ["dni" => "46504848", "nombres" => "TORRES PALACIOS JULIO CESAR"],
    ["dni" => "72872176", "nombres" => "TORRES RODAS OSCAR ANTONIO"],
    ["dni" => "75602487", "nombres" => "TUMBAY ROMERO JHORDY"],
    ["dni" => "46301119", "nombres" => "TUNQUI TAPARA OSCAR VIDAL"],
    ["dni" => "62874388", "nombres" => "VASQUEZ CAHUACHI JEFERSON"],
    ["dni" => "44864994", "nombres" => "VILCA TACUCHE HERMELINDA DORCAS"],
    ["dni" => "70398607", "nombres" => "VILLAVICENCIO PANTOJA RAFAEL FRANCO"],
    ["dni" => "48145650", "nombres" => "YANAMARI IMUNDA GABRIEL"],
    ["dni" => "48125113", "nombres" => "YUIMACHI YUMBATO JOEL"],
    ["dni" => "43982757", "nombres" => "YUPANQUI LLACTAHUAMAN RAFAEL"],
    ["dni" => "44529970", "nombres" => "ZAMORA CHAVEZ ALFREDO"],
    ["dni" => "74255610", "nombres" => "ZARATE CONDORI JESSICA"],
];

        foreach ($workes as $w) {
            Worker::query()->create([
                'type_document_id' => 1,//DNI
                'numdoc' => $w['dni'],
                'names' => $w['nombres'],
                'area_id' => Area::query()->where('name', $w['area'])->first()->id ?? null,
                'admission_date' => now()->format('Y-m-d'),
                'allowed_meals' => ['1','2','3'],
                'grant_complete' => 1,
            ]);
        }

    }


}
