<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\infrastructure\Percistence\ConectionCreator;

require_once "vendor/autoload.php";

$pdo = ConectionCreator::createConection();

$statement = $pdo->query('SELECT * FROM students;');

while ($studentData = $statement->fetch(PDO::FETCH_ASSOC)) {
    $student = new Student(
        $studentData['id'],
        $studentData['name'],
        new DateTimeImmutable($studentData['birth_date'])
    );

    echo $student->age() . PHP_EOL;
};

exit();


$studentDataList = $statement->fetch(PDO::FETCH_ASSOC);
$studentList = [];

var_dump($studentDataList);
exit();


foreach ($studentDataList as $studentData) {
    $studentList[] = new Student(
        $studentData['id'],
        $studentData['name'],
        new DateTimeImmutable($studentData['birth_date'])
    );
}
