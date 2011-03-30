<?php
class IdentityHelper {


  const USER_RELATIONSHIP_STATUS_UNKNOWN = 0;
  const USER_RELATIONSHIP_STATUS_SINGLE = 1;
  const USER_RELATIONSHIP_STATUS_IN_RELATIONSHIP = 2;
  const USER_RELATIONSHIP_STATUS_IN_OPEN_RELATIONSHIP = 3;
  const USER_RELATIONSHIP_STATUS_ENGAGED = 4;
  const USER_RELATIONSHIP_STATUS_MARRIED = 5;
  const USER_RELATIONSHIP_STATUS_COMPLICATED = 6;
  const USER_RELATIONSHIP_STATUS_WIDOWED = 7;

  public static function tranformRelationshipStringToClasskey($pRelationship) {
    $pRelationship = strtolower($pRelationship);

    switch ($pRelationship) {
      case 'single':
        return self::USER_RELATIONSHIP_STATUS_SINGLE;
        break;
      case 'in a relationship':
        return self::USER_RELATIONSHIP_STATUS_IN_RELATIONSHIP;
        break;
      case 'in an open relationship':
        return self::USER_RELATIONSHIP_STATUS_IN_OPEN_RELATIONSHIP;
        break;
      case 'engaged':
        return self::USER_RELATIONSHIP_STATUS_ENGAGED;
        break;
      case 'married':
        return self::USER_RELATIONSHIP_STATUS_MARRIED;
        break;
      case "it's complicated":
        return self::USER_RELATIONSHIP_STATUS_COMPLICATED;
        break;
      case "widowed":
        return self::USER_RELATIONSHIP_STATUS_WIDOWED;
        break;
      default:
        return self::USER_RELATIONSHIP_STATUS_UNKNOWN;

    }
  }

  public static function toHumanName($key) {
     switch ($key) {
      case self::USER_RELATIONSHIP_STATUS_SINGLE:
        return 'single';
        break;
      case self::USER_RELATIONSHIP_STATUS_IN_RELATIONSHIP:
        return 'in a relationship';
        break;
      case self::USER_RELATIONSHIP_STATUS_IN_OPEN_RELATIONSHIP:
        return 'in an open relationship';
        break;
      case self::USER_RELATIONSHIP_STATUS_ENGAGED:
        return 'engaged';
        break;
      case self::USER_RELATIONSHIP_STATUS_MARRIED:
        return 'married';
        break;
      case self::USER_RELATIONSHIP_STATUS_COMPLICATED:
        return "it's complicated";
        break;
      case self::USER_RELATIONSHIP_STATUS_WIDOWED:
        return "widowed";
        break;
      default:
        return "unknown";
    }   
  }

  public static function toMongoKey($key) {
     switch ($key) {
      case self::USER_RELATIONSHIP_STATUS_SINGLE:
        return 'singl';
        break;
      case self::USER_RELATIONSHIP_STATUS_IN_RELATIONSHIP:
        return 'rel';
        break;
      case self::USER_RELATIONSHIP_STATUS_IN_OPEN_RELATIONSHIP:
        return 'ior';
        break;
      case self::USER_RELATIONSHIP_STATUS_ENGAGED:
        return 'eng';
        break;
      case self::USER_RELATIONSHIP_STATUS_MARRIED:
        return 'mar';
        break;
      case self::USER_RELATIONSHIP_STATUS_COMPLICATED:
        return "comp";
        break;
      case self::USER_RELATIONSHIP_STATUS_WIDOWED:
        return "wid";
        break;
      default:
        return "u";
    }   
  }
}