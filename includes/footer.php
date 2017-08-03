    <footer>
      <div id="slideshow">
        <i @click="moveLeft" class="slideshow-button fa fa-2x fa-chevron-left"
          aria-label="Move image slider left"></i>
        <div id="slideshow-window">
          <div id="slideshow-items" :style="{ transform: transformStyle }">
            <div v-for="logo in logos" class="logo-container">
              <div class="logo-wrapper">
                <a :href="logo.link">
                  <img :src="imgSrc(logo.src)" :alt="imgAlt(logo.name)">
                </a>
              </div>
            </div>
          </div>
        </div>
        <i @click="moveRight(true)" class="slideshow-button fa fa-2x fa-chevron-right"
          aria-label="Move image slider right"></i>
      </div>
    </footer>
    <script src="js/footerSlideshow.js"></script>
    <script src="js/slider.php"></script>
  </body>
</html>
