<?php

namespace Drupal\service\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\service\Entity\serviceInterface;

/**
 * Class serviceController.
 *
 *  Returns responses for Service routes.
 */
class serviceController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Service  revision.
   *
   * @param int $service_revision
   *   The Service  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($service_revision) {
    $service = $this->entityManager()->getStorage('service')->loadRevision($service_revision);
    $view_builder = $this->entityManager()->getViewBuilder('service');

    return $view_builder->view($service);
  }

  /**
   * Page title callback for a Service  revision.
   *
   * @param int $service_revision
   *   The Service  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($service_revision) {
    $service = $this->entityManager()->getStorage('service')->loadRevision($service_revision);
    return $this->t('Revision of %title from %date', ['%title' => $service->label(), '%date' => format_date($service->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Service .
   *
   * @param \Drupal\service\Entity\serviceInterface $service
   *   A Service  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(serviceInterface $service) {
    $account = $this->currentUser();
    $langcode = $service->language()->getId();
    $langname = $service->language()->getName();
    $languages = $service->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $service_storage = $this->entityManager()->getStorage('service');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $service->label()]) : $this->t('Revisions for %title', ['%title' => $service->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all service revisions") || $account->hasPermission('administer service entities')));
    $delete_permission = (($account->hasPermission("delete all service revisions") || $account->hasPermission('administer service entities')));

    $rows = [];

    $vids = $service_storage->revisionIds($service);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\service\serviceInterface $revision */
      $revision = $service_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $service->getRevisionId()) {
          $link = $this->l($date, new Url('entity.service.revision', ['service' => $service->id(), 'service_revision' => $vid]));
        }
        else {
          $link = $service->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.service.translation_revert', ['service' => $service->id(), 'service_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.service.revision_revert', ['service' => $service->id(), 'service_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.service.revision_delete', ['service' => $service->id(), 'service_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['service_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
