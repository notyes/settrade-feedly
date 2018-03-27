<?php

class RSS{
    public $title;
    public $url;
    public $date;
    public $items;
    
    function generate(){

        header('Content-Type: text/xml; charset=utf-8', true);

        $rss = '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"
xmlns:content="http://purl.org/rss/1.0/modules/content/"
xmlns:wfw="http://wellformedweb.org/CommentAPI/"
xmlns:dc="http://purl.org/dc/elements/1.1/"
xmlns:atom="http://www.w3.org/2005/Atom"
xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
>
    <channel>
        <xhtml:meta content="noindex" name="robots" xmlns:xhtml="http://www.w3.org/1999/xhtml"></xhtml:meta>
        <title>' . $this->title . '</title>
        <link>' . $this->url . '</link>
        <atom:link href="http://www.acho.xyz/rss/" rel="self" type="application/rss+xml"/>
        <description>' . $this->description . '</description>
        <lastBuildDate>' . date('D, d M Y H:i:s O') . '</lastBuildDate>
        <language>en</language>';

        if( $this->items ){
            foreach( $this->items as $item ){
            
                $rss .= '
        <item>
            <title><![CDATA[' . $item['title'] . ']]></title>
            <link>' . $item['url'] . '</link>
            <pubDate>' . $item['date'] . '</pubDate>
            <content:encoded><![CDATA[<div><img height="123" src="'.$item['img'].'"/></div> ' . $item['description'] . ']]></content:encoded>
        </item>
                        ';
            
            }
        }
                
        $rss .= '
    </channel>
</rss>';
        
        return str_replace("\t",'', $rss);  
    }
}

?>
