#!/bin/bash

# Copyright (C) 2012  Cardscape project
# Web based collaborative platform for creating Collectible Card Games
# 
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
# 
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#

DBNAME=${1:-"cardscape"}
 
echo "DROP DATABASE IF EXISTS $DBNAME;"
echo "CREATE DATABASE $DBNAME;"
echo "USE $DBNAME;"
for file in *.sql; do 
    echo SOURCE "$file"; 
done;