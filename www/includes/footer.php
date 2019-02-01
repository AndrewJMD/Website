        </div>
        <footer>
          <div id="slideshow">
            <div @click="moveLeft" class="slideshow-button"><i class="fa fa-2x fa-chevron-left"
              aria-label="Move image slider left"></i></div>
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
            <div @click="moveRight(true)" class="slideshow-button"><i class="fa fa-2x fa-chevron-right"
              aria-label="Move image slider right"></i></div>
          </div>
        </footer>
      </div>
    </div>
    <script src="js/footerSlideshow.js"></script>
    <script src="js/slider.php"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-50411886-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-50411886-1');
    </script>
  </body>
</html>
