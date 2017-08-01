var footerSlideshow = new Vue({
  el: '#slideshow',
  data: {
    logos: [
      {
        src: 'cslogo.png',
        link: 'http://www.cs.uregina.ca/',
        name: 'U of R Computer Science'
      },
      {
        src: 'strategylab.png',
        link: 'http://strategylab.ca/',
        name: 'Strategy Lab'
      },
      {
        src: 'telus.png',
        link: 'http://www.telus.com/',
        name: 'Telus'
      },
      {
        src: 'innovationplacelogo.png',
        link: 'http://innovationplace.com/',
        name: 'Innovation Place'
      },
      {
        src: 'capital.png',
        link: 'http://capitalautomall.ca/',
        name: 'Capital'
      },
      {
        src: 'uofrlogo.png',
        link: 'https://www.uregina.ca/',
        name: 'University of Regina'
      },
      {
        src: 'metriclogo.png',
        link: 'http://metric-hosting.ca/',
        name: 'Metric Hosting'
      },
      {
        src: 'isc.png',
        link: 'https://www.isc.ca/Pages/default.aspx',
        name: 'ISC'
      }
    ]
  },
  methods: {
    imgSrc: function (src) {
      return 'img/sponsors/' + src;
    },
    imgAlt: function (name) {
      return name + ' Logo';
    }
  }
})
