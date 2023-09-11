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

    $form['hide_drupal_login'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide Drupal Login in all envs.'),
      '#default_value' => $config->get('hide_drupal_login'),
    ];

    $form['hide_drupal_login_prod'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide Drupal Login in Prod.'),
      '#default_value' => $config->get('hide_drupal_login_prod'),
    ];

    $form['sso_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Text for Single Sign On login message.'),
      '#default_value' => $config->get('sso_text'),
    ];
    $form['drupal_login_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Text for Drupal login message.'),
      '#default_value' => $config->get('drupal_login_text'),
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
    $ignore = ["submit", "form_build_id", "form_token", "form_id", "op"];
    $config = $this->config('cwd_saml_mapping.config_form');
    foreach($form_state->getValues() as $key => $value) {
      if(!in_array($key,$ignore)) {
        $config->set($key,$value);
      }
    }
    $config->save();
  }
}
