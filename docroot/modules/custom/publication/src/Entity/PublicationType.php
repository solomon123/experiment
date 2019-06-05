<?php

namespace Drupal\publication\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Publication type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "publication_type",
 *   label = @Translation("Publication type"),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\publication\Form\PublicationTypeForm",
 *       "edit" = "Drupal\publication\Form\PublicationTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\publication\PublicationTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer publication types",
 *   bundle_of = "publication",
 *   config_prefix = "publication_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/publication_types/add",
 *     "edit-form" = "/admin/structure/publication_types/manage/{publication_type}",
 *     "delete-form" = "/admin/structure/publication_types/manage/{publication_type}/delete",
 *     "collection" = "/admin/structure/publication_types"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   }
 * )
 */
class PublicationType extends ConfigEntityBundleBase {

  /**
   * The machine name of this publication type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the publication type.
   *
   * @var string
   */
  protected $label;

}
