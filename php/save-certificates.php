<?php
/**
 * Arquivo responsavel por gerar e salvar os arquivos PDF.
 *
 * @author Tiago Ribas <tgoribas@gmail.com>
 */

session_start();
require 'Config.php';
$config = new Config();

// Prepara as variaveis
$image = $_POST['image'];
$fileName = $_POST['name'];
$newFolder = $_SESSION['newFolder'] = $_POST['newFolder'];

// Cria pasta para salvar os arquivos
$filedir = '../certificate/' . $newFolder ;
$filePath = $filedir . "/" . $fileName . ".png" ;

// Prepara a imagem em PNG
$image = str_replace('data:image/png;base64,', '', $image);
$decoded = base64_decode($image);

// Salva a imagem no formato PNG
file_put_contents($filePath, $decoded, LOCK_EX);

$folderImagick = $config->FOLDER . "/certificate/" . $newFolder . "/" . $fileName . ".png";
$pdfImagick    = $config->FOLDER . "/certificate/" . $newFolder . "/" . $fileName . ".pdf";

$img = new Imagick($folderImagick);
$img->setImageCompressionQuality(100);
$img->setImageFormat('pdf');
$success = $img->writeImage($pdfImagick);
