<?php

namespace Alura\Pdo\infrastructure\Repository;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use DateTimeImmutable;
use PDO;
use PDOStatement;

class PdoStudentsRepository implements StudentRepository
{
    private PDO $conection;

    public function __construct(PDO $conection)
    {
        $this->conection = $conection;
    }

    public function allStudents(): array
    {
        $statement = $this->conection->query('SELECT * FROM students;');
        return $this->hydratateStudentList($statement);

        // $studentList = [];

        // while ($studentData = $statement->fetch(PDO::FETCH_ASSOC)) {
        //     $student = new Student(
        //         $studentData['id'],
        //         $studentData['name'],
        //         new DateTimeImmutable($studentData['birth_date'])
        //     );
        //     $studentList[] = $student;
        // }

        // return $studentList;
    }

    public function studentBirthDate(DateTimeInterface $birthDate): array
    {
        $statement = $this->conection->query('SELECT * FROM students WHERE birth_date = ?;');
        $statement = $this->conection->prepare($statement);
        $statement->bindValue(1, $birthDate->format('d-m-Y'));
        $statement->execute();

        return $this->hydratateStudentList($statement);
    }

    private function hydratateStudentList(PDOStatement $statement): array
    {
        $studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach ($studentDataList as $studentData) {
            $student = new Student(
                $studentData['id'],
                $studentData['name'],
                new DateTimeImmutable($studentData['birth_date'])
            );

            $studentList[] = $student;
        };

        return $studentList;
    }

    public function saveStudent(Student $studant): bool
    {
        if ($student->id() === null) {
            return $this->insert($studant);
        }

        return $this->updateStudent($studant);
    }

    private function insert(Student $student): bool
    {
        $insertQuery = 'INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);';
        $statement = $this->conection->prepare($insertQuery);

        $sucess = $statement->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('d-m-Y')
        ]);

        if ($sucess) {
            $student->defineId($this->conection->lastInsertId());
        };

        return $sucess;
    }

    private function updateStudent(Student $student): bool
    {
        $sqlUpdate = 'UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id ;';
        $statement = $this->conection->prepare($sqlUpdate);
        $statement->bindValue(':name', $student->name());
        $statement->bindValue(':birth_date', $student->birthDate()->format('d-m-Y'));
        $statement->bindValue(':id', $student->id());

        return $statement->execute();
    }

    public function remove(Student $student): bool
    {
        $statement = $this->conection->prepare('DELETE FROM students WHERE id = ?;');
        $statement->bindValue(1, $student->id(), PDO::PARAM_INT);

        return $statement->execute();
    }
}
