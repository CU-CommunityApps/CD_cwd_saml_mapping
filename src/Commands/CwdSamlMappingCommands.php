<?php

namespace Drupal\cwd_saml_mapping\Commands;

use Exception;
use Drush\Commands\DrushCommands;

/**
 * A Drush commandfile.
 */
class CwdSamlMappingCommands extends DrushCommands {

  /**
   * Command to clean up emails in Drupal accounts to match incoming NameID field from shibboleth.
   *
   * @param array $options
   * @options array $options has the dry run flag
   * @usage cwd_saml_mapping:name-id-clean
   *   - Run command nameIdClean to cleanup NameID, used by saml_sp to look up users, from SAML.
   *   - This will make sure all cornell.edu emails are netid emails and not alias emails.
   *   - This should ONLY be run on legacy sites that are converting from using simplesamlphp_auth
   *
   * @command cwd_saml_mapping:name-id-clean
   * @aliases cwd-nidc
   */
  public function nameIdClean($options = ['dry-run' => false]) {
    $dryRun = $options['dry-run'];
    $userStorage = \Drupal::entityTypeManager()->getStorage('user');
    $query = $userStorage->getQuery();
    $uids = $query->condition('status', '1')->accessCheck(false)->execute();
    $users = $userStorage->loadMultiple($uids);

    foreach ($users as $user) {
      $name = strtolower($user->get('name')->getValue()[0]["value"]);
      $mail = strtolower($user->get('mail')->getValue()[0]["value"] ?? "");
      if (str_contains($mail, 'cornell.edu')) {
        if ($name == 'cd_admin') {
          continue;
        }
        if (!str_contains($mail, $name)) {
          if ($dryRun) {
            echo "Change: " . $name . " email from '" . $mail . "' to '" . $name . "@cornell.edu'\n";
          }
          else {
            $user->mail = $name . "@cornell.edu";
            $user->save();
          }
        }
      }
    }
  }
}
