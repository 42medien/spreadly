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
    $lComment = $pActivity->getComment();
    $lPhoto = $pActivity->getThumb();

    $lPostBody = array();

    $lPostBody["data"] = array("object" =>
      array("type" => "note",
            "content" => $lComment,
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
}