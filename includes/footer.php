  <footer>
    <div id="slideshow">
      <i class="slideshow-button fa fa-2x fa-chevron-left"></i>
      <div id="slideshow-window">
        <div id="slideshow-items">
          <div v-for="logo in logos" class="logo-container">
            <div class="logo-wrapper">
              <a :href="logo.link">
                <img :src="imgSrc(logo.src)" :alt="imgAlt(logo.name)">
              </a>
            </div>
          </div>
        </div>
      </div>
      <i class="slideshow-button fa fa-2x fa-chevron-right"></i>
    </div>
  </footer>
  <script src="js/footerSlideshow.js"></script>
  </body>
</html>
