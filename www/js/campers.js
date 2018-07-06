var camperApp = new Vue({
  el: "#camper-app",
  data: {
    year: 2018,
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
          console.log(response);
          console.log(response["data"].data);
          response["data"].data.forEach(function(camper){
            console.log(camper);
            if (!vm.names.includes(camper.name)) {
              console.log("camper not in names");
              if('username' in camper){
                console.log("has a user name, camper pushed");
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
      return "http://" + username + ".github.io/CompCamps2018";
    }
  }
});
