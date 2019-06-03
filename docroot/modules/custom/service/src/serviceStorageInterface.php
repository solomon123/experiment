<?php

namespace Drupal\service;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\service\Entity\serviceInterface;

/**
 * Defines the storage handler class for Service entities.
 *
 * This extends the base storage class, adding required special handling for
 * Service entities.
 *
 * @ingroup service
 */
interface serviceStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Service revision IDs for a specific Service.
   *
   * @param \Drupal\service\Entity\serviceInterface $entity
   *   The Service entity.
   *
   * @return int[]
   *   Service revision IDs (in ascending order).
   */
  public function revisionIds(serviceInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Service author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Service revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\service\Entity\serviceInterface $entity
   *   The Service entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(serviceInterface $entity);

  /**
   * Unsets the language for all Service with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
