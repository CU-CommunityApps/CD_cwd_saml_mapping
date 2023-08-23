<?php declare(strict_types = 1);

namespace Drupal\cwd_saml_mapping\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\cwd_saml_mapping\Entity\SamlRoleMapping;

/**
 * SAML Role Mapping form.
 */
final class SamlRoleMappingForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {

    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => [SamlRoleMapping::class, 'load'],
      ],
      '#disabled' => !$this->entity->isNew(),
    ];


    $site_roles = \Drupal::entityTypeManager()->getStorage('user_role')->loadMultiple();
    $role_options = [];
    foreach ($site_roles as $roleid => $role) {
      $role_options[$roleid] = $role->label();
    }
    $form['role'] = [
      '#type' => 'select',
      '#title' => $this->t('Role to be assigned'),
      '#options' => $role_options,
      '#default_value' => $this->entity->get('role')
    ];

    $saml_property_mapping = [
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

    $form['samlprop'] = [
      '#type' => 'select',
      '#options' => $saml_property_mapping,
      '#title' => $this->t('SAML Property'),
      '#description' => $this->t('The property from saml_sp that will be used to assign the role.'),
      '#default_value' => $this->entity->get('samlprop'),
    ];

    $form['values'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Accepted Values'),
      '#description' => $this->t('The values that will allow this role to be added. One per line'),
      '#default_value' => $this->entity->get('values'),
    ];
    $form['status'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enabled'),
      '#default_value' => $this->entity->status(),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int {
    $result = parent::save($form, $form_state);
    $message_args = ['%label' => $this->entity->label()];
    $this->messenger()->addStatus(
      match($result) {
        \SAVED_NEW => $this->t('Created new example %label.', $message_args),
        \SAVED_UPDATED => $this->t('Updated example %label.', $message_args),
      }
    );
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

}
