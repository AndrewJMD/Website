new Vue({
  el: '#slider',
  data: {
    images: <?php require_once("../libs/gphotos.php"); $images=GooglePhotos::albumsArray("https://goo.gl/photos/1FuaFb5m5JjJGh919","https://goo.gl/photos/XYfr2fnv1nqZHDB37");shuffle($images);echo json_encode($images);?>,
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
