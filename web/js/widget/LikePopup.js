/**
 * Generel scripts for the like-settings-popup
 * @author Karina Mies
 * @nocombine widget
 */
var LikePopup = {
  
  aOpener: null,
  
  /**
   * inits the global vars and main functions
   * @author Karina Mies
   */
  init: function() {
    LikePopup.aOpener = window.opener;
    debug.log(window.opener);
    if(LikePopup.aOpener == undefined || LikePopup.aOpener == null) {
      LikePopup.aOpener = opener;
    }
    //debug.log(LikePopup.aOpener);
  },
  
  /**
   * refreshs the opener window (the widget)
   * @author Karina Mies
   */
  refreshParent: function() {
    debug.log('refresh');
    debug.log(LikePopup.aOpener);
    if(LikePopup.aOpener != null) {   
      LikePopup.aOpener.location.reload();
    }
  }
};