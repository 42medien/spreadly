/**
 * @combine button
 */

/**
 * Class YiidUtils: Helper functions for the yiid-widget
 * @author Karina Mies
 */
var YiidUtils = {

  /**
   * creates the xmlhttprequest-object for the right browser
   * @author Karina Mies
   */
  createXMLHttpRequest: function() {
    var lXhttp = null;
    if (window.ActiveXObject) {
      try {
        // IE 6 and higher
        lXhttp = new ActiveXObject("MSXML2.XMLHTTP");
      } catch (e) {
        try {
          // IE 5
          lXhttp = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (e) {
            lXhttp=false;
          }
      }
    } else if (window.XMLHttpRequest) {
      try {
        // Mozilla, Opera, Safari ...
        lXhttp = new XMLHttpRequest();
      } catch (e) {
        lXhttp=false;
      }
    }
    return lXhttp;
  }
};
