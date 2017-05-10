<?php

namespace Kanboard\Plugin\Metadata\Schema;

use PDO;

const VERSION = 1;

function version_1(PDO $pdo)
{
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS metadata_types (
          id INTEGER PRIMARY KEY,
          human_name VARCHAR(255) NOT NULL,
          machine_name VARCHAR(255) NOT NULL,
          data_type VARCHAR(50) NOT NULL,
          is_required BOOLEAN DEFAULT 0,
          attached_to VARCHAR(50) NOT NULL,
          UNIQUE(machine_name, attached_to)
        )
    ');

    $pdo->exec('
        CREATE TABLE IF NOT EXISTS metadata_has_type (
          id INTEGER PRIMARY KEY,
          type_id INTEGER NOT NULL,
          metadata_id INTEGER NOT NULL,
          FOREIGN KEY(type_id) REFERENCES metadata_types(id) ON DELETE CASCADE
        )
    ');
}
