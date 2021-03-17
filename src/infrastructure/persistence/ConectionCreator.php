<?php

namespace Alura\Pdo\infrastructure\Percistence;

use PDO;

class ConectionCreator
{
    public static function createConection(): PDO
    {
        $dataBasePath = __DIR__ . '/../../../banco.sqlite';
        return new PDO('sqlite:' . $dataBasePath);
    }
}
