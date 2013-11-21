# Configure DocumentSearch

## Installation

DocumentSearch is installed like any other Contao extension. Please
referr to the Contao manual for this part.


## Setup

The configuration takes place in the Contao system settings. The core
settings ("Enable searching" and "Index protected pages") apply to
DocumentSearch too. So if you uncheck "Enable searching", DocumentSearch
will not work at all.

![Backend settings](images/settings.png?raw=true)


### Document extensions

You can enter a comma separated list of file extensions to be indexed.
Be aware that certain file types require special server tools to parse
the content (see below).

### Document locations

Locations are places where files can be found. This can be content elements
(type "Downloads" or "Download"), but it could also be news or events
(currently not supported by default). Check the locations that should be
searched for files that can be indexed.

### Document content sources

There are multiple places where the search keywords can be taken from.

1. **File content** tries to read the actual file content
2. **Keywords** is a custom field in the file manager. Edit a file and you
	can enter keywords for the search index.
3. **Meta title** takes the title for the page language from the file settings.
3. **File name** takes the raw file name for the search index.
4. **Link text** reads the link text and title from content elements of type "download".

Be aware that all content sources are combined if possible.


## Indexing

The search index is build using the maintenance module.


## Tools to extract documents

If you do not provide valid extraction tools, some document types are silently
ignored even if you enable them.

### PDF

PDF files cannot be read reliably using PHP. You need to install either
*pdftotext* (part of [Xpdf](http://www.foolabs.com/xpdf/download.html)) or *pdf2ascii* (part of [GhostScript](http://www.ghostscript.com)) and specify the path on your server.
You also need to have the [system](http://php.net/system) command available in PHP.
