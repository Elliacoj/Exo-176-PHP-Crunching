<?php
// Le dictionnaire

$string = file_get_contents("dictionnaire.txt");
$tabWord = explode("\n", $string);

echo "Il y a: " . count($tabWord) . " mots dans le dictionnaire!<br>";


$word15 = 0;
$wordLettreW = 0;
$wordLettreEnd = 0;
foreach ($tabWord as $word) {
    if(strlen(trim($word)) === 15) {
        $word15++;
    }

    if (strpos($word, "w")) {
        $wordLettreW++;
    }

    if($word[strlen(trim($word)) - 1] === "q") {
        $wordLettreEnd++;
    }


}
echo "Il y a: " . $word15 . " mots dans le dictionnaire à 15 lettres!<br>";

echo "Il y a: " . $wordLettreW . " mots dans le dictionnaire avec la lettre 'W'!<br>";

echo "Il y a: " . $wordLettreEnd . " mots dans le dictionnaire qui finnissent avec la lettre 'Q'!<br>";

echo "<br><br><br>";
// Les Films

$stringFilm = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
$films = json_decode($stringFilm, true);
$entry = $films['feed']['entry'];

// Top 10 des films
for($x = 0; $x < 10; $x++) {
    echo ($x + 1) . ": " . $entry[$x]['im:name']['label'] . "<br>";
}

echo "<br>";

// Place du film "Gravity
$place = 0;
foreach ($entry as $film) {
    if($film['im:name']['label'] !== "Gravity") {
        $place++;
    }
    else {
        $place++;
        break;
    }
}
echo "Le film Gravity est à la: " . $place . " place du classement.<br>";

// Le réalisateur du film Lego
foreach ($entry as $film) {
    if($film['im:name']['label'] === "The LEGO Movie") {
        echo "Les réalisateurs du film 'The LEGO Movie' sont: " . $film["im:artist"]['label'] . ".<br>";
    }
}

// Le nombre de films réalisés avant 2000
$past2000 = 0;
foreach ($entry as $film) {
    if(strtotime($film['im:releaseDate']['label']) < strtotime("january 2, 2000")) {
        $past2000++;
    }
}
echo "Il y a " . $past2000 . " films qui ont été fait avant 2000 dans le classement.<br>";

// Le film le plus récent
$time = 0;
foreach ($entry as $film) {
    if(strtotime($film['im:releaseDate']['label']) > $time) {
        $time = strtotime($film['im:releaseDate']['label']);
    }
}

foreach ($entry as $film) {
    if(strtotime($film['im:releaseDate']['label']) === $time) {
        echo "Le film le plus récent est: " . $film['im:name']['label'] . " du " . $film['im:releaseDate']['attributes']['label'] .".<br>";
    }
}

// Le film le plus vieux
foreach ($entry as $film) {
    if(strtotime($film['im:releaseDate']['label']) < $time) {
        $time = strtotime($film['im:releaseDate']['label']);
    }
}

foreach ($entry as $film) {
    if(strtotime($film['im:releaseDate']['label']) === $time) {
        echo "Le film le plus vieux est: " . $film['im:name']['label'] . " du " . $film['im:releaseDate']['attributes']['label'] .".<br>";
    }
}

// La catégorie la plus présente
$category = [];
foreach ($entry as $film) {
    array_push($category, $film['category']['attributes']["label"]);
}

$categoryCount = array_count_values($category);
$maxCat = max($categoryCount);

foreach ($categoryCount as $item => $value) {
    if($value == $maxCat) {
        echo "La categorie la plus présente est: " . $item . ".<br>";
    }
}


// Le réalisateur le plus présent

$realisateur = [];
foreach ($entry as $film) {
    array_push($realisateur, trim($film['im:artist']['label']));
}

$realCount = array_count_values($realisateur);
$maxReal = max($realCount);

foreach ($realCount as $item => $value) {
    if($value == $maxReal) {
        echo "La categorie la plus présente est: " . $item . ".<br>";
    }
}

// Acheter le top 10 et le louer

$sent = 0;
$rent = 0;

for($x = 0; $x < 10; $x++) {
    $sent = $sent + $entry[$x]['im:price']['attributes']['amount'];
    $rent = $rent + $entry[$x]['im:rentalPrice']['attributes']['amount'];
}

echo "Le prix d'achat pour le top 10 des films est de: " . $sent . " dollars <br>";
echo "Le prix de location pour le top 10 des films est de: " . $rent . " dollars <br>";

// Mois le plus de sortie

$months = [];
foreach ($entry as $film) {
    $month = strtotime($film['im:releaseDate']['attributes']['label']);
    array_push($months, strftime("%B", $month));
}

$monthsCount = array_count_values($months);
$maxMonth = max($monthsCount);

foreach ($monthsCount as $item => $value) {
    if($value == $maxMonth) {
        echo "La mois avec le plus de sortie est le mois de: " . $item . ".<br>";
    }
}
echo "<br><br>";
//Top 10 films budgets

$downPrices = [];
foreach ($entry as $film) {
    $downPrices[$film['im:name']['label']] = $film['im:price']['attributes']['amount'];
}

asort($downPrices);
$val = 0;

foreach ($downPrices as $item => $price) {
    if($val < 10) {
        echo ($val + 1) . ": " . $item . " à " . $price . " dollars <br>";
        $val++;
    }
}