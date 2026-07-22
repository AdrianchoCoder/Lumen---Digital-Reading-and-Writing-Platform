<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

/**
 * Conexión PDO singleton a MySQL.
 * Todas las consultas del proyecto deben obtener la instancia desde aquí.
 */
final class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct(array $dbConfig)
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $dbConfig['host'],
            $dbConfig['port'],
            $dbConfig['name'],
            $dbConfig['charset']
        );

        try {
            $this->pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException(
                'No se pudo conectar a la base de datos. Verifica config/config.php y que MySQL esté activo en XAMPP.',
                (int) $e->getCode(),
                $e
            );
        }
    }

    public static function getInstance(?array $dbConfig = null): self
    {
        if (self::$instance === null) {
            if ($dbConfig === null) {
                throw new RuntimeException('Database::getInstance() requiere la configuración en la primera llamada.');
            }
            self::$instance = new self($dbConfig);
        }

        return self::$instance;
    }

    public function pdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * Impide clonar el singleton.
     */
    private function __clone(): void
    {
    }

    public function __wakeup(): void
    {
        throw new RuntimeException('No se permite deserializar Database.');
    }
}
