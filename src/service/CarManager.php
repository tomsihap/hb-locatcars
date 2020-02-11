<?php
namespace App\Service;

use App\Model\Car;
use PDO;

class CarManager {

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return Car[]
     */
    public function findAll()
    {
        $query = "SELECT * FROM car";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    /**
     * @param int $id
     * @return Car
     */
    public function findOneById(int $id)
    {
    }

    /**
     * @param string $field
     * @param string $value
     * @return Car[]
     */
    public function findByField(string $field, string $value)
    {
    }
}