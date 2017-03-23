<?php

require_once('database/Migration.php');
require_once('database/Table.php');
require_once('database/db.php');


// Include all migrations here and run migrate.php in cmd to migrate them
require_once('database/migrations/CommentTable.php');