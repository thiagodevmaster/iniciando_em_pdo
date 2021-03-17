<?php

namespace Alura\Pdo\Domain\Repository;

use DateTimeInterface;

interface StudentRepository
{
    public function allStudents(): array;

    public function studentBirthDate(DateTimeInterface $birthDate): array;

    public function saveStudent(): bool;

    public function remove(): bool;
}
