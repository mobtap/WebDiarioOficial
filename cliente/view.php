<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>PDFObject Example: Full-browser embed (no selector specified)</title>
<!-- site analytics, unrelated to any example code presented on this page -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-1394306-6"></script>
<script src="../js/analytics.js"></script><!-- /site analytics -->
<!--
	This example created for PDFObject.com by Philip Hutchison (www.pipwerks.com)
	Copyright 2016-2020, MIT-style license http://pipwerks.mit-license.org/
	Documentation available at http://pdfobject.com
	Source code available at https://github.com/pipwerks/PDFObject
-->

<!-- CSS for basic page styling, not related to example -->
<link href="../css/examples.css" rel="stylesheet" />
</head>

<body>
<h1>PDFObject Example: Full-browser embed (no selector specified)</h1>
<p>This example uses one line of JavaScript.</p>

<div class="pdfobject-com"><a href="http://pdfobject.com">PDFObject.com</a></div>

<script src="https://unpkg.com/pdfobject@2.2.4/pdfobject.min.js"></script>
<script>
PDFObject.embed("dilee.pdf");
</script>