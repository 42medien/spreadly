<?php
/**
 * A filter to set the culture using the browser language
 *
 * This filter is only used on the first request with
 * authenticated == false
 *
 * @author Matthias Pfefferle <matthias@ekaabo.de>
 * @package apps.communipedia.lib
 */
class LanguageFilter extends sfFilter {

  public function execute($filterChain) {
    // Execute this filter only once
    if ($this->isFirstCall()) {
      $sfUser    = $this->getContext()->getUser();

      // check if user is authenticated
      if (!$sfUser->isAuthenticated() && !$sfUser->getAttribute('culture_set')) {
        $languages = $this->getContext()->getRequest()->getLanguages();

        foreach ($languages as $lang) {
          $lang = substr($lang, 0, 2);
          // check if a used language is supported by communipedia
          if (in_array($lang, LanguageTable::getAllLanguageCodesAsArray(true))) {
            $sfUser->setCulture($lang);
            break;
          } else {
            $sfUser->setCulture(LanguageTable::getDefaultLanguage());
          }
        }

        $sfUser->setAttribute('culture_set', true);
      }
    }

    // Execute next filter
    $filterChain->execute();
  }
}