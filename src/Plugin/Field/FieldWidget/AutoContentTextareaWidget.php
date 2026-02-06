<?php

declare(strict_types=1);

namespace Drupal\droptica_field_widget_actions_demo\Plugin\Field\FieldWidget;

use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Field\Plugin\Field\FieldWidget\StringTextareaWidget;

#[FieldWidget(
  id: 'droptica_auto_content_textarea',
  label: new TranslatableMarkup('Auto content textarea'),
  field_types: ['string', 'string_long'],
)]
final class AutoContentTextareaWidget extends StringTextareaWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $wrapper_id = Html::getUniqueId(sprintf(
      'droptica-auto-content-%s-%s',
      $this->fieldDefinition->getName(),
      (string) $delta
    ));

    $element['#prefix'] = '<div id="' . $wrapper_id . '">';
    $element['#suffix'] = '</div>';

    $element['generate'] = [
      '#type' => 'submit',
      '#value' => $this->t('Generate'),
      '#name' => $wrapper_id . '-generate',
      '#submit' => [[static::class, 'generateSubmit']],
      '#ajax' => [
        'callback' => [static::class, 'generateAjax'],
        'wrapper' => $wrapper_id,
        'event' => 'click',
      ],
      '#limit_validation_errors' => [],
      '#executes_submit_callback' => FALSE,
      '#field_name' => $this->fieldDefinition->getName(),
      '#delta' => $delta,
      '#field_parents' => $element['#field_parents'],
      '#attributes' => ['class' => ['button', 'button--small']],
    ];

    return $element;
  }

  /**
   * Submit handler for the generate button.
   */
  public static function generateSubmit(array &$form, FormStateInterface $form_state): void {
    $trigger = $form_state->getTriggeringElement();
    $parents = array_merge(
      $trigger['#field_parents'],
      [$trigger['#field_name'], $trigger['#delta'], 'value']
    );

    $current_value = $form_state->getValue($parents);
    $generator = \Drupal::service('droptica_field_widget_actions_demo.auto_content_generator');
    $generated = $generator->generate(is_string($current_value) ? $current_value : '');

    $form_state->setValue($parents, $generated);
    $user_input = $form_state->getUserInput();
    NestedArray::setValue($user_input, $parents, $generated);
    $form_state->setUserInput($user_input);
    $form_state->setRebuild(TRUE);
  }

  /**
   * Ajax callback to redraw the widget after generation.
   */
  public static function generateAjax(array &$form, FormStateInterface $form_state): array {
    $trigger = $form_state->getTriggeringElement();
    $parents = array_merge(
      $trigger['#field_parents'],
      [$trigger['#field_name'], $trigger['#delta']]
    );

    return NestedArray::getValue($form, $parents) ?? $form;
  }

}
