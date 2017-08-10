function ajax( url, done, json ) {
  var req = new XMLHttpRequest();
  req.open( 'GET', url, true );
  req.send();

  req.onreadystatechange = function() {
    if ( req.readyState != XMLHttpRequest.DONE || req.status == 500 ) {
      return;
    }

    try {
      done( json? JSON.parse( req.responseText ) : req.responseText, req );
    } catch ( e ) {
      window.location = url;
    }
  }

  return req;
}

var BASEURL, headerAs = [], currA;
function ajaxLinks( html ) {

  for ( var elem of html.getElementsByTagName( 'a' ) ) {
    if ( !elem.href.startsWith( BASEURL ) || elem.id == 'lang' ) continue;

    elem.onclick = function( e ) {
      if ( this.href == window.location ) {
        e.preventDefault();
        return false;
      }

      var that = this;
      ajax( that.href +'?ajax', function( res ) {
        if ( currA ) currA.classList.remove( 'current' );
        var newA = headerAs[that.href];
        if ( newA ) {
          newA.classList.add( 'current' );
          currA = newA;
        }

        document.title = res.title;
        if ( res.html != '' ) {
          var main = document.getElementsByTagName( 'main' )[0];
          main.innerHTML = res.html;
          ajaxLinks( main );
        }

        window.history.pushState( { html: res.html, pageTitle: res.title },
          "", that.href );

      }, true );

      e.preventDefault();
      return false;
    }
  }

}

window.onload = function() {
  BASEURL = location.origin || location.protocol + '//' + location.host

  var header = document.getElementsByTagName( 'nav' )[0];
  for ( a of header.getElementsByTagName( 'a' ) ) headerAs[ a.href ] = a;
  currA = header.getElementsByClassName( 'current' )[0];

  ajaxLinks( document );
}

// Replace contents when user goes back in history
window.onpopstate = function( e ) {
  var state = history.state;
  document.title = state.pageTitle;

  if ( currA ) currA.classList.remove( 'current' );
  var newA = headerAs[document.location];
  if ( newA ) {
    newA.classList.add( 'current' );
    currA = newA;
  }

  var main = document.getElementsByTagName( 'main' )[0];
  main.innerHTML = state.html;

  ajaxLinks( main );
}
