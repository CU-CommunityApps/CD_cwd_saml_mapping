<?php

namespace Drupal\cwd_saml_mapping\Form;

use Drupal\Core\Entity\Entity;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\cwd_saml_mapping\ShibbolethHelper;

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
    $saml_property_mapping = ShibbolethHelper::getAllowedUserNamePropertyArray();
    $form['username_saml_prop'] = [
      '#type' => 'select',
      '#options' => $saml_property_mapping,
      '#title' => $this->t('SAML Property for Username'),
      '#description' => $this->t('The property from saml_sp that will be used as the Username.'),
      '#default_value' => $config->get('username_saml_prop'),
    ];
    $form['use_prod_in_saml'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use Production Shibboleth on the Live/Production site.'),
      '#default_value' => $config->get('use_prod_in_saml'),
    ];
    $form['show_all_idps'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show All IDPs to that can be used.'),
      '#default_value' => $config->get('show_all_idps'),
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
      ->set('show_all_idps', $form_state->getValue('show_all_idps'))
      ->set('username_saml_prop', $form_state->getValue('username_saml_prop'))
      ->save();
  }
}
