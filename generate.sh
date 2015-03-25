#!/bin/sh

host="localhost"
db="ntg"
usr="root"
pwd='mysql'

echo "CREATE DATABASE IF NOT EXISTS ntg CHARACTER SET utf8 COLLATE utf8_general_ci;" | /usr/bin/mysql -uroot -p$pwd
echo "CREATE TABLE IF NOT EXISTS details(name varchar(1000),email varchar(100),info varchar(5000),password varchar(100),interest varchar(2000),misc varchar(1000),isverified varchar(1),visitcount int(5), userid int(6) auto_increment, primary key(userid)) ENGINE=MyISAM;" | /usr/bin/mysql -uroot -p$pwd ntg
echo "CREATE TABLE IF NOT EXISTS reset (hash varchar(100), email varchar(100), name varchar(1000), password varchar(100), timestamp varchar(100), resetid int(6) AUTO_INCREMENT, PRIMARY KEY (resetid)) ENGINE=MyISAM;" | /usr/bin/mysql -uroot -p$pwd ntg

perl insert_author.pl $host $db $usr $pwd
perl insert_feat.pl $host $db $usr $pwd
perl insert_articles.pl $host $db $usr $pwd
perl ocr.pl $host $db $usr $pwd
perl searchtable.pl $host $db $usr $pwd
perl wordInsert.pl $host $db $usr $pwd
echo "create fulltext index text_index on searchtable (text);" | /usr/bin/mysql -uroot -p$pwd ntg
echo "create fulltext index word_index on word (word);" | /usr/bin/mysql -uroot -p$pwd ntg
