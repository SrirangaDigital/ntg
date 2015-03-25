#!/usr/bin/perl

$host = $ARGV[0];
$db = $ARGV[1];
$usr = $ARGV[2];
$pwd = $ARGV[3];

use DBI();
@ids=();

open(IN,"<:utf8","ntg.xml") or die "can't open ntg.xml\n";

my $dbh=DBI->connect("DBI:mysql:database=$db;host=$host","$usr","$pwd");
#~ $sth_enc=$dbh->prepare("set names utf8");
#~ $sth_enc->execute();
#~ $sth_enc->finish();

$sth_drop=$dbh->prepare("DROP TABLE IF EXISTS article");
$sth_drop->execute();
$sth_drop->finish();

#vnum, number, month, year, title, feature, authid, page, 

$sth11=$dbh->prepare("CREATE TABLE article(title varchar(500), 
authid varchar(200),
authorname varchar(1000),
featid varchar(100),
page varchar(5), 
page_end varchar(5), 
volume varchar(3),
issue varchar(10),
year varchar(10), 
month varchar(6),
titleid varchar(30), primary key(titleid)) ENGINE=MyISAM character set utf8 collate utf8_general_ci");
$sth11->execute();
$sth11->finish(); 

$line = <IN>;

$featid = '';
$authid = '';

while($line)
{
	if($line =~ /<volume vnum="(.*)">/)
	{
		$volume = $1;
		print $volume . "\n";
	}
	elsif($line =~ /<issue inum="(.*)" month="(.*)" year="(.*)">/)
	{
		$issue = $1;
		$month = $2;
		$year = $3;
		$count = 0;
		$prev_pages = "";		
	}	
	elsif($line =~ /<title>(.*)<\/title>/)
	{
		$title = $1;
	}
	elsif($line =~ /<feature>(.*)<\/feature>/)
	{
		$feature = $1;
		@feats = split(/;/, $feature);
		for($i=0;$i<@feats;$i++)
		{
			$featid = $featid . ";" . get_featid($feats[$i]);
		}
	}	
	elsif($line =~ /<page>(.*)<\/page>/)
	{
		$pages = $1;
		($page, $page_end) = split(/-/, $pages);
		if($pages eq $prev_pages)
		{
			$count++;
			$id = "id_" . $volume . "_" . $issue . "_" . $page . "_" . $page_end . "_" . $count; 
		}
		else
		{
			$id = "id_" . $volume . "_" . $issue . "_" . $page . "_" . $page_end . "_0";
			$count = 0;		
		}
		$prev_pages = $pages;		
	}	
	elsif($line =~ /<author lname="(.*)" fname="(.*)">(.*)<\/author>/)
	{
		$lname = $1;
		$fname = $2;
		$authorname = $3;
		$authids = $authids . ";" . get_authid($fname,$lname,$authorname);
		$author_name = $author_name . ";" .$authorname;
	}
	elsif($line =~ /<allauthors\/>/)
	{
		$authids = "0";
		$author_name = "";
		
	}
	elsif($line =~ /<\/entry>/)
	{
		insert_article($title,$authids,$author_name,$featid,$page,$page_end,$volume,$issue,$year,$month,$id);
		$authids = "";
		$featid = "";
		$author_name = "";
		$id = "";
	}
	$line = <IN>;
}

close(IN);
$dbh->disconnect();

sub insert_article()
{
	my($title,$authids,$author_name,$featid,$page,$page_end,$volume,$issue,$year,$month,$id) = @_;
	my($sth1);

	$title =~ s/'/\\'/g;
	$authids =~ s/^;//;
	$featid =~ s/^;//;
	$author_name =~ s/^;//;
	$author_name =~ s/'/\\'/g;
	
	$sth1=$dbh->prepare("insert into article values('$title','$authids','$author_name','$featid','$page','$page_end','$volume','$issue','$year','$month','$id')");

	$sth1->execute();
	$sth1->finish();
}

sub get_authid()
{
	my($fname,$lname,$authorname) = @_;
	my($sth,$ref,$authid);

	$fname =~ s/'/\\'/g;
	$lname =~ s/'/\\'/g;
	$authorname =~ s/'/\\'/g;
	
	$sth=$dbh->prepare("select authid from author where authorname='$authorname' and fname='$fname' and lname='$lname'");
	$sth->execute();
			
	my $ref = $sth->fetchrow_hashref();
	$authid = $ref->{'authid'};
	$sth->finish();
	return($authid);
}

sub get_featid()
{
	my($feature) = @_;
	my($sth,$ref,$featid);

	$feature =~ s/'/\\'/g;
	
	$sth=$dbh->prepare("select featid from feature where feat_name='$feature'");
	$sth->execute();
			
	my $ref = $sth->fetchrow_hashref();
	$featid = $ref->{'featid'};
	$sth->finish();
	return($featid);
}

