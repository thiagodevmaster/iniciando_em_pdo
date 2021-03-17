<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\infrastructure\Percistence\ConectionCreator;

require_once "vendor/autoload.php";

$pdo = ConectionCreator::createConection();

$prepareStatemente = $pdo->prepare('DELETE FROM students WHERE id = ?;');
$prepareStatemente->bindValue(1, 1, PDO::PARAM_INT);
