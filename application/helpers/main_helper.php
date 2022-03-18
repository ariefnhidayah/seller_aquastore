<?php

function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}

function rupiah_input($angka) {
	$hasil_rupiah = number_format($angka,0,',','.');
	return $hasil_rupiah;
}

function generate_url($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  $random = rand(1000,999);

  $text .= '-' . time();

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}