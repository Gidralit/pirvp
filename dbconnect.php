<?php

trait SingletonTrait
{
    protected static $instance;

    public static function getInstance(): self
    {
        if (empty(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    protected function __construct() {}
}

class Database
{
    use SingletonTrait;

    private PDO $pdo;

    protected function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=urnrfyet_m1';
        $user = 'urnrfyet';
        $password = 'u41FZt';

        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->initializeDatabase();
        } catch(PDOException $e) {
            die('Ошибка подключения к БД: ' . $e->getMessage());
        }
    }

    private function initializeDatabase(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(30) NOT NULL UNIQUE,
                name VARCHAR(30) NOT NULL,
                password_hash VARCHAR(255) NOT NULL
            );

            CREATE TABLE IF NOT EXISTS notes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                title VARCHAR(100) NOT NULL,
                content TEXT NOT NULL,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );

            CREATE TABLE IF NOT EXISTS shedule(
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                event_date DATE NOT NULL,
                event_time TIME,
                title VARCHAR(100) NOT NULL,
                description TEXT,
                FOREIGN KEY (user_id) REFERENCES users(id)
            );
        ";

        $this->pdo->exec($sql);
    }

    public static function insert(string $table_name, array $data): void
    {
        $instance = self::getInstance();
        $keys = array_keys($data);
        $fields = implode(', ', $keys);
        $safeFields = implode(', ', array_map(fn($item) => ":$item", $keys));

        $stmt = $instance->pdo->prepare("INSERT INTO $table_name ($fields) VALUES($safeFields)");
        $stmt->execute($data);
    }



    public static function pdo(): PDO
    {
        return self::getInstance()->pdo;
    }
}