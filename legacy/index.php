<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>QA catalogue for analysing library data</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <!-- script src="//use.fontawesome.com/feff23b961.js"></script -->
  <script src="feff23b961.js"></script>
  <script src="//code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="metadata-qa.css">
  <script type="text/javascript">

    var db = 'metadata-qa';
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('db')) {
      db = urlParams.get('db');
    } else {
      db = window.location.pathname.replace(/\//g, '');
    }
    var marcBaseUrl = 'https://www.loc.gov/marc/bibliographic/';
    var solrProxy = 'solr-proxy.php';
    var solrDisplay = 'solr-display.php';

    function showMarcUrl(link) {
      return marcBaseUrl + link;
    }
  </script>
  <script src="configuration.js" type="text/javascript"></script>
  <script src="loadFacets.php" type="text/javascript"></script>
  <script src="https://d3js.org/d3.v5.min.js"></script>
</head>
<body>
<div class="container">
  <!-- Content here -->
  <h1><i class="fa fa-cogs" aria-hidden="true"></i> QA catalogue <span>for analysing library data</span></h1>
  <p>
    <i class="fa fa-book" aria-hidden="true"></i>
    <script type="text/javascript">
      var cat = db;
      if (db == 'metadata-qa' && typeof catalogue !== "undefined")
        cat = catalogue;

      if (cat == 'szte') {
        document.write('<a href="http://www.ek.szte.hu/" target="_blank">A Szegedi Tudományegyetem Klebelsberg Kuno Könyvtára</a>');
      } else if (cat == 'mokka') {
        document.write('<a href="http://mokka.hu/" target="_blank">mokka &mdash; Magyar Országos Közös Katalógus</a>');
      } else if (cat == 'cerl') {
        document.write('<a href="https://www.cerl.org/resources/hpb/main/" target="_blank">The Heritage of the Printed Book Database</a>');
      } else if (cat == 'dnb') {
        document.write('<a href="https://www.dnb.de/" target="_blank">Deutsche Nationalbibliothek</a>');
      } else if (cat == 'gent') {
        document.write('<a href="https://lib.ugent.be/" target="_blank">Universiteitsbibliotheek Gent</a>');
      } else if (cat == 'loc') {
        document.write('<a href="https://catalog.loc.gov/" target="_blank">Library of Congress</a>');
      } else if (cat == 'mtak') {
        document.write('<a href="https://mtak.hu/" target="_blank">Magyar Tudományos Akadémia Könyvtára</a>');
      } else if (cat == 'bayern') {
        document.write('<a href="https://www.bib-bvb.de/" target="_blank">Verbundkatalog B3Kat des Bibliotheksverbundes Bayern (BVB) und des Kooperativen Bibliotheksverbundes Berlin-Brandenburg (KOBV)</a>');
      } else if (cat == 'bnpl') {
        document.write('<a href="https://bn.org.pl/" target="_blank">Biblioteka Narodowa (Polish National Library)</a>');
      } else if (cat == 'nfi') {
        document.write('<a href="https://www.kansalliskirjasto.fi/en" target="_blank">Kansallis Kirjasto/National Biblioteket (The National Library of Finnland)</a>');
      } else if (cat == 'gbv') {
        document.write('<a href="http://www.gbv.de/" target="_blank">Verbundzentrale des Gemeinsamen Bibliotheksverbundes</a>');
      }
    </script>
  </p>

  <!-- Nav tabs -->
  <nav>
  <ul class="nav nav-tabs" id="myTab">
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="data-tab" href="#data" aria-controls="data">Data</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" role="tab" aria-selected="true"
         id="completeness-tab" href="#completeness" aria-controls="completeness">Completeness</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="issues-tab" href="#issues" aria-controls="issues">Issues</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="functions-tab" href="#functions" aria-controls="functions">
        Functions
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="classifications-tab" href="#classifications" aria-controls="classifications">
        Subjects
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="authorities-tab" href="#authorities" aria-controls="authorities">
        Authorities
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="serials-tab" href="#serials" aria-controls="serials">
        Serials
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="tt-completeness-tab" href="#tt-completeness" aria-controls="tt-completeness">
        T&mdash;T completeness
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
        id="terms-tab" href="#terms" aria-controls="terms">
        Terms
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="pareto-tab" href="#pareto" aria-controls="pareto">
        Pareto
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="settings-tab" href="#settings" aria-controls="settings">Settings</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" role="tab" aria-selected="false"
         id="about-tab" href="#about" aria-controls="about">About</a>
    </li>
  </ul>
  </nav>

  <!-- Tab panes -->
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane" id="data" role="tabpanel" aria-labelledby="data-tab">
      <div class="container" id="content">
        <div class="row">
          <div id="left" class="col-3">
            <div class="search-block">
              <h3>Search</h3>
              <form id="search">
                <input type="text" name="query" id="query" value="*:*">
                <i class="fa fa-search" aria-hidden="true"></i>
              </form>
            </div>
            <div id="filters" class="filter-block">
              <h3>Filters</h3>
              <div id="filter-list"></div>
            </div>

            <div id="facets" class="facet-block">
              <h3>Facets</h3>
              <div id="facet-list"></div>
            </div>
          </div>
          <div id="main" class="col">
            <div class="row">
              <div class="col-8">
                Found <span id="numFound"></span> records
              </div>
              <div class="col-4" id="message"></div>
            </div>

            <div class="row" id="navigation">
              <div class="col-8" id="prev-next"></div>
              <div class="col-4" id="per-page">
                <span class="label">Items per page:</span>
                <span id="items-per-page"></span>
              </div>
            </div>

            <div id="records"></div>

            <div class="row" id="navigation-footer">
              <div class="col-8" id="prev-next-footer"></div>
              <div class="col-4"></div>
            </div>
            <div id="solr-url"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane active" id="completeness" role="tabpanel"
         aria-labelledby="completeness-tab">
      <h2>Completeness of MARC21 field groups</h2>
      <div id="completeness-group-table"></div>
      <h2>Completeness of MARC21 fields</h2>
      <div id="completeness-field-table"></div>
    </div>
    <div class="tab-pane" id="issues" role="tabpanel" aria-labelledby="issues-tab">
      <h2>Issues in MARC21 records</h2>
      <div id="issues-table-placeholder"></div>
    </div>
    <div class="tab-pane" id="functions" role="tabpanel" aria-labelledby="functions-tab">
      <h2>Functional analysis</h2>

      <div class="row"><label>Discovery functions</label></div>
      <div class="row">
        <div class="col-3">
          <svg id="bar-chart-discoverysearch" class="bar-chart"></svg>
          <p class="title">Search</p>
          <p class="explanation">Search for a resource corresponding to stated criteria (i.e., to search either a
            single entity or a set of entities using an attribute or relationship of the entity as the search criteria).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-discoveryidentify" class="bar-chart"></svg>
          <p class="title">Identify</p>
          <p class="explanation">Identify a resource (i.e., to confirm that the entity described or located corresponds
            to the entity sought, or to distinguish between two or more entities with similar characteristics).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-discoveryselect" class="bar-chart"></svg>
          <p class="title">Select</p>
          <p class="explanation">Select a resource that is appropriate to the user’s needs (i.e., to choose an entity
            that meets the user’s requirements with respect to content, physical format, etc., or to reject an entity
            as being inappropriate to the user’s needs).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-discoveryobtain" class="bar-chart"></svg>
          <p class="title">Obtain</p>
          <p class="explanation">Access a resource either physically or electronically through an online connection to
            a remote computer, and/or acquire a resource through purchase, licence, loan, etc.</p>
        </div>
      </div>
      <div class="row"><label>Usage functions</label></div>
      <div class="row">
        <div class="col-3">
          <svg id="bar-chart-userestrict" class="bar-chart"></svg>
          <p class="title">Restrict</p>
          <p class="explanation">Control access to or use of a resource (i.e., to restrict access to and/or use of an
            entity on the basis of proprietary rights, administrative policy, etc.).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-usemanage" class="bar-chart"></svg>
          <p class="title">Manage</p>
          <p class="explanation">Manage a resource in the course of acquisition, circulation, preservation, etc.</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-useoperate" class="bar-chart"></svg>
          <p class="title">Operate</p>
          <p class="explanation">Operate a resource (i.e., to open, display, play, activate, run, etc. an entity that
            requires specialized equipment, software, etc. for its operation).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-useinterpret" class="bar-chart"></svg>
          <p class="title">Interpret</p>
          <p class="explanation">Interpret or assess the information contained in a resource.</p>
        </div>
      </div>
      <div class="row"><label>Management functions</label></div>
      <div class="row">
        <div class="col-3">
          <svg id="bar-chart-managementidentify" class="bar-chart"></svg>
          <p class="title">Identify</p>
          <p class="explanation">Identify a record, segment, field, or data element (i.e., to differentiate one logical
            data component from another).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-managementprocess" class="bar-chart"></svg>
          <p class="title">Process</p>
          <p class="explanation">Process a record, segment, field, or data element (i.e., to add, delete, replace,
            output, etc. a logical data component by means of an automated process).</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-managementsort" class="bar-chart"></svg>
          <p class="title">Sort</p>
          <p class="explanation">Sort a field for purposes of alphabetic or numeric arrangement.</p>
        </div>
        <div class="col-3">
          <svg id="bar-chart-managementdisplay" class="bar-chart"></svg>
          <p class="title">Display</p>
          <p class="explanation">Display a field or data element (i.e., to display a field or data element with the
            appropriate print constant or as a tracing).</p>
        </div>
      </div>

      <p>The Funtional Requirements for Bibliographic Records (FRBR) document's main part defines the primary and
        secondary entities which became famous as FRBR models. Years later Tom Delsey created a mapping
        between the 12 functions and the individual MARC elements.</p>

      <blockquote>
        Tom Delsey (2002)
        <em>Functional analysis of the MARC 21 bibliographic and holdings formats.</em> Tech. report,
        Library of Congress, 2002. Prepared for the Network Development and MARC Standards Office Library of Congress.
        Second Revision: September 17, 2003.
        <a href="https://www.loc.gov/marc/marc-functional-analysis/original_source/analysis.pdf"
           target="_blank">https://www.loc.gov/marc/marc-functional-analysis/original_source/analysis.pdf</a>.
      </blockquote>

      <p>This page shows how these functions are supported by the records. The horizontal axis show the strength of
        the support: something on the left means that support is low so only small portion of the fields support a
        function are available in the records, something on the right means the support is strength. The bars
        represents a range of values. The vertical axis shows the number of records having values in the same range.</p>

      <p>It is experimental because it turned out, that the the mapping covers about 2000 elements (fields, subfields,
        indicatiors etc.), however on an average record there are max several hundred elements, which results that even
        in the best record has about 10-15% of the totality of the elements supporting a given function. So the tool
        doesn't shows you exact numbers, and the scale is not 0-100 but 0-[best score] which is different for every
        catalogue.</p>

    </div>
    <div class="tab-pane" id="classifications" role="tabpanel" aria-labelledby="classifications-tab">
      <h2>Subject analysis</h2>
      <div id="classifications-content"></div>
    </div>
    <div class="tab-pane" id="authorities" role="tabpanel" aria-labelledby="authorities-tab">
      <h2>Authority analysis</h2>
      <div id="authorities-content"></div>
    </div>
    <div class="tab-pane" id="terms" role="tabpanel" aria-labelledby="terms-tab">
      <h2>Terms</h2>
      <div id="terms-scheme" data-facet="" data-query=""></div>
      <div id="terms-content"></div>
    </div>
    <div class="tab-pane" id="serials" role="tabpanel" aria-labelledby="serials-tab">
      <h2>Serials analysis</h2>
      <p>These scores are calculated for each continuing resources (type of record (LDR/6) is
        language material ('a') and bibliographic level (LDR/7) is serial component part ('b'),
        integrating resource ('i') or serial ('s')).</p>
      <p>The calculation is based on a slightly modified version of the method published
        by Jamie Carlstone in the following paper:</p>

      <blockquote>
        Jamie Carlstone (2017) <em>Scoring the Quality of E-Serials MARC Records Using Java</em>,
      Serials Review, 43:3-4, pp. 271-277,
      DOI: <a href="https://doi.org/10.1080/00987913.2017.1350525" target="_blank">10.1080/00987913.2017.1350525</a>
      URL: <a href="https://www.tandfonline.com/doi/full/10.1080/00987913.2017.1350525" target="_blank">https://www.tandfonline.com/doi/full/10.1080/00987913.2017.1350525</a>
      </blockquote>

      <div id="serials-content"></div>
    </div>
    <div class="tab-pane" id="tt-completeness" role="tabpanel" aria-labelledby="tt-completeness-tab">
      <h2>Thompson&mdash;Traill completeness</h2>
      <p>These scores are the implementation of the following paper:</p>

      <blockquote>
        Kelly Thompson and Stacie Traill (2017)
        <em>Implementation of the scoring algorithm described in Leveraging Python to improve ebook
          metadata selection, ingest, and management</em>, Code4Lib Journal, Issue 38, 2017-10-18.
        <a href="http://journal.code4lib.org/articles/12828" target="_blank">http://journal.code4lib.org/articles/12828</a>
      </blockquote>
      <p>Their approach to calculate the quality of ebook records comming from different data
        sources.</p>
      <div id="tt-completeness-content"></div>
    </div>
    <div class="tab-pane" id="pareto" role="tabpanel" aria-labelledby="pareto-tab">
      <h2>Field frequency distribution</h2>

      <p>These charts show how the field frequency patterns. Each chart shows a line which is the function of
        field frequency: on the x axis you can see the subfields ordered by the frequency (how many time a given
        subfield occured in the whole catalogue). They are ordered by frequency from the most frequent top 1%
        to the least frequent 1% subfields.
        The Y axis represents the cumulative occurrence (from 0% to 100%).
      </p>

      <div id="pareto-content"></div>
    </div>
    <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
      <a href="#" id="set-facets">set facets</a>
      <div id="set-facet-list"></div>
    </div>
    <div class="tab-pane" id="about" role="tabpanel" aria-labelledby="about-tab">
      <div id="about-tab">
        <p>
          This experimental website is part of a research project called Measuring Metadata Quality
          conducted by Péter Király. You can read more about the research at
          <a href="https://pkiraly.github.io" target="_blank">pkiraly.github.io</a>.
        </p>

        <p>This is an open source project. You can find the code at:</p>
        <ul>
          <li><a href="https://github.com/pkiraly/metadata-qa-marc" target="_blank">Backend (Java)</a></li>
          <li><a href="https://github.com/pkiraly/metadata-qa-marc-web" target="_blank">Frontend (PHP)</a></li>
        </ul>

        <p><em>Credits</em></p>
        <p>Thanks for Johann Rolschewski and Phú for their help in collecting the list of published library catalog,
          Jakob Voß for the Avram specification and for his help in exporting MARC schema to Avram, Carsten Klee
          for the MARCspec. I would like to thank the early users of the software, Patrick Hochstenbach (Gent),
          Osma Suominen and Tuomo Virolainen (FNL), Kokas Károly and Bernátsky László (SZTE), Sören Auer and Berrit
          Genat (TIB), Shelley Doljack, Darsi L Rueda, and Philip E. Schreur (Stanford), Marian Lefferts (CERL),
          Alex Jahnke and Maike Kittelmann (SUB) who provided data, suggestions or other kinds of feedback, Justin
          Christoffersen for language assistance. Special thanks to Reinhold Heuvelmann (DNB) for terminological and
          language suggestions.</p>
        <p>I would like to thank the experts I have consulted regarding to subject analysis: Rudolf Ungváry
          (retired, Hungarian National Library, HU), Gerard Coen (DANS and ISKO-NL, NL), Andreas Ledl (BARTOC and Uni
          Basel, CH), Anna Kasprzik (ZBW, DE), Jakob Voß (GBV, DE), Uma Balakrishnan (GBV, DE),
          Yann Y. Nicolas (ABES, FR), Michael Franke-Maier (Freie Universität Berlin, DE), Gerhard Lauer (Uni Basel, CH).</p>
      </div>
    </div>
  </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script src="js/handlebars.min.js"></script>
<!-- handlebars.runtime-v4.1.1.js -->

<script id="filter-param-template" type="text/x-handlebars-template">fq={{field}}:"{{value}}"</script>
<script id="filter-all-param-template" type="text/x-handlebars-template">fq={{field}}:*</script>

<script id="list-filters-template" type="text/x-handlebars-template">
  {{#list filters}}<a href="#" data="{{param}}"><i class="fa fa-minus" aria-hidden="true"></i></a> {{label}}{{/list}}
</script>

<script id="item-prev-next-template" type="text/x-handlebars-template">
  <a href="#" data="{{start}}">{{label}}</a>
</script>

<script id="strong-template" type="text/x-handlebars-template">
  <strong>{{item}}</strong>
</script>

<script type="text/javascript">
  var query = '*:*';
  var start = 0;
  var rows = 10;
  var filters = [];
  var facetLimit = 10;
  var facetOffsetParameters = [];

  var defaultFacets = [
    '041a_Language_ss',
    '040b_AdminMetadata_languageOfCataloging_ss',
    'Leader_06_typeOfRecord_ss',
    'Leader_18_descriptiveCatalogingForm_ss'
  ];

  var facets = defaultFacets;
  if (typeof selectedFacets != 'undefined')
    facets = selectedFacets;

  var parameters = [
    'wt=json',
    'json.nl=map',
    'json.wrf=?',
    'facet=on',
    'facet.limit=' + facetLimit
    // 'facet.field=ManifestationIdentifier_ss',
    // 'facet.field=9129_WorkIdentifier_ss',
    // 'facet.field=041a_Language_ss',
    // 'facet.field=040b_AdminMetadata_languageOfCataloging_ss',
    // 'facet.field=Leader_06_typeOfRecord_ss',
    // 'facet.field=Leader_18_descriptiveCatalogingForm_ss'
  ];

  var facetLabels = {
    '041a_Language_ss': 'language',
    '040b_AdminMetadata_languageOfCataloging_ss': 'language of cataloging',
    'Leader_06_typeOfRecord_ss': 'record type',
    'Leader_18_descriptiveCatalogingForm_ss': 'cataloging form',
    '650a_Topic_topicalTerm_ss': 'topic',
    '650z_Topic_geographicSubdivision_ss': 'geographic',
    '650v_Topic_formSubdivision_ss': 'form',
    '6500_Topic_authorityRecordControlNumber_ss': 'topic id',
    '6510_Geographic_authorityRecordControlNumber_ss': 'geo id',
    '6550_GenreForm_authorityRecordControlNumber_ss': 'genre id',
    '9129_WorkIdentifier_ss': 'work id',
    '9119_ManifestationIdentifier_ss': 'manifestation id'
  };

  Handlebars.registerHelper('list', function(items, options) {
    var out = '<ul>';
    for(var i=0, l=items.length; i<l; i++) {
      out = out + '<li>' + options.fn(items[i]) + '</li>';
    }
    return out + '</ul>';
  });

  var filterParamTemplate = Handlebars.compile($("#filter-param-template").html());
  var filterAllParamTemplate = Handlebars.compile($("#filter-all-param-template").html());
  var filterTemplate      = Handlebars.compile($("#list-filters-template").html());
  var itemPrevNextTemplate= Handlebars.compile($("#item-prev-next-template").html());
  var strong              = Handlebars.compile($("#strong-template").html());

  function getFacetLabel(facet) {
    if (typeof facetLabels[facet] != "undefined")
      return facetLabels[facet];
    return facet.replace(/_ss$/, '').replace(/_/g, ' ');
  }

  function buildFacetParameters() {
    var facetParameters = [];
    for (var i in facets) {
      facetParameters.push('facet.field=' + facets[i]);
    }
    if (facetParameters.length > 0) {
      facetParameters.push('facet.mincount=1');
    }
    return facetParameters;
  }

  function buildFacetNavigationParameters() {
    var facetParameters = [];
    facetParameters.push('facet.mincount=1');
    for (var i in facetOffsetParameters) {
      facetParameters.push('facet.field=' + i);
      facetParameters.push('f.' + i + '.facet.offset=' + facetOffsetParameters[i]);
    }
    return facetParameters;
  }

  function buildUrl() {

    var url = solrDisplay // solrProxy // baseUrl
      + '?q=' + query
      + '&' + parameters.join('&')
      + '&' + buildFacetParameters().join('&')
      + '&start=' + start
      + '&rows=' + rows
      + '&core=' + db
    ;

    if (filters.length > 0)
      for (var i = 0; i < filters.length; i++)
        url += '&' + filters[i].param;

    return url;
  }

  function buildFacetNavigationUrl() {

    var url = solrDisplay // solrProxy // baseUrl
      + '?q=' + query
      + '&' + parameters.join('&')
      + '&' + buildFacetNavigationParameters().join('&')
      + '&rows=0'
      + '&core=' + db
    ;

    if (filters.length > 0)
      for (var i = 0; i < filters.length; i++)
        url += '&' + filters[i].param;

    return url;
  }

  function updateFilterBlock() {
    $('#filter-list').html(filterTemplate({'filters': filters}));
    $('#filter-list a').click(function (e) {
      var filter = $(this).attr('data');
      var index = -1;
      for (var i = 0; i < filters.length; i++) {
        if (filters[i].param == filter) {
          index = i;
          break;
        }
      }
      if (index != -1) {
        filters.splice(index, 1);
        start = 0;
        loadDataTab(buildUrl());
      }
    })
  }

  function createPrevNextLinks(numFound) {
    $('#prev-next').html('');
    $('#prev-next-footer').html('');
    var items = [];
    var item;
    if (start > 0) {
      for (var i = 1; i <= 3; i++) {
        item = start - (i * rows);
        if (item >= 0)
          items.unshift(itemPrevNextTemplate(
            {'start': item, 'label': getInterval(item, numFound, false)}));
      }
    }
    items.push(strong({'item': getInterval(start, numFound, true)}));
    for (var i = 1; i <= 3; i++) {
      item = parseInt(start) + (i * rows);
      if (item+1 < numFound)
        items.push(itemPrevNextTemplate(
          {'start': item, 'label': getInterval(item, numFound, false)}));
    }
    $('#prev-next').html(items.join(' &nbsp; '));
    $('#prev-next-footer').html(items.join(' &nbsp; '));
    $('#prev-next a').click(function (event) {
      event.preventDefault();
      start = $(this).attr('data');
      loadDataTab(buildUrl());
      scroll(0, 0);
    });
    $('#prev-next-footer a').click(function (event) {
      event.preventDefault();
      start = $(this).attr('data');
      loadDataTab(buildUrl());
      scroll(0, 0);
    });
  }

  function getInterval(number, max, both) {
    var beginning = parseInt(number) + 1;
    var startEnd = beginning + '-';
    if (both === true) {
      var ending = parseInt(number) + parseInt(rows);
      if (ending > max)
        ending = max;
      startEnd += ending;
    }
    return startEnd;
  }

  function createMarcView(id, jsonString) {
    var marc = eval('(' + jsonString + ')');
    var tags = sortTags(marc);

    var rows = [];
    for (var tagId in tags) {
      var tag = tags[tagId];
      if (tag.match(/^00/) || tag == 'leader') {
        rows.push([tag, '', '', '', marc[tag]]);
      } else {
        var value = marc[tag];
        var firstRow = [tag, value.ind1, value.ind2];
        var i = 0;
        for (var code in value.subfields) {
          i++;
          if (i == 1) {
            firstRow.push('$' + code, value.subfields[code]);
            rows.push(firstRow);
          } else {
            rows.push(['', '', '', '$' + code, value.subfields[code]]);
          }
        }
      }
    }
    var trs = [];
    for (var i in rows) {
      trs.push('<tr><td>' + rows[i].join('</td><td>') + '</td></tr>');
    }
    var marcTable = '<table>' + trs.join('') + '</table>';
    $('#marc-details-' + id).html(marcTable)
  }

  function sortTags(marc) {
    var tags = [];
    for (var tag in marc) {
      if (tag != 'leader')
        tags.push(tag);
    }
    tags.sort();
    tags.unshift('leader');
    return tags;
  }

  function setFacetClickBehaviour() {
    $('div#facets ul a.facet-term').click(function (e) {
      var field = $(this).parent().parent().parent().attr('id');
      var value = $(this).html();
      var filterParam = filterParamTemplate({'field': field, 'value': value});
      filters.push({
        'param': filterParam,
        'label': getFacetLabel(field) + ': ' + value
      });
      start = 0;
      loadDataTab(buildUrl());
    });
  }

  function setFacetNavigationClickBehaviour() {
    $('div.facet-block ul a.facet-up').click(function (event) {
      event.preventDefault();
      var field = $(this).attr('data-field');
      var offset = parseInt($(this).attr('data-offset'));
      facetOffsetParameters[field] = (offset > 10) ? offset - 10 : 0;
      loadFacetNavigation(field);
    });
    $('div.facet-block ul a.facet-down').click(function (event) {
      event.preventDefault();
      var field = $(this).attr('data-field');
      var offset = parseInt($(this).attr('data-offset'));
      facetOffsetParameters[field] = offset + 10;
      loadFacetNavigation(field);
    });
  }

  function loadFacetNavigation(field) {
    var url = buildFacetNavigationUrl();
    $.ajax(url)
     .done(function(result) {
       $('#' + field).html(result.facets);
       setFacetClickBehaviour();
       setFacetNavigationClickBehaviour();
     });
  }

  function loadDataTab(urlParam) {
    $('#message').html('<i class="fa fa-spinner" aria-hidden="true"></i> loading...');

    if (filters.length > 0) {
      updateFilterBlock();
    } else {
      $('#filter-list').html('');
    }

    $.ajax(urlParam)
      .done(function(result) {
        $('#numFound').html(result.numFound.toLocaleString('en-US'));
        $('#solr-url').html(urlParam);
        createPrevNextLinks(result.numFound);

        $('#records').html(result.records);
        showRecordDetails();
        $('#facet-list').html(result.facets);
        setFacetClickBehaviour();
        setFacetNavigationClickBehaviour();
        $('#message').html('');
        $('a[aria-controls="marc-issue-tab"]').click(function (e) {
          var id = $(this).attr('data-id');
          var url = 'read-record-issues.php?db=' + db + '&id=' + id + '&display=1';
          $.ajax(url)
            .done(function(result) {
              $('#marc-issue-' + id).html(result);
            });
        });
      })
      .fail(function() {
        console.error("error: can not access " + urlParam);
      });
  }

  function showRecordDetails() {
    $('.record h2 a.record-details').click(function (event) {
      event.preventDefault();
      var detailsId = $(this).attr('data');
      $('#' + detailsId).toggle();
    });

    $('.record-link').click(function (event) {
      event.preventDefault();
      var field = $(this).attr('data');
      var value = $(this).html();
      var filterParam = filterParamTemplate({'field': field, 'value': value});
      filters.push({
        'param': filterParam,
        'label': getFacetLabel(field) + ': ' + value
      });
      start = 0;
      loadDataTab(buildUrl());
    });
  }

  function doSearch() {
    query = $('#query').val();
    start = 0;
    loadDataTab(buildUrl());
  }

  function itemsPerPage() {
    var items = [];
    var numbers = [10, 25, 50, 100];
    for (var i in numbers) {
      var number = numbers[i];
      if (number === rows)
        items.push(strong({'item': number}));
      else
        items.push(itemPrevNextTemplate({
          'start': number, 'label': number}));
    }
    $('#items-per-page').html(items.join(' '));
    $('#items-per-page a').click(function (event) {
      event.preventDefault();
      start = 0;
      rows = $(this).attr('data');
      itemsPerPage();
      loadDataTab(buildUrl());
    });
  }

  function setFacets() {
    $('#set-facet-list').html('<h3>Set facets</h3>');
    $.getJSON('listFields.php?db=' + db, function(result, status) {
      var htmlForm = '<form id="facetselection">';
      for (var item in result) {
        var facet = result[item];
        var isInUse = jQuery.inArray(facet, facets) > -1;
        var checked = isInUse ? ' checked="checked"' : '';
        htmlForm += '<input type="checkbox"'
          + ' value="' + facet + '"'
          + ' name="facet"'
          + ' id="' + facet + '"'
          + checked
          + '> '
          + '<label for="' + facet +'">' + facet + '</label><br/>'
        ;
      }
      htmlForm += '<input type="submit" value="save" id="save-facet-change" />';
      htmlForm += '</form>';
      $('#set-facet-list').append(htmlForm);

      setFacetSelectionHandlers();
    });
  }

  function setFacetSelectionHandlers() {
    // $('#facet-selection :checkbox').change(function (){
    $('input[type="checkbox"]').change(function () {
      if (this.name == 'facet') {
        var facet = this.value;
        if (this.checked) {
          facets.push(facet);
        } else {
          var pos = jQuery.inArray(facet, facets);
          if (pos > -1)
            facets.splice(pos, 1);
        }
      }
    });

    $('#facetselection').submit(function(event) {
      event.preventDefault();
      var checkValues = $('input[name=facet]:checked').map(function() {
        return this.value;
      }).get().join(',');

      $.post("saveFacets.php", {facet: checkValues, db: db}, function(result){
        $("#message").html("saved");
      });
      doSearch();
    });
  }

  function openType(t) {
    $('tr.t-' + t).toggle();
  }

  function searchForField(field) {
    var filterParam = filterAllParamTemplate({'field': field});
    filters = [];
    filters.push({
      'param': filterParam,
      'label': getFacetLabel(field) + ': *'
    });
    start = 0;
    loadDataTab(buildUrl());
    showTab('data');
  }

  function loadCompleteness() {
    $.get('read-packages.php?db=' + db + '&display=1')
    .done(function(data) {
      $('#completeness-group-table').html(data);
    });
    $.get('read-completeness.php?db=' + db + '&display=1')
     .done(function(data) {
       $('#completeness-field-table').html(data);
       setCompletenessLinkHandlers();
     });
  }

  function loadCompletenessOld() {
    $.get('read-completeness.php?db=' + db)
      .done(function(data) {
        var fieldNames = [
          'path','label','','count','%','count','min','max','mean','stddev'
        ]; // ,'histogram'
        var htmlRow = [];
        for (var field in fieldNames) {
          var classAttr = '';
          if (field < 3) {
            classAttr = ' class="left"';
          } else if (fieldNames[field] == 'count') {
            classAttr = ' class="bordered-left"';
          } else if (fieldNames[field] == 'stddev') {
            classAttr = ' class="bordered-right"';
          }
          htmlRow.push('<th' + classAttr + '>' + fieldNames[field] + '</th>');
        }
        var header = '<tr class="first">'
          + '<th colspan="3"></th>'
          + '<th colspan="2" class="with-border">records</th>'
          + '<th colspan="5" class="with-border">occurences</th>'
          + '</tr>'
          + '<tr class="second">' + htmlRow.join('') + '</tr>';
        var previousPackage = '';
        var previousTag = '';

        var rows = [];
        for (var i in data.records) {
          var rowData = data.records[i];
          var htmlRow = [];
          var percent = 0;
          for (var field in rowData) {
            if (field == 'package') {
              var currentPackage = rowData['package'];
              if (currentPackage != previousPackage)
                rows.push('<tr><td colspan="5" class="package">[' + currentPackage + ']</td></tr>');
              previousPackage = currentPackage;
            } else if (field == 'tag') {
              var currentTag = rowData['tag'];
              if (currentTag != previousTag)
                rows.push('<tr><td colspan="5" class="tag">'
                  + rowData['path'].substr(0, 3) + ' &mdash; ' + currentTag
                  + '</td></tr>');
              previousTag = currentTag;
            } else if (field == 'histogram' || field == 'solr') {
            } else {
              if (field == 'number-of-record') {
                percent = rowData[field] / data.max;
                htmlRow.push(
                  '<td class="chart">'
                  + '<div style="width: ' + (percent * 200) + 'px;">&nbsp;</div>'
                  + '</td>'
                );
              }
              if (field == 'path') {
                var content = rowData[field].substr(3);
                if (rowData['solr'] != undefined) {
                  var query = rowData['solr'] + ':*';
                  content = '<a href="javascript:searchForField(\'' + rowData['solr'] + '\')">' + content + '</a>';
                }
                htmlRow.push('<td class="' + field + '">' + content + '</td>');
              } else {
                htmlRow.push('<td class="' + field + '">' + rowData[field] + '</td>');
              }
              if (field == 'number-of-record') {
                htmlRow.push('<td class="' + field + '">' + (percent * 100).toFixed(2) + '%</td>');
              }
            }
          }
          rows.push('<tr>' + htmlRow.join('') + '</tr>');
        }

        var table = '<table>'
          + '<thead>' + header + '</thead>'
          + '<tbody>' + rows.join('') + '</tbody>'
          + '</table>';
        $('#completeness-field-table').html(table);
      });
  }

  function loadIssues() {
    $.get('read-issue-summary.php?db=' + db + '&display=1')
      .done(function(data) {
        $('#issues-table-placeholder').html(data);
        loadIssueHandlers();
      });
  }

  function loadIssuesDOM() {
    $.get('read-issue-summary.php?db=' + db)
      .done(function(data) {
        var fieldNames = ['path', 'message', 'url', 'count']; // ,'histogram'
        var htmlRow = [];
        for (var field in fieldNames) {
          var classAttr = '';
          var name = fieldNames[field] == 'message'
            ? 'value/explanation' : fieldNames[field];
          htmlRow.push('<th' + classAttr + '>' + name + '</th>');
        }
        var header = '<tr>' + htmlRow.join('') + '</tr>';
        var numberFormat = new Intl.NumberFormat('en-UK');

        var rows = [];
        var typeCounter = 0;
        for (var typeId in data.types) {
          var type = data.types[typeId];
          var typeRows = [];
          typeCounter++;
          var records = data.records[type];
          var totalCount = 0;
          for (var i in records) {
            var rowData = records[i];
            var htmlRow = [];
            var percent = 0;
            for (var field in rowData) {
              var content = rowData[field];
              if (field == 'count') {
                totalCount += parseInt(content);
                content = '<a href="#"'
                  + ' data-type="' + type + '"'
                  + ' data-path="' + rowData['path'] + '"'
                  + ' data-message="' + rowData['message'] + '">'
                  + numberFormat.format(content)
                  + '</a>';
              } else if (field == 'url') {
                if (!content.match(/^http/)) {
                  content = showMarcUrl(content);
                }
                content = '<a href="' + content + '" target="_blank">'
                  + '<i class="fa fa-info" aria-hidden="true"></i></a>';
              } else if (field == 'message') {
                if (content.match(/^ +$/)) {
                  content = '"' + content + '"';
                }
              } else if (field == 'path') {
              }

              htmlRow.push('<td class="' + field + '">' + content + '</td>');
            }
            var typeRow = '<tr class="t t-' + typeCounter + '">'
              + htmlRow.join('')
              + '</tr>';
            typeRows.push(typeRow);
          }

          var typeHeadRow = '<tr>'
            + '<td colspan="3" class="type"><span class="type">' + type + '</span>'
            + ' (' + data.typeCounter[type].variations + ' variants)'
            + ' <a href="javascript:openType(' + typeCounter + ')">[+]</a>'
            + '</td>'
            + '<td class="count">' + numberFormat.format(data.typeCounter[type].count) + '</td>'
            + '</tr>';
          rows.push(typeHeadRow);
          rows = rows.concat(typeRows);
        }

        var table = '<table id="issues-table">'
          + '<thead>' + header + '</thead>'
          + '<tbody>' + rows.join('') + '</tbody>'
          + '</table>';
        $('#issues-table-placeholder').html(table);
        loadIssueHandlers();
      });
  }

  function loadIssueHandlers() {
    $('#issues-table-placeholder tr.t td.count a').hover(
      function () {
        $(this).attr('title', 'show records records having this issue (max 10 records)');
      },
      function () {
        $(this).find("span:last").remove();
      }
    );

    $('#issues-table-placeholder tr.t td.count a').on('click', function (e) {
      var query = {'db': db};
      query.errorId = $(this).attr('data-id');
      var issueDetailsUrl = 'read-issue-collector.php'
      $.get(issueDetailsUrl, query)
       .done(function (data) {
         var query = 'id:("' + data.recordIds.join('" OR "') + '")';
         $('#query').val(query);
         showTab('data');
         doSearch();
       });
    });
  }

  function loadClassifications() {
    $.getJSON('read-classifications.php?db=' + db, function(result, status) {
      $('#classifications-content').html(result.byRecord);
      $('#classifications-content').append(result.histogram);
      $('#classifications-content').append(result.byField);
      setClassificationLinkHandlers();
    });
  }

  function loadAuthorities() {
    $.getJSON('read-authorities.php?db=' + db, function(result, status) {
      $('#authorities-content').html(result.byRecord);
      $('#authorities-content').append(result.histogram);
      $('#authorities-content').append(result.byField);
      setAuthoritiesLinkHandlers();
    });
  }

  function loadSerials() {
    $.getJSON('read-serials.php?db=' + db, function(result, status) {
      // $('#serials-content').html(result.byRecord);
      $('#serials-content').html(result.histogram);
      // $('#serials-content').append(result.byField);
      // setAuthoritiesLinkHandlers();
    });
  }

  function loadTtCompleteness() {
    $.getJSON('read-tt-completeness.php?db=' + db, function(result, status) {
      // $('#serials-content').html(result.byRecord);
      $('#tt-completeness-content').html(result.histogram);
      // $('#tt-completeness-content').append(result.byField);
      // setAuthoritiesLinkHandlers();
    });
  }

  function loadPareto() {
    $.getJSON('read-pareto.php?db=' + db, function(result, status) {
      $('#pareto-content').html(result.histogram);
    });
  }

  function setClassificationLinkHandlers() {
    $('a.term-link').click(function(event) {
      event.preventDefault();
      var facet = $(this).attr('data-facet');
      var termQuery = $(this).attr('data-query');
      var scheme = $(this).attr('data-scheme');

      var url = solrDisplay
          + '?q=' + termQuery
          + '&facet=on'
          + '&facet.limit=100'
          + '&facet.field=' + facet
          + '&facet.mincount=1'
          + '&core=' + db
          + '&rows=0'
          + '&wt=json'
          + '&json.nl=map'
      ;

      $.getJSON(url, function(result, status) {
        $('#terms-content').html(result.facets);
        $('#terms-scheme').html(scheme);
        $('#terms-scheme').attr('data-facet', facet);
        $('#terms-scheme').attr('data-query', termQuery);
        showTab('terms');
        scroll(0, 0);

        $('#terms-content a.facet-term').click(function(event) {
          var term = $(this).html();
          var facet = $('#terms-scheme').attr('data-facet');
          var fq = $('#terms-scheme').attr('data-query');
          query = facet + ':%22' + term + '%22';
          $('#query').val(query);
          filters = [];
          filters.push({
            'param': 'fq=' + fq,
            'label': clearFq(fq)
          });
          start = 0;
          var url = buildUrl();
          loadDataTab(url);
          showTab('data');
        });
      });
    });
  }

  function setAuthoritiesLinkHandlers() {
    $('a.term-link').click(function(event) {
      event.preventDefault();
      var facet = $(this).attr('data-facet');
      var termQuery = $(this).attr('data-query');
      var scheme = $(this).attr('data-scheme');

      var url = solrDisplay
        + '?q=' + termQuery
        + '&facet=on'
        + '&facet.limit=100'
        + '&facet.field=' + facet
        + '&facet.mincount=1'
        + '&core=' + db
        + '&rows=0'
        + '&wt=json'
        + '&json.nl=map'
      ;

      $.getJSON(url, function(result, status) {
        $('#terms-content').html(result.facets);
        $('#terms-scheme').html(scheme);
        $('#terms-scheme').attr('data-facet', facet);
        $('#terms-scheme').attr('data-query', termQuery);
        showTab('terms');
        scroll(0, 0);

        $('#terms-content a.facet-term').click(function(event) {
          var term = $(this).html();
          var facet = $('#terms-scheme').attr('data-facet');
          var fq = $('#terms-scheme').attr('data-query');
          query = facet + ':%22' + term + '%22';
          $('#query').val(query);
          filters = [];
          filters.push({
            'param': 'fq=' + fq,
            'label': clearFq(fq)
          });
          start = 0;
          var url = buildUrl();
          loadDataTab(url);
          showTab('data');
        });
      });
    });
  }

  function setCompletenessLinkHandlers() {
    $('a.term-link').click(function(event) {
      event.preventDefault();
      var facet = $(this).attr('data-facet');
      var termQuery = $(this).attr('data-query');
      var scheme = $(this).attr('data-scheme');

      var url = solrDisplay
        + '?q=' + termQuery
        + '&facet=on'
        + '&facet.limit=100'
        + '&facet.field=' + facet
        + '&facet.mincount=1'
        + '&core=' + db
        + '&rows=0'
        + '&wt=json'
        + '&json.nl=map'
      ;

      $.getJSON(url, function(result, status) {
        showTab('terms');
        scroll(0, 0);
        $('#terms-content').html(result.facets);
        $('#terms-scheme').html(scheme);
        $('#terms-scheme').attr('data-facet', facet);
        $('#terms-scheme').attr('data-query', termQuery);

        $('#terms-content a.facet-term').click(function(event) {
          var term = $(this).html();
          var facet = $('#terms-scheme').attr('data-facet');
          var fq = $('#terms-scheme').attr('data-query');
          query = facet + ':%22' + term + '%22';
          $('#query').val(query);
          filters = [];
          filters.push({
            'param': 'fq=' + fq,
            'label': clearFq(fq)
          });
          start = 0;
          var url = buildUrl();
          loadDataTab(url);
          showTab('data');
        });
      });
    });
  }

  function clearFq(fq) {
    return fq.replace(/_ss:/g, ':').replace(/%22/g, '"').replace(/_/g, ' ').replace(/:/, ': ');
  }

  function loadTerms() {
    console.log('loadTerms');
  }

  function loadFunctions() {
    var height = 200,
        width  = 270,
        margin = ({top: 10, right: 10, bottom: 34, left: 40})
    ;

    var url = 'read-functional-analysis-histogram.php?db=' + db;
    var datax = d3
      .csv(url)
      .then(function(data) {
        var filteredData = new Array(12),
            totals = new Array(12);
        var min = -1,
            maxX = -1,
            maxCount = -1;
        for (var i in data) {
          var item = data[i];
          if (i == 'columns')
            continue;

          var frbrfunction = item.frbrfunction;
          if (typeof filteredData[item.frbrfunction] === "undefined") {
            filteredData[item.frbrfunction] = new Array();
          }
          var score = parseInt(item.score);
          var count = parseInt(item.count);
          if (typeof totals[item.frbrfunction] === 'undefined')
            totals[item.frbrfunction] = 0;
          totals[item.frbrfunction] += count

          filteredData[item.frbrfunction].push({
              score: score,
              count: count
            });

            if (min == -1 || min > score) {
              min = score;
            }
        }

        for (var frbrfunction in filteredData) {
          var items = new Array();
          for (i in filteredData[frbrfunction]) {
            var item = filteredData[frbrfunction][i]
            percent = item.count * 100 / totals[frbrfunction]
            if (percent >= 0.5) {
              item.percent = Math.ceil(percent)
              items.push(item);
              if (maxX < item.score) {
                maxX = item.score;
                maxCount = item.count
              }
            }
          }
          filteredData[frbrfunction] = items
        }

        var bandWidth = ((width - margin.right - margin.left) / (maxX - min)) - 1,
            x = d3.scaleBand().rangeRound([0, width]).padding(0.1),
            y = d3.scaleLinear().rangeRound([height, 0]);

        var x = d3.scaleBand()
                  .domain([0, maxX])
                  .rangeRound([margin.left, width - margin.right])
                  .padding(0.1)

        var y = d3.scaleLinear()
                  .domain([0, 100])
                  .range([height - margin.bottom, margin.top])

        var scaleX = d3.scaleLinear()
            .domain([0, maxX])
            .range([margin.left, width - margin.right])

        var xAxis = function(g) {
          g.attr("transform", `translate(0,${height - margin.bottom})`)
           .call(d3.axisBottom(scaleX).tickSizeOuter(0))
        }

        var yAxis = function(g) {
          g.attr("transform", `translate(${margin.left},0)`)
           .call(d3.axisLeft(y))
           .call(g => g.select(".domain").remove())
        }

        var yTitle = function(g) {
          g.append("text")
           .attr("font-family", "sans-serif")
           .attr("font-size", 10)
           .attr("y", 10)
           .text("Frequency of records (%)")
           .attr("transform", "translate(0,5)rotate(-90)")
           .style("text-anchor", "end")
           .attr("fill", 'steelblue')
        }

        var xTitle = function(g) {
          g.append("text")
          .attr("font-family", "sans-serif")
          .attr("font-size", 10)
          .attr("y", height - 3)
          .attr("x", width - margin.right)
          .text("Percentage of enabling fields")
          .style("text-anchor", "end")
          .attr("fill", 'steelblue')
        }

        for (var frbrfunction in filteredData) {
          var histogram = filteredData[frbrfunction];
          var id = '#bar-chart-' + frbrfunction.toLowerCase();

          var scaleY = d3.scaleLinear()
              .domain([0, d3.max(histogram, d => d.percent)]).nice()
              .range([height - margin.bottom, margin.top])

          const svg = d3.select(id)
            .attr("viewBox", [0, 0, width, height]);

          svg.append("g")
            .attr("fill", "steelblue")
            .selectAll("rect")
            .data(histogram)
            .join("rect")
            .attr("x", d => {
              return margin.left + (d.score * bandWidth) - (bandWidth * 0.2);
            })
            .attr("y", d => y(d.percent))
            .attr("height", d => y(0) - y(d.percent))
            .attr("width", bandWidth);

          svg.append("g").call(xAxis);
          svg.append("g").call(yAxis);
          svg.call(xTitle);
          svg.call(yTitle);
        }
      });
  }

  function resetTabs() {
    $('#myTabContent .tab-pane').each(function() {
      if (!$(this).attr('id').match(/^marc-/)) {
        $(this).removeClass('active');
      }
    });
  }

  function showTab(id) {
    $('#myTabContent .tab-pane').each(function() {
      if ($(this).attr('id') == id) {
        $(this).addClass('active');
      } else {
        $(this).removeClass('active');
      }
    });
    $('#myTab a[href="#' + id + '"]').tab('show');
  }

  $(document).ready(function () {
    itemsPerPage();

    $('.fa-search').click(function (event) {
      doSearch();
    });
    $('#search').submit(function (event) {
      event.preventDefault();
      doSearch();
    });
    $('#set-facets').click(function (event) {
      event.preventDefault();
      setFacets();
    });

    loadCompleteness();

    $('#myTab a').on('click', function (e) {
      e.preventDefault();
      resetTabs();
      var id = $(this).attr('id');
      if (id == 'data-tab') {
        loadDataTab(buildUrl());
      } else if (id == 'completeness-tab') {
        loadCompleteness();
      } else if (id == 'issues-tab') {
        loadIssues();
      } else if (id == 'functions-tab') {
        loadFunctions();
      } else if (id == 'classifications-tab') {
        loadClassifications();
      } else if (id == 'authorities-tab') {
        loadAuthorities();
      } else if (id == 'serials-tab') {
        loadSerials();
      } else if (id == 'tt-completeness-tab') {
        loadTtCompleteness();
      } else if (id == 'pareto-tab') {
        loadPareto();
      } else if (id == 'terms-tab') {
        loadTerms();
      }
      $(this).tab('show');
    });
  });
</script>
</body>
</html>