<?php

namespace Drupal\publication\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the publication entity edit forms.
 */
class PublicationForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $entity = $this->getEntity();
    $result = $entity->save();
    $link = $entity->toLink($this->t('View'))->toRenderable();

    $message_arguments = ['%label' => $this->entity->label()];
    $logger_arguments = $message_arguments + ['link' => render($link)];

    if ($result == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New publication %label has been created.', $message_arguments));
      $this->logger('publication')->notice('Created new publication %label', $logger_arguments);
    }
    else {
      $this->messenger()->addStatus($this->t('The publication %label has been updated.', $message_arguments));
      $this->logger('publication')->notice('Updated new publication %label.', $logger_arguments);
    }

    $form_state->setRedirect('entity.publication.canonical', ['publication' => $entity->id()]);
  }

}
