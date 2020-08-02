<?php
namespace Drupal\champions_social\Form;


use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;


class Platform implements FormInterface
{

  public function rebuildForm($form_id, FormStateInterface &$form_state, $old_form = NULL)
  {
    // TODO: Implement rebuildForm() method.
  }

  public function retrieveForm($form_id, FormStateInterface &$form_state)
  {
    // TODO: Implement retrieveForm() method.
  }

  public function processForm($form_id, &$form, FormStateInterface &$form_state)
  {
    // TODO: Implement processForm() method.
  }

  public function prepareForm($form_id, &$form, FormStateInterface &$form_state)
  {

  }

  public function doBuildForm($form_id, &$element, FormStateInterface &$form_state)
  {
    // TODO: Implement doBuildForm() method.
  }

  public function getFormId()
  {
    return 'platform';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['phone_number'] = [
      '#type' => 'tel',
      '#title' => $this->t('Your phone number'),
      '#weight' => 100,
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
  }

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    // TODO: Implement validateForm() method.
  }
}
