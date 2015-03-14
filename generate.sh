#!/bin/sh

host="localhost"
db="ntg"
usr="root"
pwd="mysql"

echo "drop database ntg; create database ntg;" | /usr/bin/mysql -uroot -pmysql
perl insert_author.pl $host $db $usr $pwd
perl insert_feat.pl $host $db $usr $pwd
perl insert_articles.pl $host $db $usr $pwd
