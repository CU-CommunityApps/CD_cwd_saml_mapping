<?php declare(strict_types=1);

namespace Drupal\cwd_saml_mapping;



class ShibbolethHelper {
  public static function getMappingArray() {
    $mapping_array = [
      "urn:oid:0.9.2342.19200300.100.1.1" => "uid",
      "urn:oid:1.3.6.1.4.1.5923.1.1.1.6" => "eduPersonPrincipalName",
      "urn:oid:1.3.6.1.4.1.5923.1.1.1.9" => "eduPersonScopedAffiliation",
      "urn:oid:1.3.6.1.4.1.5923.1.1.1.7" => "eduPersonEntitlement",
      "urn:oid:1.3.6.1.4.1.5923.1.1.1.1" => "affiliations",
      "urn:oid:1.3.6.1.4.1.5923.1.1.1.5" => "eduPersonPrimaryAffiliation",
      "urn:oid:2.5.4.3" => "cn",
      "urn:oid:2.5.4.4" => "sn",
      "urn:oid:2.5.4.42" => "givenName",
      "urn:oid:2.16.840.1.113730.3.1.241" => "displayName",
      "urn:oid:0.9.2342.19200300.100.1.3" => "mail",
      "urn:oid:1.3.6.1.4.1.5923.1.5.1.1" => "groups",
    ];
    return $mapping_array;
  }

  public static function getAllowedUserNamePropertyArray() {
    $mapping_array = [
      "urn:oid:0.9.2342.19200300.100.1.1" => "uid",
      "urn:oid:0.9.2342.19200300.100.1.3" => "mail",
    ];
    return $mapping_array;
  }
}
