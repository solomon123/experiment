<?php

namespace Drupal\publication;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a publication entity type.
 */
interface PublicationInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Gets the publication title.
   *
   * @return string
   *   Title of the publication.
   */
  public function getTitle();

  /**
   * Sets the publication title.
   *
   * @param string $title
   *   The publication title.
   *
   * @return \Drupal\publication\PublicationInterface
   *   The called publication entity.
   */
  public function setTitle($title);

  /**
   * Gets the publication creation timestamp.
   *
   * @return int
   *   Creation timestamp of the publication.
   */
  public function getCreatedTime();

  /**
   * Sets the publication creation timestamp.
   *
   * @param int $timestamp
   *   The publication creation timestamp.
   *
   * @return \Drupal\publication\PublicationInterface
   *   The called publication entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the publication status.
   *
   * @return bool
   *   TRUE if the publication is enabled, FALSE otherwise.
   */
  public function isEnabled();

  /**
   * Sets the publication status.
   *
   * @param bool $status
   *   TRUE to enable this publication, FALSE to disable.
   *
   * @return \Drupal\publication\PublicationInterface
   *   The called publication entity.
   */
  public function setStatus($status);

}
