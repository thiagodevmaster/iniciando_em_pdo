<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\infrastructure\Percistence\ConectionCreator;

require_once "vendor/autoload.php";

$pdo = ConectionCreator::createConection();

$student = new Student(
    null,
    'Thiago dantas',
    new DateTimeImmutable('1997-12-03')
);

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (?, ?);";
$statement = $pdo->prepare($sqlInsert);
$statement->bindValue(1, $student->name());
$statement->bindValue(2, $student->birthDate()->format('d-m-Y'));

if ($statement->execute()) {
    echo 'Aluno incluido no banco.' . PHP_EOL;
};
