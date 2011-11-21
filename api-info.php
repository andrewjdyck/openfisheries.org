<?php

?>
<html>
<head>
<title>OpenFisheries.org</title>
<script type="text/javascript" src="./js/protovis.min.js"></script>
<script type="text/javascript" src="./js/global_data.js"></script>
<meta name="description" content="A platform for aggregating global fishery data, disseminating this data to researchers through open APIs and pushing the boundaries of fisheries research." /> 
<meta name="keywords" content="fisheries, economics, opendata, data, open, API, platform" /> 
<link rel="canonical" href="http://openfisheries.org/" /> 
<link rel="stylesheet" type="text/css" href="./style.css" />
</head>

<body>

<div id="container">

<div id="header">
<img src="./img/betaLogo.png" id="logo" />
<ul id="head-menu">
<li><a href="./">Home</a></li>
<li><a href="./about">About</a></li>
<li><a href="./api-info">API</a></li>
<li><a href="http://blog.openfisheries.org/">Blog</a></li>
<li><a href="./contact">Contact</a></li>
</ul>
</div>
<div id="main">

<div id="main-text" style="padding-top:80px;padding-bottom:20px;">
The Advanced Programming Interface (API) is experimental, but I welcome you to take a shot at breaking it (not too hard please) and let me know what could work better. Use the details on the contact page to get in touch.
<br /><br />
<h2>How it works</h2>
The API supports GET requests for annual fishery landings data at the following url:
<br /><br />
<a href="http://openfisheries.org/api/landings">http://openfisheries.org/api/landings</a>
<br /><br />
and produces a valid JSON document. There are parsers for nearly every programming language for reading JSON documents including for the <a href="http://cran.r-project.org/web/packages/RJSONIO/index.html">R-project</a> and <a href="http://docs.python.org/library/json.html">Python</a>.
<br /><br />
<h3>API parameters</h3>
In addition to global aggregate landings, one can download landings by country by adding a <a href="http://en.wikipedia.org/wiki/ISO_3166-1_alpha-3">ISO-3166 alpha 3 country code</a>. For example, to download landings from 1950 to present for Canada:
<br /><br />
<a href="http://openfisheries.org/api/landings?iso3c=CAN">http://openfisheries.org/api/landings?iso3c=CAN</a>
<br /><br />
You can also download landings by <a href="http://www.fao.org/fishery/collection/asfis/en">ASFIS species code</a>, FAO statistical area and marine/inland species only. Documentation on these parameters is forthcoming. Until then, feel free to <a href="./contact">contact me</a> for more info about these items.

</div>

</div>





<div id="footer">
<ul>
<h3>Contact</h3>
<li><a href="http://www.twitter.com/openfisheries.org">@openfisheries</a></li>
<li><a href="mailto:openfisheries@gmail.com">openfisheries [at] gmail [dot] com</a></li>
<li><a href="https://github.com/andrewjdyck/openfisheries.org">Fork on Github</a></li>
</ul>


<!-- Google Analytics code -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17319162-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</div>

</div>

</body>

</html>
