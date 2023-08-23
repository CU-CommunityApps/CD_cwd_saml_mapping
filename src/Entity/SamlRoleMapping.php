<?php declare(strict_types = 1);

namespace Drupal\cwd_saml_mapping\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\cwd_saml_mapping\SamlRoleMappingInterface;

/**
 * Defines the saml role mapping entity type.
 *
 * @ConfigEntityType(
 *   id = "saml_role_mapping",
 *   label = @Translation("SAML Role Mapping"),
 *   label_collection = @Translation("SAML Role Mappings"),
 *   label_singular = @Translation("saml role mapping"),
 *   label_plural = @Translation("saml role mappings"),
 *   label_count = @PluralTranslation(
 *     singular = "@count saml role mapping",
 *     plural = "@count saml role mappings",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\cwd_saml_mapping\SamlRoleMappingListBuilder",
 *     "form" = {
 *       "add" = "Drupal\cwd_saml_mapping\Form\SamlRoleMappingForm",
 *       "edit" = "Drupal\cwd_saml_mapping\Form\SamlRoleMappingForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *   },
 *   config_prefix = "saml_role_mapping",
 *   admin_permission = "administer saml_role_mapping",
 *   links = {
 *     "collection" = "/admin/structure/saml-role-mapping",
 *     "add-form" = "/admin/structure/saml-role-mapping/add",
 *     "edit-form" = "/admin/structure/saml-role-mapping/{saml_role_mapping}",
 *     "delete-form" = "/admin/structure/saml-role-mapping/{saml_role_mapping}/delete",
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "role",
 *     "samlprop",
 *     "values",
 *   },
 * )
 */
final class SamlRoleMapping extends ConfigEntityBase implements SamlRoleMappingInterface {
  protected string $id;
  protected string $label;
  protected string $role;
  protected string $samlprop;
  protected string $values;
}
