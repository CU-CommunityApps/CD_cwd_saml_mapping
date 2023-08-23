<?php

namespace Drupal\cwd_saml_mapping\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\Entity;

/**
 * Class AutoTranslationForm.
 */
class CWDSamlMappingConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'cwd_saml_mapping.config_form',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'cwd_saml_mapping_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('cwd_saml_mapping.config_form');
    $form['use_prod_in_saml'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use Production Shibboleth on the Live/Production site.'),
      '#default_value' => $config->get('use_prod_in_saml'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('cwd_saml_mapping.config_form')
      ->set('use_prod_in_saml', $form_state->getValue('use_prod_in_saml'))
      ->save();
  }
}
