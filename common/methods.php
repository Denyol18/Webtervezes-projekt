<?php

function loadData(string $filename): array {
    $file = fopen($filename, "r");
    $arraydata = [];

    if (!$file) {
        die("Nem sikerült a fájl megnyitása!");
    }

    while (($row = fgets($file)) !== false) {
        $data = unserialize($row);
        $arraydata[] = $data;
    }

    fclose($file);
    return $arraydata;
}

function saveData(string $filename, array $arraydata) {
    $file = fopen($filename, "w");

    if (!$file) {
        die("Nem sikerült a fájl megnyitása!");
    }

    foreach ($arraydata as $data) {
        fwrite($file, serialize($data) . "\n");
    }

    fclose($file);
}
