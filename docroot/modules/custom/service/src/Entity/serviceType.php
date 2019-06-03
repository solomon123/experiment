<?php

namespace Drupal\service\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Service type entity.
 *
 * @ConfigEntityType(
 *   id = "service_type",
 *   label = @Translation("Service type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\service\serviceTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\service\Form\serviceTypeForm",
 *       "edit" = "Drupal\service\Form\serviceTypeForm",
 *       "delete" = "Drupal\service\Form\serviceTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\service\serviceTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "service_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "service",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/service_type/{service_type}",
 *     "add-form" = "/admin/structure/service_type/add",
 *     "edit-form" = "/admin/structure/service_type/{service_type}/edit",
 *     "delete-form" = "/admin/structure/service_type/{service_type}/delete",
 *     "collection" = "/admin/structure/service_type"
 *   }
 * )
 */
class serviceType extends ConfigEntityBundleBase implements serviceTypeInterface {

  /**
   * The Service type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Service type label.
   *
   * @var string
   */
  protected $label;

}
