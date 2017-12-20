function Template (file) {
  this.file = file;
  this.template = "";
  this.regex = /{{\s?(.+?)\s?}}/g;
  $.ajax({
    url: 'templates/'+file,
    type: 'get',
    async: false,
    context: this,
    success: function(html) {
      this.template = html;
    }
  });
}

Template.prototype.exec = function(data) {
  var m;
  var output = this.template;
  while ((m = this.regex.exec(this.template)) !== null) {
      // This is necessary to avoid infinite loops with zero-width matches
      if (m.index === this.regex.lastIndex) {
          this.regex.lastIndex++;
      }
      output = output.replace(m[0],data[(m[1])]);
  }
  return output;
};
