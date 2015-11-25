<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Conf\DB\DBDoctrine;

DBDoctrine::configure();
$entityManager = DBDoctrine::getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
