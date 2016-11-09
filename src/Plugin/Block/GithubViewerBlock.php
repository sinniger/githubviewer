<?php
namespace Drupal\githubviewer\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;  
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\githubviewer\Service\GithubViewerService;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Github Viewer' Block
 *
 * @Block(
 *   id = "githubviewer_block",
 *   admin_label = @Translation("Displays commits of a specific user and repo from github"),
 * )
 */
class GithubViewerBlock extends BlockBase implements ContainerFactoryPluginInterface {
 	
  private $githubViewer;
  
  public function __construct(array $configuration, $plugin_id, $plugin_definition, GithubViewerService $githubViewer) {  
    parent::__construct($configuration, $plugin_id, $plugin_definition);  
    $this->githubViewer = $githubViewer;
  }  



 public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {  
    return new static(  
      $configuration,  
      $plugin_id,  
      $plugin_definition,  
      $container->get('githubviewer.githubviewerservice')  //TODO: default values are not loaded in the service...
    );  
  }

  
  public function build() {  
    $config = $this->getConfiguration();
    $build = [];
    $build['githubviewer_comits']['#commits'] = json_decode($this->githubViewer->getGithubCommitsByUser($config['repository_owner'], $config['repository_name'], $config['repository_user']));
    $build['githubviewer_comits']['#theme'] = 'github_viewer';
    return $build;  
  }  


   /**
   * {@inheritdoc}
   */
  // public function defaultConfiguration() {
  //   $default_config = \Drupal::config('githubviewer.settings');
  //   return array(
  //     'github_account_user' => $default_config->get('githubviewer.account_user'),
  //     'github_account_password' => $default_config->get('githubviewer.account_password')
  //   );
  // }

  //@see: https://ffwagency.com/blog/drupal-8-services-dependency-injection-and-decoupling-your-code

/**
   * {@inheritdoc}
   */
	public function blockForm($form, FormStateInterface $form_state) {

		$form = parent::blockForm($form, $form_state);
		// Retrieve existing configuration for this block.
		$config = $this->getConfiguration();
		// Add a form field to the existing block configuration form.

    $form['repository_owner'] = array(
      '#type' => 'textfield',
      '#title' => t('Github repository owner:'),
      '#default_value' => isset($config['repository_owner'])? $config['repository_owner'] : 'drupal',
    );

    $form['repository_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Github repository name:'),
      '#default_value' => isset($config['repository_name'])? $config['repository_name'] : 'drupal',
    );
    	$form['repository_user'] = array(
		  '#type' => 'textfield',
		  '#title' => t('Github user name:'),
		  '#default_value' => isset($config['repository_user'])? $config['repository_user'] : 'alex.a.pott@googlemail.com',
    	);
    	return $form;
	}


  /**
   * {@inheritdoc}
   */
	public function blockSubmit($form, FormStateInterface $form_state) {
		// Save our custom settings when the form is submitted.
    $this->setConfigurationValue('repository_owner', $form_state->getValue('repository_owner'));
    $this->setConfigurationValue('repository_name', $form_state->getValue('repository_name'));
    $this->setConfigurationValue('repository_user', $form_state->getValue('repository_user'));
	}


}


