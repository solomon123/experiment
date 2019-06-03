<?php

namespace Drupal\product;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Product entities.
 *
 * @ingroup product
 */
class ProductListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Product ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\product\Entity\Product */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.product.edit_form',
      ['product' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
