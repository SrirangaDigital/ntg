#!/usr/bin/perl

$host = $ARGV[0];
$db = $ARGV[1];
$usr = $ARGV[2];
$pwd = $ARGV[3];

use DBI();

open(IN,"ntg.xml") or die "can't open ntg.xml\n";

my $dbh=DBI->connect("DBI:mysql:database=$db;host=$host","$usr","$pwd");
#~ $sth_enc=$dbh->prepare("set names utf8");
#~ $sth_enc->execute();
#~ $sth_enc->finish();

$sth_drop=$dbh->prepare("DROP TABLE IF EXISTS feature;");
$sth_drop->execute();
$sth_drop->finish();

$sth11=$dbh->prepare("CREATE TABLE feature(feat_name varchar(500), featid int(6) auto_increment, primary key(featid))auto_increment=10001 ENGINE=MyISAM character set utf8 collate utf8_general_ci;");
$sth11->execute();
$sth11->finish(); 

$line = <IN>;

while($line)
{

	if($line =~ /<feature>(.*)<\/feature>/)
	{
		$feat_name = $1;

		@feats = split(/;/, $feat_name);

		for($i=0;$i<@feats;$i++)
		{
			insert_feature($feats[$i]);
		}
	}
	$line = <IN>;
}

close(IN);
$dbh->disconnect();


sub insert_feature()
{
	my($feat_name) = @_;

	$feat_name =~ s/'/\\'/g;
	
	my($sth,$ref,$sth1);
	$sth = $dbh->prepare("select featid from feature where feat_name='$feat_name'");
	$sth->execute();
	$ref=$sth->fetchrow_hashref();
	if($sth->rows()==0)
	{
		$sth1=$dbh->prepare("insert into feature values('$feat_name',null)");
		$sth1->execute();
		$sth1->finish();
	}
	$sth->finish();	
}
