<?php
namespace Documents;

use \MongoDate,
    \MongoManager;

/**
 * Base Class to represent Advertisements
 *
 * @author Matthias Pfefferle
 *
 * @Document(collection="advertisement", repositoryClass="Repositories\AdvertisementRepository")
 * @HasLifecycleCallbacks
 * @InheritanceType("SINGLE_COLLECTION")
 */
class Advertisement extends BaseDocument {

  /** 
   * @Id
   */
  protected $id;

  /**
   * The Domain Profile ID
   * 
   * @Field(type="int", name="dp_id")
   */
  protected $domain_profile_id;
  
  /**
   * A list of domains where the ad should be displayed
   * at
   *
   * @Field(type="hash", name="d")
   */
  protected $domains;
  
  /**
   * The user_id of the ad-"owner"
   * (needed for the stats)
   *
   * @Field(type="int", name="owner")
   */
  protected $ad_owner_id;
  
  /**
   * The url to an advertisement image
   *
   * @Field(type="string", name="img")
   */
  protected $ad_image;
  
  /**
   * A link to the advertisement page
   *
   * @Field(type="string", name="link")
   */
  protected $ad_link;
  
  /**
   * Any HTML-snippet
   *
   * @Field(type="string", name="code")
   */
  protected $ad_code;
  
  /**
   * The width of the ad layer
   *
   * @Field(type="int", name="ad_w")
   */
  protected $ad_width;
  
  /**
   * The height of the ad layer
   *
   * @Field(type="int", name="ad_h")
   */
  protected $ad_height;
  
  /**
   * Last changes to the object
   *
   * @Field(type="int", name="u")
   */
  protected $updated_at;
  
  /**
   * The date where the advertisement
   * should show up 
   *
   * @Field(type="int", name="s")
   */
  protected $starting_at;
  
  /**
   * returns all domains as a comma steperated string
   *
   * @return string
   */
  public function getDomainsAsString() {
    return implode(", ", $this->getDomains());
  }
  
  public function setDomains($domains) {
    if (!is_array($domains)) {
      $domains = explode(",", $domains);
      
      $this->domains = $this->trimDomainArray($domains);
    } else {
      $this->domains = $domains;
    }
  }
  
  /**
   * A nicer way to save the object
   */
  public function save() {
    $this->setUpdatedAt(strtotime("now"));

    $dm = MongoManager::getDM();
    $dm->persist($this);
    $dm->flush();
  }
  
  protected function trimDomainArray($domains) {
    $temp = array();
    foreach ($domains as $domain) {
      $temp[] = trim($domain);
    }
    
    return array_unique($temp);
  }
}
