<?php
require_once '../db/Report.php';


function rupiah($angka)
{
    $hasil = 'Rp ' . number_format($angka, 2, ",", ".");
    return $hasil;
}

$report = new Report;

$report->items();
