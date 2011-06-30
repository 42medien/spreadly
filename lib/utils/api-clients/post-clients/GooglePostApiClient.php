<?php
/**
 * Api to post google buzz status messages
 *
 * @author Matthias Pfefferle
 */
class GooglePostApiClient extends PostApi {

  public function generateMessage($pActivity) {
    $lUrl = $pActivity->generateUrlWithClickbackParam($this->onlineIdentity);
    $lTitle = $pActivity->getTitle();

    if ($pActivity->getComment()) {
      $lDescription = $pActivity->getComment();
    } elseif ($pActivity->getDescr()) {
      $lDescription = $pActivity->getDescr();
    } else {
      $lDescription = $lUrl;
    }

    $lPhoto = $pActivity->getThumb();

    $lPostBody = array();

    $lPostBody["data"] = array("object" =>
      array("type" => "note",
            "content" => $lDescription,
            "links" => array("alternate" => array(array("href" => $lUrl))),
            "attachments" => array(
              array("type" => "photo",
                    "links" => array("enclosure" => array(array("href" => $lPhoto)),
                                     "alternate" => array(array("href" => $lUrl)))
              ),
              array("type" => "article",
                    "title" => $lTitle,
                    "links" => array("alternate" => array(array("href" => $lUrl)))
              )
            )
      )
    );

    return json_encode($lPostBody);
  }

  protected function handleResponse($pResponse) {
    parent::handleResponse($pResponse);
    $lResponse = json_decode($pResponse, true);

    if (!array_key_exists("error", $lResponse)) {
      return;
    }

    $lError = new Documents\ApiErrorLog();

    $lError->setCode($lResponse['error']['code']);
    $lError->setMessage($lResponse['error']['message']);
    $lError->setOiId($this->onlineIdentity->getId());
    $lError->setUId($this->onlineIdentity->getUserId());

    $dm = MongoManager::getDM();
    $dm->persist($lError);
    $dm->flush();
  }
}