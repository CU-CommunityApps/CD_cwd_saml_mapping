<?php

namespace Drupal\cwd_saml_mapping;

use Drupal\Core\Config\Entity\DraggableListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a class to build a listing of saml_logout_redirect entities.
 *
 * @see \Drupal\cwd_saml_mapping\Entity\SamlLogoutRedirect
 */
class SamlLogoutRedirectDraggableListBuilder extends DraggableListBuilder {
    
    /**
     * The messenger.
     *
     * @var \Drupal\Core\Messenger\MessengerInterface
     */
    protected $messenger;
    
    /**
     * RoleListBuilder constructor.
     *
     * @param \Drupal\Core\Entity\EntityTypeInterface $entityType
     *   The entity type definition.
     * @param \Drupal\Core\Entity\EntityStorageInterface $storage
     *   The entity storage class.
     * @param \Drupal\Core\Messenger\MessengerInterface $messenger
     *   The messenger.
     */
    public function __construct(EntityTypeInterface $entityType, EntityStorageInterface $storage, MessengerInterface $messenger) {
        parent::__construct($entityType, $storage);
        $this->messenger = $messenger;
    }
    
    /**
     * {@inheritdoc}
     */
    public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
        return new static($entity_type, $container->get('entity_type.manager')
            ->getStorage($entity_type->id()), $container->get('messenger'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'saml_logout_redirect_order';
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildHeader() {
      $header['label'] = t('Redirect name');
      $header['status'] = $this->t('Status');
      $header['visual_weight'] = $this->t('Current weight');
      return $header + parent::buildHeader();
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildRow(EntityInterface $entity) {
      $row['label'] =  $entity->label() . " (" . $entity->get('id') . ")";
      $row['status']['#markup'] = $entity->get('status') ? 'Enabled' : 'Disabled';
      $row['visual_weight']['#markup'] = $entity->get('weight');
      return $row + parent::buildRow($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        parent::submitForm($form, $form_state);
        $this->messenger
            ->addStatus($this->t('The redirect order has been updated.'));
    }
}