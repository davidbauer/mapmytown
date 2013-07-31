(function () {
  "use strict";
  // Get and compile a view's template
  Backbone.View.compileTemplate = function(templateId) {
    var source = $("#template-" + templateId);
    if (source.length > 0) {
      return Handlebars.compile(source.html());
    } else {
      return Handlebars.compile("<div>Template '" + templateId + "' not found</div>");
    }
  }

  Backbone.View.prototype.compileTemplate = function(templateId) {
    return Backbone.View.compileTemplate(templateId);
  }
}());
