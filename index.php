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

$categoryCount = array_count_values($category);
$numberCat = "0";
$topCategory = "0";