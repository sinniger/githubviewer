<?php
/**
 * @file
 * Contains \Drupal\githubviewer\Form\GitHubViewerAdminForm.
 */
 
namespace Drupal\githubviewer\Form;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
 
/**
 * Configure custom settings for this site.
 */
class GitHubViewerAdminForm extends ConfigFormBase {
 
/**
 * Constructor for ComproCustomForm.
 *
 * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
 * The factory for configuration objects.
 */
 public function __construct(ConfigFactoryInterface $config_factory) {
   parent::__construct($config_factory);
 }
 
/**
 * Returns a unique string identifying the form.
 *
 * @return string
 * The unique string identifying the form.
 */
 public function getFormId() {
   return 'githubviewer_admin_form';
 }
 
/**
 * Gets the configuration names that will be editable.
 *
 * @return array
 * An array of configuration object names that are editable if called in
 * conjunction with the trait's config() method.
 */
 protected function getEditableConfigNames() {
   return ['config.githubviewer'];
 }
 
/**
 * Form constructor.
 *
 * @param array $form
 * An associative array containing the structure of the form.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 * The current state of the form.
 *
 * @return array
 * The form structure.
 */
 public function buildForm(array $form, FormStateInterface $form_state) {
   $githubviewer = $this->config('config.githubviewer');

    $form['githubviewer']['settings'] = array(
     'github_credentials_user' => array(
       '#type' => 'textfield',
       '#title' => t('Github Account User'),
       '#maxlength' => 255,
       '#default_value' => $githubviewer->get('github_credentials_user') ? $githubviewer->get('github_credentials_user') : '',
       '#description' => t('A valid github user.'),
     ),
     'github_credentials_password' => array(
       '#type' => 'textfield',
       '#title' => t('Github Account Password'),
       '#maxlength' => 255,
       '#default_value' => $githubviewer->get('github_credentials_password') ? $githubviewer->get('github_credentials_password') :  '',
       '#description' => t('The password of the github user.'),
     )

   );

   return parent::buildForm($form, $form_state);
 }
 
/**
 * Form submission handler.
 *
 * @param array $form
 * An associative array containing the structure of the form.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 * The current state of the form.
 */
 public function submitForm(array &$form, FormStateInterface $form_state) {
   $this->config('config.githubviewer')
     ->set('github_credentials_user', $form_state->getValue('github_credentials_user'))
     ->set('github_credentials_password', $form_state->getValue('github_credentials_password'))
     ->save();
   parent::submitForm($form, $form_state);
 }
}