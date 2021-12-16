<?php

require __DIR__ . '/database/database.php';
$articleDB = require_once __DIR__ . '/database/models/ArticleDB.php';

$articles = $articleDB->fetchAll();

echo json_encode($articles);
