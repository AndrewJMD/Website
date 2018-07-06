new Vue({
  el: '#slider',
  data: {
    images: <?php require_once("../libs/gphotos.php"); $images=GooglePhotos::albumsArray("https://photos.app.goo.gl/EK6CFdXEc1hJYmgr8");shuffle($images);echo json_encode($images);?>,
    currentNumber: 0
  },

  mounted: function () {
    setTimeout(this.next, 2500);
  },

  methods: {
    next: function() {
      if (!document.hidden) {
        this.currentNumber += 1;
      }
      setTimeout(this.next, 2500);
    }
  }
});
