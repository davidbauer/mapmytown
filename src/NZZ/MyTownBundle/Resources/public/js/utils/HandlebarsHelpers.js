/**
 * Usage:
 *    span {{t "my.key" }}
 */
Handlebars.registerHelper('t', function(i18n_key) {
  var result = i18n.t(i18n_key);
 
  return new Handlebars.SafeString(result);
});

/**
 * Usage:
 *     {{#tr this key="trans.sample.handlebarsExtended" add="from helper" }}
 *     h6 Some Text
 *     p some paragraph with variable __add__ __addFromContext__
 *     {/tr}
 */
Handlebars.registerHelper('tr', function(context, options) { 
   var opts = i18n.functions.extend(options.hash, context);
   if (options.fn) opts.defaultValue = options.fn(context);
 
   var result = i18n.t(opts.key, opts);
 
   return new Handlebars.SafeString(result);
});

/**
 * Prevent links from firing without having
 * to resort to evt.preventDefault()
 */
Handlebars.registerHelper('noLink', function(url) {
  return new Handlebars.SafeString("javascript:void(0);");
});
