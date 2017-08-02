var footerSlideshow = new Vue({
  el: "#slideshow",
  data: {
    logos: [
      {
        src: "cslogo.png",
        link: "http://www.cs.uregina.ca/",
        name: "U of R Computer Science"
      },
      {
        src: "strategylab.png",
        link: "http://strategylab.ca/",
        name: "Strategy Lab"
      },
      {
        src: "telus.png",
        link: "http://www.telus.com/",
        name: "Telus"
      },
      {
        src: "innovationplacelogo.png",
        link: "http://innovationplace.com/",
        name: "Innovation Place"
      },
      {
        src: "capital.png",
        link: "http://capitalautomall.ca/",
        name: "Capital"
      },
      {
        src: "uofrlogo.png",
        link: "https://www.uregina.ca/",
        name: "University of Regina"
      },
      {
        src: "metriclogo.png",
        link: "http://metric-hosting.ca/",
        name: "Metric Hosting"
      },
      {
        src: "isc.png",
        link: "https://www.isc.ca/Pages/default.aspx",
        name: "ISC"
      }
    ],
    item: 0,
    timer: null
  },
  computed: {
    transformStyle: function() {
      // We need to advance the slideshow 264px for every item.
      var result = "translateX(" + (-264 *this.item) + "px)";
      return result;
    }
  },
  methods: {
    imgSrc: function (src) {
      return "img/sponsors/" + src;
    },
    imgAlt: function (name) {
      return name + " Logo";
    },
    moveLeft: function() {
      if (this.item > 0) {
        this.item--;
      } else {
        this.item = this.logos.length - 1;
      }
      clearInterval(this.timer);
      this.timer = null;
    },
    moveRight: function(clear) {
      if (this.item >= (this.logos.length - 1)) {
        this.item = 0;
        return;
      }
      this.item++;
      if (clear) {
        clearInterval(this.timer);
        this.timer = null;
      }
    }
  },
  mounted: function () {
    var vm = this;
    this.timer = setInterval(function() { vm.moveRight(false); }, 3000);
  }
});
