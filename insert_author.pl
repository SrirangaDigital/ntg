#!/usr/bin/perl

$host = $ARGV[0];
$db = $ARGV[1];
$usr = $ARGV[2];
$pwd = $ARGV[3];

use DBI();

open(IN,"ntg.xml") or die "can't open ntg.xml\n";

my $dbh=DBI->connect("DBI:mysql:database=$db;host=$host","$usr","$pwd");
$sth_enc=$dbh->prepare("set names utf8");
$sth_enc->execute();
$sth_enc->finish();

$sth11=$dbh->prepare("CREATE TABLE author(authorname varchar(400),fname varchar(200),lname varchar(200), authid int(6) auto_increment,  primary key(authid))auto_increment=10001 ENGINE=MyISAM character set utf8 collate utf8_general_ci;");
$sth11->execute();
$sth11->finish(); 

$line = <IN>;

while($line)
{

	if($line =~ /<author lname="(.*)" fname="(.*)">(.*)<\/author>/)
	{
		$lname = $1;
		$fname = $2;
		$authorname = $3;
		
		insert_authors($fname,$lname,$authorname);
	}
	$line = <IN>;
}

close(IN);
$dbh->disconnect();


sub insert_authors()
{
	my($fname,$lname,$authorname) = @_;

	$fname =~ s/'/\\'/g;
	$lname =~ s/'/\\'/g;
	$authorname =~ s/'/\\'/g;
	
	my($sth,$ref,$sth1);
	$sth = $dbh->prepare("select authid from author where authorname='$authorname' and fname='$fname' and lname='$lname'");
	$sth->execute();
	$ref=$sth->fetchrow_hashref();
	if($sth->rows()==0)
	{
		$sth1=$dbh->prepare("insert into author values('$authorname','$fname','$lname','')");
		$sth1->execute();
		$sth1->finish();
	}
	$sth->finish();	
}
