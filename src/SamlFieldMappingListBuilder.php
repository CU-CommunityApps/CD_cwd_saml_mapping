<?php declare(strict_types=1);

namespace Drupal\cwd_saml_mapping;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of saml role mappings.
 */
final class SamlFieldMappingListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    $header['field'] = $this->t('Drupal field');
    $header['samlprop'] = $this->t('SAML Property');
    $header['status'] = $this->t('Status');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    $saml_property_mappings = ShibbolethHelper::getMappingArray();
    /** @var \Drupal\cwd_saml_mapping\SamlFieldMappingInterface $entity */
    $row['label'] = $entity->label();
    $row['field'] = $entity->get('field');
    $row['samlprop'] = $saml_property_mappings[$entity->get('samlprop')];
    $row['status'] = $entity->status() ? $this->t('Enabled') : $this->t('Disabled');
    return $row + parent::buildRow($entity);
  }

}
