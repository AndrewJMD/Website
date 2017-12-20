function Template (f) {
  this.file = file;
  this.t = "";
  this.r = /{{\s?(.+?)\s?}}/g;
  $.ajax({
    url: 'templates/'+f,
    type: 'get',
    async: false,
    context: this,
    success: function(h) {
      this.t = h;
    }
  });
}

Template.prototype.exec = function(d) {
  var m;
  var o = this.t;
  while ((m = this.r.exec(this.t)) !== null) {
      if (m.index === this.r.lastIndex) {
          this.r.lastIndex++;
      }
      o = o.replace(m[0],d[(m[1])]);
  }
  return o;
};
