# Custom Page Headers Symphony Extension

This extension for [Symphony CMS][1] allows you to define headers by page output. This lets you build headers using data from datasources or other page information. Anything that's accessible from a standard page really!

Great for generating redirect urls for 301/302 redirects if you need information from existing Symphony entries, or want to store redirect stats via an event etc. 

## Installation

1. Upload the `page_headers` folder in this archive to your Symphony `extensions` folder.
2. Go to **System > Extensions** in your Symphony admin area.
3. Enable the extension by selecting the '**Page Headers**', choose '**Enable**' from the '**With Selected…**' menu, then click '**Apply**'.

## Usage

- Create a new page, and give it a page type of `headers`.
- Make the page output plain text that you want for your headers. If you also want to output actual page content in the message body, simply separate your headers by a blank newline (as per the HTTP spec for separating message headers/body).

_**Note:** If HTML/XML is detected at the start of the page output, the extension will not do anything, even if the 'headers' page type is set._

## Example

Create a new page, give it a page type of `headers` and save the following as the page template content:

    <?xml version="1.0" encoding="UTF-8"?>
    <xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    
        <xsl:output method="xml"
        omit-xml-declaration="yes"
        encoding="UTF-8"
        indent="yes" />
        
        <xsl:template match="/">
            HTTP/1.1 301 Moved Permanently
            Location: http://www.google.com/
        </xsl:template>
        
    </xsl:stylesheet>

Here is an example of custom `404` page, implemented in a different way. Note that you'll need to ensure there are two empty lines
between your headers and any page content you want to output (as per the HTTP spec).

    <?xml version="1.0" encoding="UTF-8"?>
    <xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
        
        <xsl:output method="xml"
        omit-xml-declaration="yes"
        encoding="UTF-8"
        indent="yes" />
        
        <xsl:template match="/">
            <xsl:text>
                HTTP/1.0 404 Not Found
                
            </xsl:text>
            
            <h1>Page not found</h1>
            <p>Try our homepage</p>
        </xsl:template>
    </xsl:stylesheet>


[1]: https://www.getsymphony.com/