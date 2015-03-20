#!/bin/sh

host="localhost"
db="ntg"
usr="root"
pwd="mysql"

echo "drop database if exists ntg; create database ntg DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;" | /usr/bin/mysql -uroot -pmysql
perl insert_author.pl $host $db $usr $pwd
perl insert_feat.pl $host $db $usr $pwd
perl insert_articles.pl $host $db $usr $pwd
