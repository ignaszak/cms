<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Conf\DB\DBDoctrine;

$entityManager = DBDoctrine::em();

return ConsoleRunner::createHelperSet($entityManager);
