<?php

namespace App\Conf;

use Conf\DB\DBSettings;

class Configuration
{

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $requestUrl;

    /**
     * @param string $siteAdress
     */
    public function setAdress(string $siteAdress)
    {
        $siteAdress = substr($siteAdress, -1) == "/" ?
            substr($siteAdress, 0, -1) : $siteAdress;
        $array = explode('/', $siteAdress);
        $this->baseUrl = $array[0] . '//' . $array[2] . '/';
        unset($array[0]);
        unset($array[1]);
        unset($array[2]);
        $this->requestUrl = '/' . implode('/', $array);
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return string
     */
    public function getRequestUrl(): string
    {
        return $this->requestUrl;
    }

    public function createDataBase()
    {
        $conn = new \PDO(
            'mysql:host=' . DBSettings::DB_HOST . ';dbname=' . DBSettings::DB_NAME,
            DBSettings::DB_USER,
            DBSettings::DB_PASSWORD
        );
        $this->executeSqlFile($conn, __DIR__ . '/cache/tmp/tmp_structure.sql');
        $this->executeSqlFile($conn, __DIR__ . '/cache/tmp/tmp_data.sql');
    }

    /**
     * @param \PDO $conn
     * @param string $file
     */
    private function executeSqlFile(\PDO $conn, string $file)
    {
        $sql = file_get_contents($file);
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        do {// Required due to "MySQL has gone away!" issue
            $stmt->fetch();
            $stmt->closeCursor();
        } while ($stmt->nextRowset());
    }

}
