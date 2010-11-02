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

}