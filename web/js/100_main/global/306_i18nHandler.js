/**
 * @combine platform
 */
var i18n = {
  aVars: {},    
  
  init: function(pObject) {
    i18n.aVars = pObject;
  },
  
  get: function(pKey) {
    return i18n.aVars[pKey];  
  },
  
  set: function(pKey, pValue) {
    i18n.aVars[pKey] = pValue;
  }
}