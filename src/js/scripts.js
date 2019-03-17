$(document).ready(function () {
             
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