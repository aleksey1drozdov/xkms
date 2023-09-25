#!/bin/bash
set -e

clickhouse client -n <<-EOSQL
  set allow_experimental_database_materialized_mysql = 1;

  CREATE DATABASE IF NOT EXISTS mysql ENGINE = MaterializedMySQL('db:3306', 'x', 'click', 'click')
      SETTINGS
          allows_query_when_mysql_lost=true,
          max_wait_time_when_mysql_unavailable=10000;
EOSQL