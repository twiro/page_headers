# Custom Page Headers Symphony Extension

- Version: 1.0
- Author: Henry Singleton
- Build Date: 11 Apr 2012
- Requirements: Symphony 2.2.x

## Overview

This Symphony CMS extension allows you to define headers by page output. This lets you build headers using data from datasources or other page information. Anything that's accessible from a standard page really!

Great for generating redirect urls for 301/302 redirects if you need information from existing symphony entries, or want to store redirect stats via an event etc. 

## Installation

1. Upload the 'page_headers' folder in this archive to your Symphony 'extensions' folder.

2. Enable it by selecting the "Page Headers" extension, choose Enable from the with-selected menu, then click Apply.

## Usage

- Create a new page, and give it a page type of 'headers'.
- Make the page output plain text that you want for your headers. If you also want to output actual page content in the message body, simply follow  

## Notes

If html is detected during output, headers will not be generated as they would likely be invalid. 
Note that the actual page content is not output, as the script is killed as soon as all the output lines have been sent as headers. 

## Example

Create a new page, give it a page type of 'headers' and save the following as the page template content:

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

## Changelog

- **1.0** Initial release for internal project.
