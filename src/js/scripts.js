$(document).ready(function () {
    $.validator.addMethod("regex", function(value, element, regexpr) {          
        return regexpr.test(value);
      }, "Please enter a valid pasword.");    

    var v = $("#myform").validate({
        submitHandler: function(form) {
            $("#myform [type=submit").prop('disabled' , true);
            $("#formMsg").html('בתהליך שליחה ...');

            var formData = new FormData(form);

            $.ajax( {
                type: 'POST',
                url: '/wp-json/contact-form-7/v1/contact-forms/4/feedback',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false
            } ).done( function( data, status, xhr ) {
                $("#myform [type=submit").prop('disabled' , false);
                if(data.status === "mail_sent"){
                    $("#formMsg").html('ההודעה נשלחה, תודה על פנייתך!');
                }
                else{
                    $("#formMsg").html('אירעה שגיאה בשליחת ההודעה.');
                }
            } ).fail( function( xhr, status, error ) {
                $("#myform [type=submit").prop('disabled' , false)
                $("#formMsg").html('אירעה שגיאה בשליחת ההודעה.');
            } );
          },
        rules: {
            fullName: "required",
            email: {
                required: true,
                email: true
              },
              phone: {
                regex: /^$|^\(*\d{2,3}\)*( |-)*\d{7,8}$/
              },
            urlInput: {
                url: true,
                normalizer: function( value ) {
                  var url = value;
           
                  // Check if it doesn't start with http:// or https:// or ftp://
                  if ( url && url.substr( 0, 7 ) !== "http://"
                      && url.substr( 0, 8 ) !== "https://"
                      && url.substr( 0, 6 ) !== "ftp://" ) {
                    // then prefix with http://
                    url = "http://" + url;
                  }
           
                  // Return the new url
                  return url;
                }
              }
          },
          messages: {
            fullName: "נא להזין שם מלא",
            email: {
              required: "נא להזין כתובת דואר אלקטרוני",
              email: "פורמט דואל אלקטרוני לא תקין"
            },
            phone: {
                regex: "נא להזין טלפון תקין"
              },
            urlInput: {
                url: "נא להזין כתובת תקינה"
            }
          }
      });



    function artToUL(name, arr, level, parent) {
        var level = level || 2;
        var parent = parent || wcagDiv;
        console.log("Array:", name);
        var title = $('<h' + (level + '') + '>');
        title.html(name);
        title.appendTo(parent);

        arr.forEach(function (item) {
            //console.log(item);
            //console.log(Array.isArray(item));

            // another array
            if(Array.isArray(item)){


            }
            // object
            else {
                var ul = $('<ul></ul>');

                Object.keys(item).forEach(function (a, b, c) {

                    var li = $('<li></li>');
                        

                    if(Array.isArray(item[a])){
                        // artToUL(name, arr, level, parent)
                        artToUL(a, item[a], level+1, li)
                    }
                    else{
                        li.html(a+ ':'+ item[a]);
                    }
                        li.appendTo(ul);

                })

                ul.appendTo(parent);

            }

     

        });
    }
    /*var wcagDiv = $('<div id="wcag"></div>');
    artToUL('wcag', wcag);
    wcagDiv.prependTo($('main'));*/
});