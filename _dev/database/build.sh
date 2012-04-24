#!/bin/bash

DBNAME=${1:-"cardscape"}
 
echo "DROP DATABASE IF EXISTS $DBNAME;"
echo "CREATE DATABASE $DBNAME;"
echo "USE $DBNAME;"
for file in *.sql; do 
    echo SOURCE "$file"; 
done;