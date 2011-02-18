<?php
/*
Plugin Name: RSS Pages For Wordpress
Plugin URI: http://programming.has.no.com/2008/05/14/wordpress-rss-pages-plugin/
Description: Display wordpress pages in a rss feed
Author: Programming.has.no.com
Version: 1.4
Author URI: http://programming.has.no.com/
*/

function feed_rss2_pages($comments = "") {
	header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
	$more = 0;
	echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	>
<channel>
	<title><?php bloginfo_rss('name'); wp_title_rss(); ?></title>
	<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss("description") ?></description>
	<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></pubDate>
	<generator>http://programming.has.no.com/2008/05/14/wordpress-rss-pages-plugin/</generator>
	<language><?php echo get_option('rss_language'); ?></language>
	<?php do_action('rss2_head'); ?>
</channel>

<?php
	$p = wp_list_pages('title_li=&sort_column=post_modified&show_date=modified&echo=0');
	preg_match_all('/href="(.+)" title="(.+)">.+<\/a>(.+)<\/li>/U', $p, $matches);
	$c = count($matches[1]);
	for($i = $c; $i >= 0; $i--){
		if($matches[1][$i] != ""){
			echo "<item>";
			echo "<title>";
			echo $matches[2][$i];
			echo "</title>";

			echo "<link>";
			echo $matches[1][$i];
			echo "</link>";

			echo '<guid isPermaLink="false">';
			echo $matches[1][$i];
			echo '</guid>';
			echo "<pubDate>";
				$tm=date("D, d M Y H:i:s",mktime($matches[3][$i]));
				$tm=$tm. " GMT";
				echo $tm;
			echo "</pubDate>";
			echo "<description><![CDATA[Please Visit <a href='".$matches[1][$i]."'>".$matches[2][$i]."</a> for the full update]]></description>";
			echo "<content:encoded><![CDATA[".$matches[2][$i]. "]]></content:encoded>";
			echo "</item>\n";
		}
	}
?>
</rss>
<?
}

function feed_rss_pages($comments = ""){
	header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
	$more = 1;
	echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
	?>
	<!-- generator="http://programming.has.no.com/2008/05/14/wordpress-rss-pages-plugin/" -->
<rss version="0.92">
<channel>
        <title><?php bloginfo_rss('name'); wp_title_rss(); ?></title>
        <link><?php bloginfo_rss('url') ?></link>
        <description><?php bloginfo_rss('description') ?></description>
        <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
        <docs>http://backend.userland.com/rss092</docs>
        <language><?php echo get_option('rss_language'); ?></language>
        <?php do_action('rss_head'); ?>
	<?php
	$p = wp_list_pages('title_li=&sort_column=post_modified&show_date=modified&echo=0');
	preg_match_all('/href="(.+)" title="(.+)">.+<\/a>(.+)<\/li>/U', $p, $matches);
	$c = count($matches[1]);
	for($i = $c; $i >= 0; $i--){
		if($matches[1][$i] != ""){
        		echo "<item>";
			echo "<title>";
			echo $matches[2][$i];
			echo "</title>";
			echo "<description><![CDATA[Please Visit <a href='".$matches[1][$i]."'>".$matches[2][$i]."</a> for the full update]]></description>";
			echo "<link>";
			echo $matches[1][$i];
			echo "</link>";
                	do_action('rss_item');
			echo "</item>";
		}
	}
	?>
	</channel>
	</rss>
<?php
}


function feed_atom_pages($comments = ""){
	header('Content-Type: application/atom+xml; charset=' . get_option('blog_charset'), true);
	$more = 1;
	echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>
<feed
  xmlns="http://www.w3.org/2005/Atom"
  xmlns:thr="http://purl.org/syndication/thread/1.0"
  xml:lang="<?php echo get_option('rss_language'); ?>"
  xml:base="<?php bloginfo_rss('home') ?>/?feed=atom"
  <?php do_action('atom_ns'); ?>
 >
        <title type="text"><?php bloginfo_rss('name'); wp_title_rss(); ?></title>
        <subtitle type="text"><?php bloginfo_rss("description") ?></subtitle>

        <updated><?php echo mysql2date('Y-m-d\TH:i:s\Z', get_lastpostmodified('GMT')); ?></updated>
        <generator>http://programming.has.no.com/2008/05/14/wordpress-rss-pages-plugin/</generator>

        <link rel="alternate" type="text/html" href="<?php bloginfo_rss('home') ?>" />
	<id><?php bloginfo_rss('home');?>/?feed=atom_pages</id>
        <link rel="self" type="application/atom+xml" href="<?php self_link(); ?>" />

        <?php do_action('atom_head'); ?>
	<?php
	$p = wp_list_pages("title_li=&sort_column=post_modified&show_date=modified&echo=0&date_format=H\:i\:s d/F/Y");
	$q = wp_list_pages("title_li=&sort_column=post_modified&show_date=created&echo=0&date_format=H\:i\:s d/F/Y");
	preg_match_all('/href="(.+)" title="(.+)">.+<\/a>(.+)<\/li>/U', $p, $matches);
	preg_match_all('/href="(.+)" title="(.+)">.+<\/a>(.+)<\/li>/U', $q, $matchesa);
	$c = count($matches[1]);
	for($i = $c; $i >= 0; $i--){
		if($matches[1][$i] != ""){
        		echo "<entry>";
		        echo "<author>";
                        echo "<name>";
			bloginfo_rss('name');
			echo "</name>";
                        echo "<uri>";
			bloginfo_rss('home');
			echo "</uri>";
	                echo "</author>";
			?>
	                <title type="<?php html_type_rss(); ?>"><![CDATA[<?php echo $matches[2][$i]; ?>]]></title>
        	        <link rel="alternate" type="text/html" href="<?php echo $matches[1][$i]; ?>" />
                	<id><?php echo $matches[1][$i]; ?></id>
	                <updated><?php echo date("Y-m-d\TH:i:s\Z", mktime($matches[3][$i])); ?></updated>
	                <published><?php echo date("Y-m-d\TH:i:s\Z", mktime($matchesa[3][$i])); ?></published>
                	<?php the_category_rss('atom') ?>
	                <summary type="<?php html_type_rss(); ?>"><![CDATA[Please Visit <a href='<?php echo $matches[1][$i];?>'><?php echo $matches[2][$i];?></a> for the full update]]></summary>
        	        <content type="<?php html_type_rss(); ?>" xml:base="<?php echo $matches[1][$i]; ?>"><![CDATA[Please Visit <a href='<?php echo $matches[1][$i];?>'><?php echo $matches[2][$i];?></a> for the full update]]></content>
			<?php do_action('atom_entry'); ?>
		        </entry>
			<?php
		}
	}?>
</feed>
<?php
}


function add_rss_pages() {
add_feed('atom','feed_atom_pages');
add_feed('rss2','feed_rss2_pages');
add_feed('rss','feed_rss_pages');
}
add_action('init','add_rss_pages');
?>
