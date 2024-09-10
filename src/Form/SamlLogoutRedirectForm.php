<?php

declare(strict_types=1);

namespace Drupal\cwd_saml_mapping\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\cwd_saml_mapping\Entity\SamlLogoutRedirect;

/**
 * SAML Logout Redirect form.
 */
final class SamlLogoutRedirectForm extends EntityForm {

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
        'exists' => [SamlLogoutRedirect::class, 'load'],
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    $form['status'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enabled'),
      '#default_value' => $this->entity->status(),
    ];


    $roles = \Drupal::entityTypeManager()->getStorage('user_role')->loadMultiple();
    $form['roles_selection'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Roles'),
      '#options' => array_map(fn($role) => $role->label(), $roles),
      '#default_value' => $this->entity->get('roles') ? explode(',', $this->entity->get('roles')) : [],
      '#required' => TRUE,
    ];
    
    //Hidden field to make a string out of roles selection
    $form['roles'] = [
      '#type' => 'hidden',
      '#default_value' => $this->entity->get('roles'),
    ];

    $form['redirect'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Redirect'),
      '#description' => $this->t('The URL to redirect to after login. You can use the following tokens. {username} {email} {uid}'),
      '#default_value' => $this->entity->get('redirect'),
      '#required' => TRUE,
    ];
    $form['weight'] = [
      '#type' => 'weight',
      '#title' => $this->t('Weight'),
      '#default_value' => $this->entity->get('weight'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int {
    $roles_string = implode(',', array_filter($form_state->getValues()['roles_selection']));
    $this->entity->set('roles', $roles_string);
    $this->entity->set('weight', (int)$form_state->getValue('weight'));
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
