<?php

require_once 'vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;

$student = new Student(
    null,
    'Vinicius Dias',
    new \DateTimeImmutable('1997-10-15')
);

echo $student->age();
