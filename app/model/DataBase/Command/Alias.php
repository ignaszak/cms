<?php
namespace DataBase\Command;

use Conf\DB\DBDoctrine;

class Alias
{

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em = null;

    /**
     *
     * @var Entity
     */
    private $entity = null;

    /**
     *
     * @var string
     */
    private $entityName = '';

    /**
     *
     * @param Entity $entity
     * @throws \DomainException
     */
    public function __construct($entity)
    {
        if (! is_object($entity)) {
            throw new \DomainException(
                'Second argument passed to ' . __CLASS__ .
                '::aliasNotExistsInDB() must be an Entity instance'
            );
        } else {
            $this->em = DBDoctrine::em();
            $this->entity = $entity;
            $this->entityName = get_class($entity);
        }
    }

    /**
     *
     * @param string $string
     * @return string
     */
    public function getAlias(string $string): string
    {
        if (empty($this->entity->getAlias())) {
            $alias = $this->createAliasFromString($string);
            return $this->renameAliasIfExistsInDB($alias);
        } else {
            return $this->entity->getAlias();
        }
    }

    /**
     *
     * @param string $alias
     * @return string
     */
    private function renameAliasIfExistsInDB(string $alias): string
    {
        if ($this->isAliasNotExistsInDB($alias)) {
            return $alias;
        } else {
            $rename = "$alias-" . rand(1, 20);
            return $this->renameAliasIfExistsInDB($rename);
        }
    }

    /**
     *
     * @param string $string
     * @return string
     */
    private function createAliasFromString(string $string): string
    {
        $clean = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $string);
        $clean = preg_replace('/[^a-z\d ]/i', '', $clean);
        $clean = preg_replace('/\s\s+/', ' ', $clean);
        $clean = str_replace(' ', '-', $clean);
        return substr(strtolower($clean), 0, 100);
    }

    /**
     *
     * @param string $alias
     * @param Entity $entity
     * @return boolean
     */
    private function isAliasNotExistsInDB(string $alias): bool
    {
        $query = $this->em->getRepository($this->entityName)->findBy([
            'alias' => $alias
        ]);
        return count($query) ? false : true;
    }
}
