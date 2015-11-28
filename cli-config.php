<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Conf\DB\DBDoctrine;

DBDoctrine::configure();
$entityManager = DBDoctrine::em();

return ConsoleRunner::createHelperSet($entityManager);
