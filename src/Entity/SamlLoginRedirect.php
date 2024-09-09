<?php

declare(strict_types=1);

namespace Drupal\cwd_saml_mapping\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\cwd_saml_mapping\SamlLoginRedirectInterface;

/**
 * Defines the saml login redirect entity type.
 *
 * @ConfigEntityType(
 *   id = "saml_login_redirect",
 *   label = @Translation("Saml Login Redirect"),
 *   label_collection = @Translation("Saml Login Redirects"),
 *   label_singular = @Translation("saml login redirect"),
 *   label_plural = @Translation("saml login redirects"),
 *   label_count = @PluralTranslation(
 *     singular = "@count saml login redirect",
 *     plural = "@count saml login redirects",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\cwd_saml_mapping\SamlLoginRedirectDraggableListBuilder",
 *     "form" = {
 *       "add" = "Drupal\cwd_saml_mapping\Form\SamlLoginRedirectForm",
 *       "edit" = "Drupal\cwd_saml_mapping\Form\SamlLoginRedirectForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *   },
 *   config_prefix = "saml_login_redirect",
 *   admin_permission = "administer saml_login_redirect",
 *   links = {
 *     "collection" = "/admin/structure/cwd-login-redirect",
 *     "add-form" = "/admin/structure/cwd-login-redirect/add",
 *     "edit-form" = "/admin/structure/cwd-login-redirect/{saml_login_redirect}",
 *     "delete-form" = "/admin/structure/cwd-login-redirect/{saml_login_redirect}/delete",
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
final class SamlLoginRedirect extends ConfigEntityBase implements SamlLoginRedirectInterface {
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
