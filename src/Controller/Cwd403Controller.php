<?php
/**
 * @file
 * Contains \Drupal\cwd_saml_mapping\Controller\Cwd403Controller.
 */
namespace Drupal\cwd_saml_mapping\Controller;
class Cwd403Controller {
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => $this->get_markup(),
    );
  }
  protected function get_markup() {
    $not_logged_in = \Drupal::currentUser()->isAnonymous();
    $config = \Drupal::config('cwd_saml_mapping.config_form');
    if($not_logged_in) {
      $markup = "";
      //Custom message for the 403 page when not logged in
      if($config->getRawData()['403_custom_text']) {
        $message = $config->getRawData()['403_custom_text'];
        $markup = $message;
      }

      //Add saml_sp IDP links to the page
      $form = \Drupal::formBuilder()->getForm(\Drupal\user\Form\UserLoginForm::class);
      $render = \Drupal::service('renderer');
      $header_text = $config->getRawData()['sso_text'] ?? "Login with your NetID";
      $markup .= '<hr/><h2>' . $header_text . ':</h2>' . $render->renderPlain($form['saml_sp_drupal_login_links']);

      //Add link to Drupal login form if we should
      $config = \Drupal::config('cwd_saml_mapping.config_form');
      $hide_drupal_login_prod = $config->getRawData()['hide_drupal_login_prod'] ?? false;
      $is_prod_and_hide = (isset($_ENV['PANTHEON_ENVIRONMENT']) && $_ENV['PANTHEON_ENVIRONMENT'] === 'live' && $hide_drupal_login_prod);
      $hide_drupal_login = $config->getRawData()['hide_drupal_login'] ?? false;
      if (!$hide_drupal_login && !$is_prod_and_hide) {
        $header_text = $config->getRawData()['drupal_login_text'] ? $config->getRawData()['drupal_login_text'] : "Login into Drupal";
        $login_button_text = $config->getRawData()['local_login_text'] ? $config->getRawData()['local_login_text'] : "Log in";
        $markup .= '<hr/><h2>' . $header_text . ':</h2>';
        $current_path = \Drupal::request()->getRequestUri();
        $markup .= '<p><a class="link-button" href="/user/login?destination=' . $current_path . '">'.$login_button_text.'</a></p>';
      }

      //Return final markup
      return $markup;
    }
    else {
      if($config->getRawData()['403_custom_logged_in_text']) {
        return $config->getRawData()['403_custom_logged_in_text'];
      } else {
        return '<p>You don\'t have access to this page.</p>';
      }
    }
  }
}
