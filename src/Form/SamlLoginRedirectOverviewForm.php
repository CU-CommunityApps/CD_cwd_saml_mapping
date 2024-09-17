<?php

declare(strict_types=1);

namespace Drupal\cwd_saml_mapping\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\cwd_saml_mapping\Entity\SamlLoginRedirect;
use Drupal\Component\DependencyInjection\ContainerInterface;

/**
 * CWD Login Redirect form.
 */
final class SamlLoginRedirectOverviewForm extends FormBase {

  
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
      return 'bill_bop_form';
  }
  
  /**
   * Builds the simple tabledrag form.
   *
   * @param array $form
   *   Render array representing from.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Current form state.
   *
   * @return array
   *   The render array defining the elements of the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
      $form['table-row'] = [
          '#type' => 'table',
          '#header' => [
              $this->t('Name'),
              $this->t('Description'),
              $this->t('Weight'),
          ],
          '#empty' => $this->t('Sorry, There are no items!'),
          // TableDrag: Each array value is a list of callback arguments for
          // drupal_add_tabledrag(). The #id of the table is automatically
          // prepended; if there is none, an HTML ID is auto-generated.
          '#tabledrag' => [
              [
                  'action' => 'order',
                  'relationship' => 'sibling',
                  'group' => 'table-sort-weight',
              ],
          ],
      ];

      $form['table-row']['bill']['#attributes']['class'][] = 'draggable';
          // TableDrag: Sort the table row according to its existing/configured
          // weight.
          $form['table-row']['bill']['#weight'] = 1;
          // Some table columns containing raw markup.
          $form['table-row']['bill']['name'] = [
              '#markup' => 'bill',
          ];
          $form['table-row']['bill']['description'] = [
              '#type' => 'textfield',
              '#required' => TRUE,
              '#default_value' => 'somthing',
          ];

      return $form;
      // // get all saml_login_redirect entities with status with entity service
      // $results = \Drupal::entityTypeManager()
      //     ->getStorage('saml_login_redirect')
      //     ->loadByProperties(['status' => 1]);
      // dd($results);

      

  
      foreach ($results as $row) {
          // TableDrag: Mark the table row as draggable.
          $form['table-row'][$row->id]['#attributes']['class'][] = 'draggable';
          // TableDrag: Sort the table row according to its existing/configured
          // weight.
          $form['table-row'][$row->id]['#weight'] = $row->weight;
          // Some table columns containing raw markup.
          $form['table-row'][$row->id]['name'] = [
              '#markup' => $row->name,
          ];
          $form['table-row'][$row->id]['description'] = [
              '#type' => 'textfield',
              '#required' => TRUE,
              '#default_value' => $row->description,
          ];
          // TableDrag: Weight column element.
          $form['table-row'][$row->id]['weight'] = [
              '#type' => 'weight',
              '#title' => $this->t('Weight for @title', [
                  '@title' => $row->name,
              ]),
              '#title_display' => 'invisible',
              '#default_value' => $row->weight,
              // Classify the weight element for #tabledrag.
'#attributes' => [
                  'class' => [
                      'table-sort-weight',
                  ],
              ],
          ];
      }
      $form['actions'] = [
          '#type' => 'actions',
      ];
      $form['actions']['submit'] = [
          '#type' => 'submit',
          '#value' => $this->t('Save All Changes'),
      ];
      $form['actions']['cancel'] = [
          '#type' => 'submit',
          '#value' => 'Cancel',
          '#attributes' => [
              'title' => $this->t('Return to TableDrag Overview'),
          ],
          '#submit' => [
              '::cancel',
          ],
          '#limit_validation_errors' => [],
      ];
      return $form;
  }
  
  /**
   * Form submission handler for the 'Return to' action.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function cancel(array &$form, FormStateInterface $form_state) {
      // $form_state->setRedirect('tabledrag_example.description');
  }
  
  /**
   * Form submission handler for the simple form.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
      // Because the form elements were keyed with the item ids from the database,
      // we can simply iterate through the submitted values.
      // $submission = $form_state->getValue('table-row');
      // foreach ($submission as $id => $item) {
      //     $this->database
      //         ->update('tabledrag_example')
      //         ->fields([
      //         'weight' => $item['weight'],
      //         'description' => $item['description'],
      //     ])
      //         ->condition('id', $id, '=')
      //         ->execute();
      // }
  }

}