(function(w){
    "use strict";
    /* exported loadCSS */
    var asp_loadCSS = function( href, before, media ){
        // Arguments explained:
        // href [REQUIRED] is the URL for your CSS file.
        // before [OPTIONAL] is the element the script should use as a reference for injecting our stylesheet <link> before
        // By default, loadCSS attempts to inject the link after the last stylesheet or script in the DOM. However, you might desire a more specific location in your document.
        // media [OPTIONAL] is the media type or query of the stylesheet. By default it will be 'all'
        var doc = w.document;
        var ss = doc.createElement( "link" );
        var ref;
        if( before ){
            ref = before;
        }
        else {
            var refs = ( doc.body || doc.getElementsByTagName( "head" )[ 0 ] ).childNodes;
            ref = refs[ refs.length - 1];
        }

        var sheets = doc.styleSheets;
        ss.rel = "stylesheet";
        ss.href = href;
        // temporarily set media to something inapplicable to ensure it'll fetch without blocking render
        ss.media = "only x";

        // Inject link
        // Note: the ternary preserves the existing behavior of "before" argument, but we could choose to change the argument to "after" in a later release and standardize on ref.nextSibling for all refs
        // Note: `insertBefore` is used instead of `appendChild`, for safety re: http://www.paulirish.com/2011/surefire-dom-element-insertion/
        ref.parentNode.insertBefore( ss, ( before ? ref : ref.nextSibling ) );
        // A method (exposed on return object for external use) that mimics onload by polling until document.styleSheets until it includes the new sheet.
        var onloadcssdefined = function( cb ){
            var resolvedHref = ss.href;
            var i = sheets.length;
            while( i-- ){
                if( sheets[ i ].href === resolvedHref ){
                    return cb();
                }
            }
            setTimeout(function() {
                onloadcssdefined( cb );
            });
        };

        // once loaded, set link's media back to `all` so that the stylesheet applies once it loads
        ss.onloadcssdefined = onloadcssdefined;
        onloadcssdefined(function() {
            ss.media = media || "all";
        });
        return ss;
    };

    w.asp_loadCSS = asp_loadCSS;

}( window ));

// Trigger async load on document ready
jQuery(function($){
    var arr = [];

    // If something is fishy, abort mission..
    if ( (typeof ASP == "undefined") || (typeof ASP.asp_url == "undefined") )
        return false;

    // Gather the active IDs
    $(".asp_init_data").each(function(index, value){
        var id =  $(this).attr('id').match(/^asp_init_id_(.*)_/)[1];
        arr[id] = true;
    });

    var media_query = "def";

    if ( (typeof ASP != "undefined") && (typeof ASP.media_query != "undefined") )
        media_query = ASP.media_query;

    // If any active instances were found, load the basic JS
    if (arr.length > 0) {
        asp_loadCSS(ASP.asp_url + "css/style.basic.css?mq=" + media_query);
    }

    // Parse through and load only the required CSS files
    for (var i=0;i<arr.length;i++) {
        if (typeof arr[i] != "undefined")
            asp_loadCSS(ASP.asp_url + "css/async/search" + i + ".css?mq=" + media_query);
    }
    
});