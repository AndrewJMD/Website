  <footer>

    <?php
      $sponsors = [
        // image name, sponsor link, name
        ['cslogo.png', 'http://www.cs.uregina.ca/', 'U of R Computer Science'],
        ['strategylab.png', 'http://strategylab.ca/', 'Strategy Lab'],
        ['telus.png', 'http://www.telus.com/', 'Telus'],
        ['innovationplacelogo.png', 'http://innovationplace.com/', 'Innovation Place'],
        ['capital.png', 'http://capitalautomall.ca/', 'Capital'],
        ['uofrlogo.png', 'https://www.uregina.ca/', 'University of Regina'],
        ['metriclogo.png', 'http://metric-hosting.ca/', 'Metric Hosting'],
        ['isc.png', 'https://www.isc.ca/Pages/default.aspx', 'ISC']
      ];

      foreach ($sponsors as $sponsor) {
        $image = 'img/sponsors/'.$sponsor[0];
        $link = $sponsor[1];
        $alt = $sponsor[2].' Logo';

        echo "<a href=\"$link\"><img src=\"$image\" alt=\"$alt\"></a>";
      }
    ?>

  </footer>
  </body>
</html>
