  <footer>
    <div id="slideshow">
      <div id="slideshow-window">
        <div id="slideshow-items">
          <div v-for="logo in logos" class="logo-container">
            <a :href="logo.link">
              <img :src="imgSrc(logo.src)" :alt="imgAlt(logo.name)">
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script src="js/footerSlideshow.js"></script>
  </body>
</html>
