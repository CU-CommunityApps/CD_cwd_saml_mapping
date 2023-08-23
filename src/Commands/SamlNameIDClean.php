<?php

namespace Drupal\cwd_saml_mapping\Commands;

use Exception;
use Drush\Commands\DrushCommands;

/**
 * A Drush commandfile.
 */
class SamlNameIDClean extends DrushCommands {

  /**
   * Command description here.
   *
   * @param array $options
   * @options array $options has the dry run flag
   * @usage cwd_similar_names
   *   - Run command cleanup NameID, used by saml_sp to look up users, from SAML.
   *   - This will make sure all cornell.edu emails are netid emails and not alias emails.
   *   - This should ONLY be run on legacy sites that are converting from using simplesamlphp_auth
   *
   * @command cwd_saml_nameid_clean
   * @aliases cwd-saml-nameid
   */
  public function commandName($options = ['dry-run' => false]) {
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
          if($dryRun) {
            echo "Change: " . $name . " email from '" . $mail . "' to '" . $name . "@cornell.edu'\n";
          } else {
            $user->mail = $name . "@cornell.edu";
            $user->save();
          }
        }
      }
    }
  }
}
