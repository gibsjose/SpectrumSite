#!/usr/bin/env python
# -*- coding: UTF-8 -*-

import cgi
import cgitb; cgitb.enable()

#Get the info from the html <strong class="highlight">form</strong>
form = cgi.FieldStorage()

#Set up the HTMLs
reshtml = """Content-Type: text/html\n
<html>
<head><title>Generates Steering File</title></head>
<body>
"""
print reshtml

print "<H2>Python Test Form</H2>\n"
print "<HR><BR>\n"

# print '<meta http-equiv="refresh" content="0;url=../plot.html" />'

# Make sure to use cgi.escape to not be vulnerable to JavaScript injection attacks...
# Basically, without this, someone could type <script>...</script> with malicious JavaScript code
# into a text field and the code would execute.
steering = cgi.escape(form['steering'].value)

f = open('./tmp/test.txt', 'w')
f.write(steering)

print "Steering File Selected: <br>" + steering;

print '</body>'
print '</html>'
