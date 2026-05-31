<?php
namespace YourVendor\SecureConnection;

use PDO;
use PDOException;
use YourVendor\SecureConnection\Exception\ConnectionException;

class Connection
{
    private ?PDO $pdo = null;
    private int $retryAttempts = 3;
    private int $retryDelayMicroseconds = 500000;

    public function __construct(
        private readonly ConnectionConfig $config
    ) {}

    public function connect(): PDO
    {
        if ($this->pdo instanceof PDO) {
            return $this->pdo;
        }

        $attempt = 0;
        do {
            try {
                $this->pdo = new PDO(
                    $this->config->getDsn(),
                    $this->config->username,
                    $this->config->password,
                    $this->getDefaultOptions() + $this->config->options
                );
                return $this->pdo;
            } catch (PDOException $e) {
                $attempt++;
                if ($attempt >= $this->retryAttempts) {
                    throw new ConnectionException(
                        "Connection failed after {$this->retryAttempts} attempts.",
                        0,
                        $e
                    );
                }
                usleep($this->retryDelayMicroseconds);
            }
        } while ($attempt < $this->retryAttempts);

        throw new ConnectionException('Unexpected connection error.');
    }

    private function getDefaultOptions(): array
    {
        return [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }

    public function select(string $table, array $where = [], string $extra = ''): array
    {
        $sql = "SELECT * FROM `{$table}`";
        $params = [];
        if (!empty($where)) {
            $conditions = [];
            foreach ($where as $col => $val) {
                $conditions[] = "`{$col}` = :{$col}";
                $params[":{$col}"] = $val;
            }
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        $sql .= " {$extra}";
        return $this->query($sql, $params)->fetchAll();
    }

    public function insert(string $table, array $data): int
    {
        $columns = implode('`, `', array_keys($data));
        $placeholders = implode(', :', array_keys($data));
        $sql = "INSERT INTO `{$table}` (`{$columns}`) VALUES (:{$placeholders})";
        $params = [];
        foreach ($data as $col => $val) {
            $params[":{$col}"] = $val;
        }
        $this->execute($sql, $params);
        return (int)$this->lastInsertId();
    }

    public function update(string $table, array $data, array $where): int
    {
        $setClauses = [];
        $params = [];
        foreach ($data as $col => $val) {
            $setClauses[] = "`{$col}` = :set_{$col}";
            $params[":set_{$col}"] = $val;
        }
        $whereClauses = [];
        foreach ($where as $col => $val) {
            $whereClauses[] = "`{$col}` = :where_{$col}";
            $params[":where_{$col}"] = $val;
        }
        $sql = "UPDATE `{$table}` SET " . implode(', ', $setClauses) .
               " WHERE " . implode(' AND ', $whereClauses);
        return $this->execute($sql, $params);
    }

    public function delete(string $table, array $where): int
    {
        $whereClauses = [];
        $params = [];
        foreach ($where as $col => $val) {
            $whereClauses[] = "`{$col}` = :{$col}";
            $params[":{$col}"] = $val;
        }
        $sql = "DELETE FROM `{$table}` WHERE " . implode(' AND ', $whereClauses);
        return $this->execute($sql, $params);
    }

    public function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }

    public function lastInsertId(?string $name = null): string
    {
        return $this->connect()->lastInsertId($name);
    }

    public function beginTransaction(): bool
    {
        return $this->connect()->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->connect()->commit();
    }

    public function rollBack(): bool
    {
        return $this->connect()->rollBack();
    }

    public function getPdo(): PDO
    {
        return $this->connect();
    }

    public function disconnect(): void
    {
        $this->pdo = null;
    }
}

