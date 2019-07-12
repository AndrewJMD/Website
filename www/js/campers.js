var camperApp = new Vue({
  el: "#camper-app",
  data: {
    year: 2019,
    campers: [],
    names: [],
  },
  created: function () {
    this.loadCampers(this.year);
  },
  methods: {
    loadCampers: function () {
      var vm = this;
      var urlToGet = window.location.protocol + "//" + window.location.host + "/dash/api/campers/year/" + this.year + "/simple";
      axios.get(urlToGet)
        .then(function (response) {
          response["data"].data.forEach(function(camper){
            if (!vm.names.includes(camper.name)) {
              if("username" in camper){
                vm.campers.push(camper);
                vm.names.push(camper.name);
              }
            }
          });
        })
        .catch(function (error) {
          alert("Sorry! An error occurred: " + error);
        });
    },
    camperSrc: function (src) {
      return "http://compcamps.com/img/campers/" + this.year + "/" + src.toLowerCase() + ".jpg";
    },
    github: function(username) {
      return "http://" + username + ".github.io/compcamps" + year.toString();
    }
  }
});
