  <footer>

    <?php
      $sponsors = [
        // image name, sponsor link
        ['cslogo.png', 'http://www.cs.uregina.ca/'],
        ['strategylab.png', 'http://strategylab.ca/'],
        ['telus.png', 'http://www.telus.com/'],
        ['innovationplacelogo.png', 'http://innovationplace.com/'],
        ['capital.png', 'http://capitalautomall.ca/'],
        ['uofrlogo.png', 'https://www.uregina.ca/'],
        ['metriclogo.png', 'http://metric-hosting.ca/'],
        ['isc.png', 'https://www.isc.ca/Pages/default.aspx']
      ];

      foreach ($sponsors as $sponsor) {
        $image = 'img/sponsors/'.$sponsor[0];
        $link = $sponsor[1];

        echo "<a href=\"$link\"><img src=\"$image\"></a>";
      }
    ?>

  </footer>
  </body>
</html>
