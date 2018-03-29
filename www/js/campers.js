var camperApp = new Vue({
  el: "#camper-app",
  data: {
    year: 2017,
    campers: []
  },
  created: function () {
    this.loadCampers(this.year);
  },
  methods: {
    loadCampers: function () {
      var vm = this;
      var urlToGet = window.location.protocol + '//' + window.location.host + '/dash/api/campers/year/' + this.year + '/simple';
      axios.get(urlToGet)
        .then(function (response) {
          vm.campers = response["data"].data;
          // double data because it is the request's data and the camper list is named data
        })
        .catch(function (error) {
          alert('Sorry! An error occurred: ' + error);
        });
    },
    camperSrc: function (src) {
      return "http://compcamps.com/2017%20Pictures/" + src + ".jpg";
    }
  }
});
