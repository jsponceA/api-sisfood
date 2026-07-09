<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsumptionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Internal\BiometricBridgeController;
use App\Http\Controllers\PastSaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
use App\Models\Area;
use App\Models\Worker;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes VERSION 1
|--------------------------------------------------------------------------
*/

Route::get("workers-listado", function () {
    //trabajadores
    $workes = [
        [
            "dni" => "46122389",
            "nombres" => "ANCALLE MONTES EDELIA",
            "fecha_ingreso" => "2025-09-04",
            "area" => "ACABADOS",
            "subvencion_parcial" => 1,
            "subvencion_completa" => 0
        ],
        [
            "dni" => "70718753",
            "nombres" => "DIEGO CHUQUIYAURI KAREN TERESA",
            "fecha_ingreso" => "2025-10-27",
            "area" => "ACABADOS",
            "subvencion_parcial" => 1,
            "subvencion_completa" => 0
        ],
        [
            "dni" => "61949076",
            "nombres" => "GAMBOA VARGAS INES JUANA",
            "fecha_ingreso" => "2025-11-14",
            "area" => "ACABADOS",
            "subvencion_parcial" => 1,
            "subvencion_completa" => 0
        ],
        [
            "dni" => "74810510",
            "nombres" => "LUIS SILVA MAYRA ANGELICA",
            "fecha_ingreso" => "2025-09-11",
            "area" => "ACABADOS",
            "subvencion_parcial" => 1,
            "subvencion_completa" => 0
        ],
        [
            "dni" => "60825914",
            "nombres" => "MONTALVO CARHUACUSMA NICOL MILAGROS",
            "fecha_ingreso" => "2025-08-15",
            "area" => "ACABADOS",
            "subvencion_parcial" => 1,
            "subvencion_completa" => 0
        ],
        [
            "dni" => "70469022",
            "nombres" => "MUÑOZ CARHUALLANQUI YELTSIN KALEF",
            "fecha_ingreso" => "2025-11-03",
            "area" => "ACABADOS",
            "subvencion_parcial" => 1,
            "subvencion_completa" => 0
        ],
        [
            "dni" => "41035064",
            "nombres" => "PALOMARES JACAY MARTIN ENRIQUE",
            "fecha_ingreso" => "2025-08-25",
            "area" => "ACABADOS",
            "subvencion_parcial" => 1,
            "subvencion_completa" => 0
        ],
        [
            "dni" => "44319940",
            "nombres" => "PEREZ BARRANTES MARIA",
            "fecha_ingreso" => "2025-09-16",
            "area" => "ACABADOS",
            "subvencion_parcial" => 1,
            "subvencion_completa" => 0
        ],
        [
            "dni" => "42509643",
            "nombres" => "RODRIGUEZ PECEROS ROXANA BEATRIZ",
            "fecha_ingreso" => "2025-10-22",
            "area" => "ACABADOS",
            "subvencion_parcial" => 1,
            "subvencion_completa" => 0
        ],
        [
            "dni" => "60085154",
            "nombres" => "ROJAS PAUCARCAJA YOSELY JANETH",
            "fecha_ingreso" => "2025-09-29",
            "area" => "ACABADOS",
            "subvencion_parcial" => 1,
            "subvencion_completa" => 0
        ],
        [
            "dni" => "62874745",
            "nombres" => "SALINAS CHAVEZ KEBIN ANIBAL",
            "fecha_ingreso" => "2025-11-03",
            "area" => "ACABADOS",
            "subvencion_parcial" => 1,
            "subvencion_completa" => 0
        ],
        [
            "dni" => "41073794",
            "nombres" => "TRIVEÑO ZEÑA ROSA ELBA",
            "fecha_ingreso" => "2025-09-29",
            "area" => "ACABADOS",
            "subvencion_parcial" => 1,
            "subvencion_completa" => 0
        ],
        [
            "dni" => "63494054",
            "nombres" => "ZUMAETA CAHUAZA CELENE MELISSA",
            "fecha_ingreso" => "2025-11-12",
            "area" => "ACABADOS",
            "subvencion_parcial" => 1,
            "subvencion_completa" => 0
        ],
        [
            "dni" => "70537912",
            "nombres" => "APAZA CASTELLANO JESICA MARIA",
            "fecha_ingreso" => "2024-01-29",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "44270613",
            "nombres" => "BARRIENTOS HUARILLOCLLA CARMEN PATRICIA",
            "fecha_ingreso" => "2024-02-01",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "60929790",
            "nombres" => "CAHUACHI DIAZ MARITZA",
            "fecha_ingreso" => "2024-10-03",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "03364268",
            "nombres" => "ENCALADA CONDOLO ERTEMISA",
            "fecha_ingreso" => "2018-01-01",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "41226383",
            "nombres" => "ESTRADA VEGA ESTHER",
            "fecha_ingreso" => "2024-05-13",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "48177278",
            "nombres" => "GUTIERREZ MAMANI ELIZABETH",
            "fecha_ingreso" => "2021-11-22",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "73449787",
            "nombres" => "HUACHO OLAVE BELL KATRINA",
            "fecha_ingreso" => "2025-01-28",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "70633820",
            "nombres" => "HUARANGA NARCISO YADIRA YESENIA",
            "fecha_ingreso" => "2025-05-09",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "79419075",
            "nombres" => "MENDOZA CARDENAS MIGUEL ANGEL",
            "fecha_ingreso" => "2025-02-06",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "75932636",
            "nombres" => "MEZA ÑAHUINRIPA KELLY",
            "fecha_ingreso" => "2025-05-06",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "47250418",
            "nombres" => "MONTES DE LA CRUZ CRISTIAN RICHARD",
            "fecha_ingreso" => "2024-01-23",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "41847704",
            "nombres" => "OSCANOA CASTRO DE PACHECO EDITH BEATRIZ",
            "fecha_ingreso" => "2025-08-04",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "90463761",
            "nombres" => "PALOMINO CHOÑOJA ANY",
            "fecha_ingreso" => "2024-03-15",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "74397034",
            "nombres" => "QUISPE HUACAL DREYSI ANABELY",
            "fecha_ingreso" => "2025-01-28",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "74608714",
            "nombres" => "RAMIREZ PINEDO CARLOS EDUARDO",
            "fecha_ingreso" => "2025-08-01",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "32408478",
            "nombres" => "RIOS LOPEZ LIDIANA ROSA",
            "fecha_ingreso" => "2020-07-07",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "47880272",
            "nombres" => "VASQUEZ CHUQUIMANGO RITA JANET",
            "fecha_ingreso" => "2023-04-01",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        [
            "dni" => "44992653",
            "nombres" => "YAYICO SANCHEZ ESTEFANIA",
            "fecha_ingreso" => "2025-05-06",
            "area" => "ACABADOS",
            "subvencion_parcial" => 0,
            "subvencion_completa" => 1
        ],
        ["dni" => "47918566", "nombres" => "AGUIRRE AHUANARI LUIS FERNANDO", "fecha_ingreso" => "2023-08-04", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "47386519", "nombres" => "ALFARO ACUÑA PILAR", "fecha_ingreso" => "2024-08-23", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "75653442", "nombres" => "ALMERCO MAMANI LUIS MIGUEL", "fecha_ingreso" => "2024-02-16", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "73937691", "nombres" => "ALONZO ASTO LUIS MIGUEL", "fecha_ingreso" => "2023-05-08", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "78690501", "nombres" => "ANCO BERROCAL EDWIN MIGUEL", "fecha_ingreso" => "2024-05-13", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "48030885", "nombres" => "APAZA CASTELLANOS JOSELIN JENNI", "fecha_ingreso" => "2024-04-25", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "75087866", "nombres" => "ASCENCIO SOTO ANGELO MIRCKO", "fecha_ingreso" => "2025-03-03", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "47635934", "nombres" => "ASCONA CCOPE JUAN CARLOS", "fecha_ingreso" => "2025-07-17", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "77163128", "nombres" => "ASTO HUARCAYA LUCERO CANDY", "fecha_ingreso" => "2024-08-26", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "71806446", "nombres" => "AYALA SOLANO JHOSELYN YHORLIN", "fecha_ingreso" => "2023-05-11", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "74568375", "nombres" => "BARDALES HOYOS EFER", "fecha_ingreso" => "2025-02-15", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "71337013", "nombres" => "BENDEZU VALLE YOSELYN YADIRA", "fecha_ingreso" => "2020-06-17", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "75072916", "nombres" => "CARAHUANCO LAIME YERUSA JOSELYN", "fecha_ingreso" => "2025-05-26", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "46806466", "nombres" => "CARDENAS POMA ANGELA STEPHANY", "fecha_ingreso" => "2021-03-08", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "41643366", "nombres" => "CHARCA LUCIANO RENE", "fecha_ingreso" => "2021-01-07", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "44236536", "nombres" => "CHAVEZ MORANTE ROGELIO", "fecha_ingreso" => "2017-11-17", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "47525112", "nombres" => "CHAVEZ ROJAS ZULEMA EBELIN", "fecha_ingreso" => "2020-09-18", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "80591998", "nombres" => "CHOQUE MACHUCA MARCELINA", "fecha_ingreso" => "2020-05-25", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "44983231", "nombres" => "CONDORI CASTRO VANESSA", "fecha_ingreso" => "2022-02-10", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "73752358", "nombres" => "DEL AGUILA ALVARADO YAHELET SAVIOLA", "fecha_ingreso" => "2025-03-26", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "25562800", "nombres" => "DIAZ AGUILAR LUIS ALBERTO", "fecha_ingreso" => "2020-07-09", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "44699663", "nombres" => "FLORES MEDINA JHONATAN ALFONSO", "fecha_ingreso" => "2020-12-02", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "72235024", "nombres" => "IHUARAQUI RIOS NERIO JOSUE", "fecha_ingreso" => "2025-02-21", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "71625766", "nombres" => "INGA CHAPOÑAN SEBASTIAN", "fecha_ingreso" => "2022-04-04", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "74944496", "nombres" => "JAUNI ALVARADO LEONCIO ENRIQUE", "fecha_ingreso" => "2025-01-20", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "48867900", "nombres" => "JUSTO CHUNOJA ROSA ANGELICA", "fecha_ingreso" => "2022-02-04", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "05411499", "nombres" => "LOPEZ NARO PEDRO JOSE", "fecha_ingreso" => "2025-02-03", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "46006211", "nombres" => "MARTINEZ SILVERIO JONATHAN HUBERT", "fecha_ingreso" => "2025-08-01", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "45621999", "nombres" => "MEDINA BAUTISTA JOSE LUIS", "fecha_ingreso" => "2022-02-10", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "75704025", "nombres" => "MEDINA NIZAMA RICHARD ALEXIS", "fecha_ingreso" => "2024-08-01", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "76758233", "nombres" => "MENDOZA REYES DIEGO ARMANDO", "fecha_ingreso" => "2025-03-05", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "43483477", "nombres" => "MILLA VALENCIA LEONIDAS RICARDINA", "fecha_ingreso" => "2022-01-14", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "42118785", "nombres" => "MORALES VASQUEZ ROXANA ESTHER", "fecha_ingreso" => "2017-10-20", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "72208475", "nombres" => "NATIVIDAD ROCA JOSFE CAYO", "fecha_ingreso" => "2023-05-08", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "76064253", "nombres" => "NUÑEZ GARAY LUIS JAVIER", "fecha_ingreso" => "2024-07-10", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "76096420", "nombres" => "OCHAVANO FLORES JUNIOR ALEXANDER", "fecha_ingreso" => "2024-09-25", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "42109629", "nombres" => "PACHERRE CHAVEZ DUBER", "fecha_ingreso" => "2020-08-17", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "72497569", "nombres" => "PARIONA ARANDA ALEXANDRA EVA", "fecha_ingreso" => "2023-02-17", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "76206164", "nombres" => "PERALTA CONTRERAS JENYFER SOFIA", "fecha_ingreso" => "2022-04-25", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "77015172", "nombres" => "PRIETO VALVERDE REBECA ANAYS", "fecha_ingreso" => "2025-02-24", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "71082554", "nombres" => "QUISPE GARCIA MACK QUEEN", "fecha_ingreso" => "2025-04-02", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "45320119", "nombres" => "QUISPE QUISPE GIANCARLOS SIMON", "fecha_ingreso" => "2020-08-04", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "60226554", "nombres" => "RAMIREZ MAYHUA YOSELY JOBITA", "fecha_ingreso" => "2025-03-05", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "75344434", "nombres" => "RAMIREZ PINEDO FLAVIO JAIR", "fecha_ingreso" => "2025-08-01", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "71978762", "nombres" => "RAMOS CAMPOS LUZ REYNA", "fecha_ingreso" => "2024-05-16", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "71023191", "nombres" => "RODRIGUEZ MUÑOZ PIERO ALEXANDER", "fecha_ingreso" => "2024-11-20", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "48472363", "nombres" => "RODRIGUEZ PUJALLA FRANK JOHEL", "fecha_ingreso" => "2020-10-16", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "71261042", "nombres" => "ROJAS RUBIO PIERO ALESSANDRO", "fecha_ingreso" => "2025-07-14", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "74818842", "nombres" => "SAAVEDRA MEZONES ROSMERY ESTHER", "fecha_ingreso" => "2020-09-17", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "74923217", "nombres" => "SANCHEZ BAEZ JAIRO ROBERTO", "fecha_ingreso" => "2024-10-15", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "40039403", "nombres" => "SANTISTEBAN DIAZ ELVIRA DEL MILAGRO", "fecha_ingreso" => "2018-01-01", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "70993427", "nombres" => "SANTOS JIMENEZ ALDAIR FELIX", "fecha_ingreso" => "2022-04-11", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "20070014", "nombres" => "SEGOVIA SOVERO LUIS ANTONIO", "fecha_ingreso" => "2020-05-25", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "76320145", "nombres" => "SHAPIAMA MANIHUARI JEAN PIERS ANDRES", "fecha_ingreso" => "2024-05-23", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "70541486", "nombres" => "SHAPIAMA ZUMBA MAYKO DOUGLAS", "fecha_ingreso" => "2024-08-01", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "60182850", "nombres" => "SOCA SAUÑE JOSEPH ZACH", "fecha_ingreso" => "2024-05-06", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "70056923", "nombres" => "TAIPE BONIFACIO MILNER JAIRO", "fecha_ingreso" => "2024-08-02", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "73673637", "nombres" => "TICLLACURI GONZALES ESTEFANI BRIGGITE", "fecha_ingreso" => "2024-09-06", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "63422866", "nombres" => "TRIGOZO CANELAO YESSENIA", "fecha_ingreso" => "2023-05-15", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "46894980", "nombres" => "VALENCIA CHILE SUSAN SOFIA", "fecha_ingreso" => "2024-01-29", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "40823765", "nombres" => "VASQUEZ PALOMINO OSCAR", "fecha_ingreso" => "2022-06-08", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "74244850", "nombres" => "VILLEGAS JIMENEZ JANET", "fecha_ingreso" => "2022-01-13", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "23558568", "nombres" => "YURA BRAVO BELISARIO", "fecha_ingreso" => "2020-07-07", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ["dni" => "73883523", "nombres" => "ZUÑIGA PARDO JOMIRA", "fecha_ingreso" => "2021-11-10", "area" => "ALMACEN", "subvencion_parcial" => 0, "subvencion_completa" => 1],
        ['dni' => '76304359', 'nombres' => 'ALIAGA IPARRAGUIRRE JHON MARLON', 'fecha_ingreso' => '2025-10-03', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '60246210', 'nombres' => 'CACHIQUE QUIROZ JOSE ARTURO', 'fecha_ingreso' => '2025-11-14', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '78288290', 'nombres' => 'CALDERON CONDORI JUAN CARLOS', 'fecha_ingreso' => '2025-09-03', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '77351446', 'nombres' => 'CASTAÑEDA TOMY SANDRA JIMENA', 'fecha_ingreso' => '2025-10-20', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '46097933', 'nombres' => 'CHACON MENDOZA LIZBETH YSIDORA', 'fecha_ingreso' => '2025-10-21', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '47423109', 'nombres' => 'CLEMENTE ROMERO ABEL', 'fecha_ingreso' => '2025-08-11', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '75075420', 'nombres' => 'CRISANTO MARQUEZ HUGO SANDRO', 'fecha_ingreso' => '2025-10-13', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '60301100', 'nombres' => 'CUSICHE HUAIRA YURY', 'fecha_ingreso' => '2025-10-01', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '61124334', 'nombres' => 'DIAZ VIERA WILMER SEGUNDO', 'fecha_ingreso' => '2025-10-07', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '74702683', 'nombres' => 'GONZALES CAPRISTANO ANTHONY DANIEL', 'fecha_ingreso' => '2025-09-23', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '70261929', 'nombres' => 'MANIZARI SOZA JHORLIN MAURICIO', 'fecha_ingreso' => '2025-09-22', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '75986703', 'nombres' => 'MACURI JUNDIA KATY BEATRIZ', 'fecha_ingreso' => '2025-11-06', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '60004859', 'nombres' => 'MIGUEL VILLALVA JEENSI JOHAN', 'fecha_ingreso' => '2025-09-01', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '46113671', 'nombres' => 'NORIEGA CANAQUIRI OTTO', 'fecha_ingreso' => '2025-10-27', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '60929426', 'nombres' => 'RIOS PAREDES EDGAR ABELARDO', 'fecha_ingreso' => '2025-11-14', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '47622032', 'nombres' => 'SALDAÑA SABOYA JUAN LUIS', 'fecha_ingreso' => '2025-08-20', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '47676262', 'nombres' => 'SOLANO VERA MAGDALENA', 'fecha_ingreso' => '2025-10-20', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '75624849', 'nombres' => 'TORRES CRESPO SAYURI ESTEFANI', 'fecha_ingreso' => '2025-11-06', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '76656742', 'nombres' => 'VASQUEZ NEPIRE DANY JHAILETH', 'fecha_ingreso' => '2025-10-09', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        ['dni' => '77434075', 'nombres' => 'VASQUEZ TAMANI LUZ VERONICA', 'fecha_ingreso' => '2025-11-06', 'area' => 'ALMACEN', 'subvencion_parcial' => 1, 'subvencion_completa' => 0],
        [
            'dni' => '5393572',
            'nombres' => 'CUMARI RAYO CASIMIRO LUIS',
            'fecha_ingreso' => '2025-08-20',
            'area' => 'LIMPIEZA',
            'subvencion_parcial' => 1,
            'subvencion_completa' => 0
        ],
        [
            'dni' => '44959049',
            'nombres' => 'MORALES GARCIA ROBERTO AUGUSTO',
            'fecha_ingreso' => '2025-08-14',
            'area' => 'LIMPIEZA',
            'subvencion_parcial' => 1,
            'subvencion_completa' => 0
        ],
        [
            'dni' => '10601970',
            'nombres' => 'MAYORGA ANCHO ROSELIM JESSENIA',
            'fecha_ingreso' => '2024-07-15',
            'area' => 'LIMPIEZA',
            'subvencion_parcial' => 0,
            'subvencion_completa' => 1
        ],
        [
            'dni' => '43909199',
            'nombres' => 'SUAREZ UNTIVEROS ESTHER MARIA',
            'fecha_ingreso' => '2021-12-07',
            'area' => 'LIMPIEZA',
            'subvencion_parcial' => 0,
            'subvencion_completa' => 1
        ],
        ['dni' => '48844052', 'nombres' => 'ACHO LASERNA SAUL', 'fecha_ingreso' => '2025-02-27', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '76407900', 'nombres' => 'ALVAREZ PALACIOS CHIRTS YERICOI', 'fecha_ingreso' => '2023-04-27', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '60114635', 'nombres' => 'ANDRADE FABABA KELVIN', 'fecha_ingreso' => '2024-11-25', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '60110566', 'nombres' => 'ARBILDO MONTOYA DELCIO ABEL', 'fecha_ingreso' => '2025-03-25', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '75213595', 'nombres' => 'ATACHI VASQUEZ NELVIN', 'fecha_ingreso' => '2025-05-02', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '46292735', 'nombres' => 'BELEN ZAVALETA CLIMACO DARIO', 'fecha_ingreso' => '2021-05-26', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '42152585', 'nombres' => 'BERMEJO CORDOVA CRISTHIAM DIONICIO', 'fecha_ingreso' => '2025-01-07', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '42733928', 'nombres' => 'BONILLA PAUCAR MARCELINA LEONOR', 'fecha_ingreso' => '2023-03-20', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '17637616', 'nombres' => 'BUSTAMANTE SAMAME ALEJANDRO', 'fecha_ingreso' => '2018-01-01', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '76360171', 'nombres' => 'CAMASCA LEON RUSBELL MARCIAL', 'fecha_ingreso' => '2025-06-09', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '47293277', 'nombres' => 'CAPCHA MODRAGON CESAR EDUARDO', 'fecha_ingreso' => '2023-02-06', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '45144142', 'nombres' => 'CARMIN CONDOR MOISES', 'fecha_ingreso' => '2025-02-05', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '74925876', 'nombres' => 'CASAFRANCA GUTIERREZ YULI', 'fecha_ingreso' => '2023-03-29', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '70089630', 'nombres' => 'CASTILLO CHAVEZ JORGE ENRIQUE', 'fecha_ingreso' => '2018-02-06', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '70161836', 'nombres' => 'CASTILLO LUNA LEONEL RICHARD', 'fecha_ingreso' => '2023-07-03', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '77417961', 'nombres' => 'CASTRO VILLAFUERTE JESUS ALBERTO', 'fecha_ingreso' => '2023-05-17', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '47308387', 'nombres' => 'CERCADO CRUZADO WILDER FERNANDO', 'fecha_ingreso' => '2020-02-13', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '43162534', 'nombres' => 'CHOQUE MARCAS WILLLIAM JAVIER', 'fecha_ingreso' => '2025-04-03', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '77015415', 'nombres' => 'CHUNA AYALA JULIO CESAR', 'fecha_ingreso' => '2024-07-03', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '45372767', 'nombres' => 'CHUQUIVIGUEL HUAMAN LUIS EDILBERTO', 'fecha_ingreso' => '2023-05-20', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '45132091', 'nombres' => 'DE LAMA MENA DENISSE LISET', 'fecha_ingreso' => '2022-07-07', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '71068915', 'nombres' => 'DUENDE JIPA NEXDEA', 'fecha_ingreso' => '2025-07-07', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '000001944', 'nombres' => 'ESCALONA LINARES LUIS ALBERTO', 'fecha_ingreso' => '2021-11-11', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '81633167', 'nombres' => 'FALCON LASERNA MIRLA ESTER', 'fecha_ingreso' => '2025-02-15', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '75960445', 'nombres' => 'FERNANDEZ AMPUERO ALEX YONER', 'fecha_ingreso' => '2024-03-01', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '43872989', 'nombres' => 'FERRO CARPIO ESPERANZA', 'fecha_ingreso' => '2020-07-03', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '41328090', 'nombres' => 'FLORES CONDORI ELMER', 'fecha_ingreso' => '2025-06-10', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '80592562', 'nombres' => 'FLORES GARCIA CARLOS', 'fecha_ingreso' => '2020-05-02', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '46260714', 'nombres' => 'FLORES GARCIA DAVID', 'fecha_ingreso' => '2018-11-14', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '09927457', 'nombres' => 'FLORES MORALES CARLOS ALBERTO', 'fecha_ingreso' => '2020-06-24', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '43089238', 'nombres' => 'FLORES ROJAS LUIS', 'fecha_ingreso' => '2025-07-14', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '46680293', 'nombres' => 'GARCIA LOPEZ LLEYKER ROY', 'fecha_ingreso' => '2025-02-04', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '75223294', 'nombres' => 'GONZALES FLORES CLEVER', 'fecha_ingreso' => '2023-07-05', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '47731817', 'nombres' => 'GONZALES ISUIZA RICARDO', 'fecha_ingreso' => '2021-05-07', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '48147253', 'nombres' => 'GONZALES MARIN RONAL', 'fecha_ingreso' => '2025-01-11', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '76133662', 'nombres' => 'GUEVARA PECHE AUSTIN ALEJANDRO', 'fecha_ingreso' => '2024-08-02', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '43118319', 'nombres' => 'GUTIERREZ VARGAS RITMER', 'fecha_ingreso' => '2021-01-09', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '76417289', 'nombres' => 'GUZMAN MEZA JOEL ISMAEL', 'fecha_ingreso' => '2023-06-26', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '33595488', 'nombres' => 'HERRERA BARBOZA ROSELITA', 'fecha_ingreso' => '2018-01-04', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '71442393', 'nombres' => 'HUALINGA RUIZ MOISES JOSEPH', 'fecha_ingreso' => '2025-05-06', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '48841850', 'nombres' => 'HUAMAN LANDEO JULIAN YERSON', 'fecha_ingreso' => '2024-03-14', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '73933563', 'nombres' => 'HUAMANI MEDRANO LUIS ENRIQUE', 'fecha_ingreso' => '2023-08-18', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '44316429', 'nombres' => 'ISUIZA REATEGUI JAMES', 'fecha_ingreso' => '2023-05-24', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '60409309', 'nombres' => 'JARA AMAO RONALD EDGARD ALEXANDER', 'fecha_ingreso' => '2023-02-23', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '42641708', 'nombres' => 'JIMENEZ CAHUACHI CARLOS', 'fecha_ingreso' => '2024-06-10', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '48762161', 'nombres' => 'JIMPI CHUNKUNT TSANIM', 'fecha_ingreso' => '2024-07-01', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '61243012', 'nombres' => 'LEMOS VALLES XAVI WALTER', 'fecha_ingreso' => '2025-06-19', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '77277919', 'nombres' => 'LOPEZ TECO LINDER', 'fecha_ingreso' => '2022-08-18', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '75111633', 'nombres' => 'MACEDO OLORTEGUI ARDRI FRANCHE', 'fecha_ingreso' => '2025-03-11', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '74748334', 'nombres' => 'MAGAN ZAPATA JOSUE ANTONIO', 'fecha_ingreso' => '2025-04-01', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '43179994', 'nombres' => 'MANDRUNI VELA MAVILO', 'fecha_ingreso' => '2022-06-14', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '47859534', 'nombres' => 'MAYNAS AMPUERO TIMOTEO', 'fecha_ingreso' => '2025-02-17', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '62179548', 'nombres' => 'MEJIA REYES LEONEL ALEXANDER', 'fecha_ingreso' => '2025-03-21', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '71079114', 'nombres' => 'MELO VIZCARRA JUNIOR ALEJANDRO', 'fecha_ingreso' => '2021-07-24', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '073159607', 'nombres' => 'MILLAN RODRIGUEZ WILFREDO JESUS', 'fecha_ingreso' => '2021-07-16', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '47919536', 'nombres' => 'MORE ROSAS EDSON ERNESTO', 'fecha_ingreso' => '2024-03-12', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '49036982', 'nombres' => 'NARCIZO CESPEDES MAVEL', 'fecha_ingreso' => '2025-02-07', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '60737783', 'nombres' => 'ODICIO MURAYARI TITO ALEX', 'fecha_ingreso' => '2025-03-13', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '41072576', 'nombres' => 'OSORES ALCOCER EDWIN JEAN', 'fecha_ingreso' => '2024-12-04', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '41951880', 'nombres' => 'OSORES ISLA JAVIER ABNER', 'fecha_ingreso' => '2021-01-22', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '09957167', 'nombres' => 'PAJUELO RONDAN MARIO CESAR', 'fecha_ingreso' => '2020-05-26', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '42743508', 'nombres' => 'PALOMINO ALBINO JIMMY', 'fecha_ingreso' => '2024-06-13', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '46133016', 'nombres' => 'PALOMINO LOAYZA LUIS ALFREDO', 'fecha_ingreso' => '2025-07-07', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '80902414', 'nombres' => 'PANDURO GARCIA FREDDY JAIR', 'fecha_ingreso' => '2024-02-09', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '76698756', 'nombres' => 'PANDURO RODRIGUEZ GESSLER ARTEMIO', 'fecha_ingreso' => '2025-06-11', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '45420574', 'nombres' => 'PANDURO TANGOA JULIO CESAR', 'fecha_ingreso' => '2024-09-18', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '43126473', 'nombres' => 'PAREDES PACAYA REISER', 'fecha_ingreso' => '2023-08-10', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '46098747', 'nombres' => 'PEREZ FARFAN OSCAR CRISTHIAN', 'fecha_ingreso' => '2025-07-07', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '47852034', 'nombres' => 'PICOTA ANCON SILA', 'fecha_ingreso' => '2024-12-16', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '40173262', 'nombres' => 'POMA GARCIA JENNY', 'fecha_ingreso' => '2022-02-19', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '61503695', 'nombres' => 'PORRO DURAND WILLIAN ISIDRO', 'fecha_ingreso' => '2025-05-29', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '41218556', 'nombres' => 'QUISPE CHUÑOCCA REYNA', 'fecha_ingreso' => '2020-08-17', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '44309481', 'nombres' => 'RAMIREZ HUAYAMA ALZAMENY', 'fecha_ingreso' => '2025-02-04', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '76539574', 'nombres' => 'RAMOS SAVILVINO LEONCIO', 'fecha_ingreso' => '2025-03-25', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '47992511', 'nombres' => 'RICARDO MUÑICO ALAN NIKE', 'fecha_ingreso' => '2023-02-15', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '44807502', 'nombres' => 'RICRA YACHACHIN YANNET ELSA', 'fecha_ingreso' => '2021-03-27', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '43579238', 'nombres' => 'RODRIGUEZ ANCON SAUL', 'fecha_ingreso' => '2024-06-25', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '76679216', 'nombres' => 'ROMAINA BARBARAN SANTIAGO', 'fecha_ingreso' => '2025-05-07', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '77798955', 'nombres' => 'RUIZ SHUPINGAHUA ARON ALDAIR', 'fecha_ingreso' => '2024-05-07', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '47495571', 'nombres' => 'SALAS AMASIFUEN GUINGLER RONIN', 'fecha_ingreso' => '2023-04-26', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '45119163', 'nombres' => 'SALDAÑA YASPANA JULIO CESAR', 'fecha_ingreso' => '2024-09-28', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '46488511', 'nombres' => 'SANCHEZ TAPIA ROSALINA', 'fecha_ingreso' => '2022-01-14', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '47902100', 'nombres' => 'SANCHEZ TINEO ALEX WILLIAM', 'fecha_ingreso' => '2020-05-06', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '60185651', 'nombres' => 'SANDA PANDURO ORLANDO', 'fecha_ingreso' => '2025-02-11', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '46225848', 'nombres' => 'SANGAMA SANGAMA AUBER', 'fecha_ingreso' => '2021-01-26', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '75624835', 'nombres' => 'SAUÑE QUICAÑA MARIA ESTHER', 'fecha_ingreso' => '2022-02-23', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '08160380', 'nombres' => 'SILVA PACHECO ALBERTO MERCEDES', 'fecha_ingreso' => '2018-01-01', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '08147929', 'nombres' => 'SILVA PACHECO ROMMEL EDGARDO', 'fecha_ingreso' => '2018-11-24', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '43445246', 'nombres' => 'SUYON CAVERO CARLOS ALEJANDRO', 'fecha_ingreso' => '2025-07-07', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '72872176', 'nombres' => 'TORRES RODAS OSCAR ANTONIO', 'fecha_ingreso' => '2023-07-24', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '75602487', 'nombres' => 'TUMBAY ROMERO JHORDY', 'fecha_ingreso' => '2025-06-16', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '70398607', 'nombres' => 'VILLAVICENCIO PANTOJA RAFAEL FRANCO', 'fecha_ingreso' => '2024-08-16', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '48145650', 'nombres' => 'YANAMARI IMUNDA GABRIEL', 'fecha_ingreso' => '2025-02-05', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '48125113', 'nombres' => 'YUIMACHI YUMBATO JOEL', 'fecha_ingreso' => '2024-03-04', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '44529970', 'nombres' => 'ZAMORA CHAVEZ ALFREDO', 'fecha_ingreso' => '2024-09-28', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ['dni' => '74255610', 'nombres' => 'ZARATE CONDORI JESSICA', 'fecha_ingreso' => '2025-06-24', 'area' => 'PRODUCCION', 'subvencion_parcial' => 0, 'subvencion_completa' => 1],
        ["dni" => "41368139", "nombres" => "ALIAGA HUAYTA DAVID MIGUEL", "fecha_ingreso" => "2025-10-17", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "70573430", "nombres" => "BELLIDO QUISPE JAIME DARIO", "fecha_ingreso" => "2025-10-06", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "42316497", "nombres" => "CASTRO ACHO EDSON", "fecha_ingreso" => "2025-10-27", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "46684079", "nombres" => "CHAVEZ PRADO LIZET ANTONIA", "fecha_ingreso" => "2025-10-16", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "48588209", "nombres" => "CORDOVA ROJAS MACEDONIO", "fecha_ingreso" => "2025-09-15", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "80232243", "nombres" => "CRUZ SILVANO LIMBER", "fecha_ingreso" => "2025-09-03", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "76496204", "nombres" => "CUMARI UTIA JOSIAS LUIS", "fecha_ingreso" => "2025-08-20", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "75992009", "nombres" => "DAVILA MOMTALVAN DAVOR OWEN ALESSANDRO", "fecha_ingreso" => "2025-11-14", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "43076272", "nombres" => "FASABI CASTILLO EDINSON", "fecha_ingreso" => "2025-08-14", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],

        // Registro invertido corregido
        ["dni" => "61949076", "nombres" => "GAMBOA VARGAS INES JUANA", "fecha_ingreso" => "2025-11-14", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],

        ["dni" => "76148495", "nombres" => "GARCIA OCHOA CESAR BENJAMIN", "fecha_ingreso" => "2025-10-06", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "63336396", "nombres" => "GONZALES FERNANDEZ JIMMY STALYN", "fecha_ingreso" => "2025-08-11", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "40564004", "nombres" => "GUINEA OVALLE MARCIAL", "fecha_ingreso" => "2025-10-10", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "76994897", "nombres" => "HUARANGA NARCIZO JERSON", "fecha_ingreso" => "2025-09-17", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "40282193", "nombres" => "ISHUIZA SINARAHUA ABNER", "fecha_ingreso" => "2025-09-23", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "48182438", "nombres" => "LOPEZ HUAMANI MILAGROS MEDALIT", "fecha_ingreso" => "2025-10-20", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "76669181", "nombres" => "MONDALUISA SILVANO DEIVIS CRISTIAN", "fecha_ingreso" => "2025-11-12", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "45116076", "nombres" => "NOLORBE MAFALDO DIANA CAROLINA", "fecha_ingreso" => "2025-10-13", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "44985630", "nombres" => "ORTIZ MUÑOZ VICTOR EDUARDO", "fecha_ingreso" => "2025-09-23", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "76454275", "nombres" => "OROCHE RUIZ ROSMERY MALENA", "fecha_ingreso" => "2025-11-12", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "49079247", "nombres" => "RODRIGUEZ FERNANDEZ ALEX GABRIEL", "fecha_ingreso" => "2025-10-16", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "62874745", "nombres" => "SALINAS CHAVEZ KEBIN ANIBAL", "fecha_ingreso" => "2025-11-03", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "63096269", "nombres" => "SILVA ANDI CARLOS ANTONIO", "fecha_ingreso" => "2025-11-03", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "73368743", "nombres" => "TAIPE PACHECO DORIS", "fecha_ingreso" => "2025-10-06", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "74549231", "nombres" => "TAPULLIMA PASHANASI ELISEO", "fecha_ingreso" => "2025-09-23", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "46504848", "nombres" => "TORRES PALACIOS JULIO CESAR", "fecha_ingreso" => "2025-08-18", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "46301119", "nombres" => "TUNQUI TAPARA OSCAR VIDAL", "fecha_ingreso" => "2025-09-11", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "62614058", "nombres" => "VALERA ARCENTALES JHORLIN OLIVER", "fecha_ingreso" => "2025-11-03", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "62874388", "nombres" => "VASQUEZ CAHUACHI JEFERSON", "fecha_ingreso" => "2025-09-23", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "44864994", "nombres" => "VILCA TACUCHE HERMELINDA DORCAS", "fecha_ingreso" => "2025-09-29", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],

        // Corregido nombres entre comillas
        ["dni" => "43525128", "nombres" => "VASQUEZ SANCHEZ JOSE ANTONIO", "fecha_ingreso" => "2025-11-18", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],

        ["dni" => "45968248", "nombres" => "YRCAÑAUPA ANDRADE SILVIA MARGOT", "fecha_ingreso" => "2025-10-27", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "62440729", "nombres" => "YUIMACHI TAMANI JOSE JOEL", "fecha_ingreso" => "2025-11-14", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0],
        ["dni" => "43982757", "nombres" => "YUPANQUI LLACTAHUAMAN RAFAEL", "fecha_ingreso" => "2025-09-02", "area" => "PRODUCCION", "subvencion_parcial" => 1, "subvencion_completa" => 0]
    ];

    \Illuminate\Support\Facades\DB::beginTransaction();
    try {
        foreach ($workes as $w) {
            if (Worker::query()->where("numdoc", $w['dni'])->count() == 0) {
                Worker::query()->create([
                    'type_document_id' => 1, //DNI
                    'numdoc' => $w['dni'],
                    'names' => $w['nombres'],
                    'area_id' => Area::query()->where('name', $w['area'])->first()->id ?? null,
                    'admission_date' => $w['fecha_ingreso'],
                    'allowed_meals' => ['1', '2', '3'],
                    'grant' => $w['subvencion_parcial'],
                    'grant_complete' => $w['subvencion_completa'],
                ]);
            } else {
                Worker::query()->where("numdoc", $w['dni'])->update([
                    'grant' => 0,
                    'grant_complete' => 0,
                ]);
                Worker::query()->where("numdoc", $w['dni'])->update([
                    'area_id' => Area::query()->where('name', $w['area'])->first()->id ?? null,
                    'grant' => $w['subvencion_parcial'],
                    'grant_complete' => $w['subvencion_completa'],
                ]);
            }
        }
        \Illuminate\Support\Facades\DB::commit();
        return response()->json(["message" => "TRABAJADORES ANTIGUOS INSERTADOS CORRECTAMENTE"], Response::HTTP_CREATED);
    } catch (\Illuminate\Database\QueryException $e) {
        \Illuminate\Support\Facades\DB::rollBack();
        return response()->json(["message" => "ERROR AL INSERTAR LOS TRABAJADORES ANTIGUOS", "error" => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
});

Route::get("/", fn() => response()->json(["message" => "PRIVATE SERVICE REST"]));

Route::get("/health-check", fn() => response()->json(["status" => "OK"], Response::HTTP_OK));

Route::get("/pasarProductoAntiguos", [TestController::class, "pasarProductoAntiguos"]);

Route::prefix("internal/biometric-bridge")->group(function () {
    Route::get("sales/{saleId}/ticket", [BiometricBridgeController::class, "saleTicket"]);
    Route::get("past-sales/{saleId}/ticket", [BiometricBridgeController::class, "pastSaleTicket"]);
    Route::get("fingerprints", [BiometricBridgeController::class, "fingerprints"]);
    Route::post("templates", [BiometricBridgeController::class, "templates"]);
});




/* START AUTH ROUTES */
Route::post("login", [AuthController::class, "login"]);
Route::post("logout", [AuthController::class, "logout"])->middleware(['auth:sanctum']);
/* END AUTH ROUTES */

/* START PROTECTED ROUTES */
Route::middleware(["auth:sanctum"])->group(function () {

    /* start routes profile*/
    Route::apiResource("profile", ProfileController::class)->only(["show", "update"]);
    /* end routes profile*/

    /* start routes users*/
    Route::get("users/getAllResources", [UserController::class, "getAllResources"]);
    Route::apiResource("users", UserController::class);
    /* end routes users*/

    /* start routes workers*/
    Route::post("workers/generateExcel", [WorkerController::class, "generateExcel"]);
    Route::post("workers/generatePdf", [WorkerController::class, "generatePdf"]);
    Route::get("workers/importTemplate", [WorkerController::class, "importTemplate"]);
    Route::post("workers/importExcel", [WorkerController::class, "importExcel"]);
    Route::get("workers/searchSensitive", [WorkerController::class, "searchSensitive"]);
    Route::get("workers/getAllResources", [WorkerController::class, "getAllResources"]);
    Route::apiResource("workers", WorkerController::class);
    /* end routes workers*/

    /* start routes products */
    Route::get("products/productsFilters", [ProductController::class, "productsFilters"]);
    Route::get("products/searchOneProduct", [ProductController::class, "searchOneProduct"]);
    Route::get("products/searchSensitive", [ProductController::class, "searchSensitive"]);
    Route::get("products/getAllResources", [ProductController::class, "getAllResources"]);
    Route::apiResource("products", ProductController::class);
    /* end routes products*/

    /* start routes sales*/
    Route::post("sales/totalsSaleProductsAlmuerzo", [SaleController::class, "totalsSaleProductsAlmuerzo"]);
    Route::post("sales/totalsSaleProductsByCategory", [SaleController::class, "totalsSaleProductsByCategory"]);
    Route::post("sales/generateTicket", [SaleController::class, "generateTicket"]);
    Route::post("sales/subVencionStore", [SaleController::class, "subVencionStore"]);
    Route::get("sales/getAllResources", [SaleController::class, "getAllResources"]);
    Route::apiResource("sales", SaleController::class);
    /* end routes sales*/

    /* start routes past sales*/
    Route::post("pastSales/generateTicket", [PastSaleController::class, "generateTicket"]);
    Route::post("pastSales/subVencionStore", [PastSaleController::class, "subVencionStore"]);
    Route::get("pastSales/getAllResources", [PastSaleController::class, "getAllResources"]);
    Route::apiResource("pastSales", PastSaleController::class);
    /* end routes past sales*/

    /* start routes consumption*/
    Route::post("consumptions/generateExcelSubvencionPerDay", [ConsumptionController::class, "generateExcelSubvencionPerDay"]);
    Route::post("consumptions/generateExcelDiningSummary", [ConsumptionController::class, "generateExcelDiningSummary"]);
    Route::post("consumptions/generateExcelWorkerSummary", [ConsumptionController::class, "generateExcelWorkerSummary"]);
    Route::post("consumptions/generateExcelConsumption", [ConsumptionController::class, "generateExcelConsumption"]);
    Route::post("consumptions/generateExcelSubvencion", [ConsumptionController::class, "generateExcelSubvencion"]);
    Route::get("consumptions/getAllResources", [ConsumptionController::class, "getAllResources"]);
    Route::apiResource("consumptions", ConsumptionController::class);
    /* end routes consumption*/

    /* start routes home dashboard */
    Route::get("home/getSalesProductCount", [HomeController::class, "getSalesProductCount"]);
    Route::get("home/getAllResources", [HomeController::class, "getAllResources"]);


    /* end routes home dashboard */
});
/* END PROTECTED ROUTES */


Route::fallback(fn() => response()->json(["message" => "RESOURCE NOT FOUND"], Response::HTTP_NOT_FOUND));
