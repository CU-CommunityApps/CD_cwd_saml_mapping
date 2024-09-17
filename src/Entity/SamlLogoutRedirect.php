<?php

declare(strict_types=1);

namespace Drupal\cwd_saml_mapping\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\cwd_saml_mapping\SamlLogoutRedirectInterface;

/**
 * Defines the saml logout redirect entity type.
 *
 * @ConfigEntityType(
 *   id = "saml_logout_redirect",
 *   label = @Translation("SAML Logout Redirect"),
 *   label_collection = @Translation("SAML Logout Redirects"),
 *   label_singular = @Translation("saml logout redirect"),
 *   label_plural = @Translation("saml logout redirects"),
 *   label_count = @PluralTranslation(
 *     singular = "@count saml logout redirect",
 *     plural = "@count saml logout redirects",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\cwd_saml_mapping\SamlLogoutRedirectDraggableListBuilder",
 *     "form" = {
 *       "add" = "Drupal\cwd_saml_mapping\Form\SamlLogoutRedirectForm",
 *       "edit" = "Drupal\cwd_saml_mapping\Form\SamlLogoutRedirectForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *   },
 *   config_prefix = "saml_logout_redirect",
 *   admin_permission = "administer saml_logout_redirect",
 *   links = {
 *     "collection" = "/admin/config/people/cwd-saml-mapping-config/saml-logout-redirect",
 *     "add-form" = "/admin/config/people/cwd-saml-mapping-config/saml-logout-redirect/add",
 *     "edit-form" = "/admin/config/people/cwd-saml-mapping-config/saml-logout-redirect/{saml_logout_redirect}",
 *     "delete-form" = "/admin/config/people/cwd-saml-mapping-config/saml-logout-redirect/{saml_logout_redirect}/delete",
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "weight" = "weight",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "roles",
 *     "redirect",
 *     "weight"
 *   },
 * )
 */
final class SamlLogoutRedirect extends ConfigEntityBase implements SamlLogoutRedirectInterface {
  /**
   * The example ID.
   */
  protected string $id;

  /**
   * The example label.
   */
  protected string $label;

  /**
   * The example roles.
   */
  protected string $roles;

  /**
   * The example redirect.
   */
  protected string $redirect;

  /**
   * The example weight.
   */
  protected int $weight;


}
