 jQuery.validator.addMethod("complete_url", function(val, elem) {
    // if no url, don't do anything
    if (val.length == 0) { return true; }
 
    // if user has not entered http:// https:// or ftp:// assume they mean http://
    if(!/^(https?|ftp):///i.test(val)) {
        val = 'http://'+val; // set both the value
        $(elem).val(val); // also update the form element
    }
    // now check if valid url
    // http://docs.jquery.com/Plugins/Validation/Methods/url
    // contributed by Scott Gonzalez: http://projects.scottsplayground.com/iri/
    return /^(https?|ftp)://(((([a-z]|d|-|.|_|~|[u00A0-uD7FFuF900-uFDCFuFDF0-uFFEF])|(%[da-f]{2})|[!$&amp;'()*+,;=]|:)*@)?(((d|[1-9]d|1dd|2[0-4]d|25[0-5]).(d|[1-9]d|1dd|2[0-4]d|25[0-5]).(d|[1-9]d|1dd|2[0-4]d|25[0-5]).(d|[1-9]d|1dd|2[0-4]d|25[0-5]))|((([a-z]|d|[u00A0-uD7FFuF900-uFDCFuFDF0-uFFEF])|(([a-z]|d|[u00A0-uD7FFuF900-uFDCFuFDF0-uFFEF])([a-z]|d|-|.|_|~|[u00A0-uD7FFuF900-uFDCFuFDF0-uFFEF])*([a-z]|d|[u00A0-uD7FFuF900-uFDCFuFDF0-uFFEF]))).)+(([a-z]|[u00A0-uD7FFuF900-uFDCFuFDF0-uFFEF])|(([a-z]|[u00A0-uD7FFuF900-uFDCFuFDF0-uFFEF])([a-z]|d|-|.|_|~|[u00A0-uD7FFuF900-uFDCFuFDF0-uFFEF])*([a-z]|[u00A0-uD7FFuF900-uFDCFuFDF0-uFFEF]))).?)(:d*)?)(/((([a-z]|d|-|.|_|~|[u00A0-uD7FFuF900-uFDCFuFDF0-uFFEF])|(%[da-f]{2})|[!$&amp;'()*+,;=]|:|@)+(/(([a-z]|d|-|.|_|~|[u00A0-uD7FFuF900-uFDCFuFDF0-uFFEF])|(%[da-f]{2})|[!$&amp;'()*+,;=]|:|@)*)*)?)?(?((([a-z]|d|-|.|_|~|[u00A0-uD7FFuF900-uFDCFuFDF0-uFFEF])|(%[da-f]{2})|[!$&amp;'()*+,;=]|:|@)|[uE000-uF8FF]|/|?)*)?(#((([a-z]|d|-|.|_|~|[u00A0-uD7FFuF900-uFDCFuFDF0-uFFEF])|(%[da-f]{2})|[!$&amp;'()*+,;=]|:|@)|/|?)*)?$/i.test(val);
});

 $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
      });

jQuery.validator.addMethod("alphanumspecial", function (value, element) { return this.optional(element) || /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i.test(value); }, "Combination of alphabets,special characters & numeric values required.");

// validation for letters only
jQuery.validator.addMethod("lettersonly", function (value, element) {
    return this.optional(element) || /^[a-z\s]+$/i.test(value);
}, "Character only.");

//  validation for charater, comma and .
jQuery.validator.addMethod("charDotComma", function (value, element) {
    return this.optional(element) || /^[a-z,.\s]+$/i.test(value);
}, "Character only.");

// validation for alphanumeric character with spaces allowed
jQuery.validator.addMethod("alphanumspace", function (value, element) {
    return this.optional(element) || /^[a-z0-9_ ]+$/i.test(value);
}, "Can only contain only letters, numbers and spaces.");

// validation for alphanumeric character without spaces
jQuery.validator.addMethod("alphanumeric", function (value, element) {
    return this.optional(element) || /^[a-z0-9.\-]+$/i.test(value);
}, "Can only contain only letters and numbers.");

// validation for combination of alphanumeric and special character without spaces
jQuery.validator.addMethod("alphanumspecial", function (value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i.test(value);
}, "Combination of alphabets,special characters & numeric values required.");

// validation for allowing decimal values for 2 places

jQuery.validator.addMethod("numDecimal", function (value, element) {
    return this.optional(element) || /^\d{0,4}(\.\d{0,2})?$/i.test(value);
}, "Only two decimal places allowed.");

// validation for month MM format