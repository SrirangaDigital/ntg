#!/usr/bin/perl

$host = $ARGV[0];
$db = $ARGV[1];
$usr = $ARGV[2];
$pwd = $ARGV[3];

print "Test OCR\n";

use DBI();

my $dbh=DBI->connect("DBI:mysql:database=$db;host=$host","$usr","$pwd");
$sth_enc=$dbh->prepare("set names utf8");
$sth_enc->execute();
$sth_enc->finish();

$sth11=$dbh->prepare("drop table if exists testocr");
$sth11->execute();
$sth11->finish(); 

$sth11=$dbh->prepare("CREATE TABLE testocr(issue varchar(5),
cur_page varchar(10),
text varchar(5000)) ENGINE=MyISAM character set utf8 collate utf8_general_ci");
$sth11->execute();
$sth11->finish(); 
@issue = `ls Text`;

for($i1=0;$i1<@issue;$i1++)
{
	print $issue[$i1];
	chop($issue[$i1]);
	@files = `ls Text/$issue[$i1]/`;

	for($i3=0;$i3<@files;$i3++)
	{
		chop($files[$i3]);
		if($files[$i3] =~ /\.txt/)
		{
			$inum = $issue[$i1];
			$cur_page = $files[$i3];
			open(DATA,"<:utf8","Text/$inum/$cur_page")or die ("cannot open Text/$inum/$cur_page");
			
			local $/;
			$content = <DATA>;
			$cur_page =~ s/\.txt//g;
			
			$line=<DATA>;
			$content =~ s/\\/\//g;
			$content =~ s/'/\\'/g;
			$content =~ s/\"/\\"/g;
			$content =~ s/\n/ /g;
			$content =~ s///g;
			$content =~ s///g;
			$content =~ s///g;
			$content =~ s/^\s+|\s+$//g;
			$sth1=$dbh->prepare("insert into testocr values ('$inum','$cur_page','$content')");
			$sth1->execute()  or die("issue $inum Page $cur_page");
			$sth1->finish();
			close(DATA);
		}
	}
}

