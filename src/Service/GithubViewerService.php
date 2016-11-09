<?php

namespace Drupal\githubviewer\Service;

use \Drupal\Core\Config\Config;
use \Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class Github ViewerService.
 * Retrieves the latest commits from a github repository (and optional for a certain user)
 *
 * @package Drupal\githubviewer\Service
 */
class GithubViewerService {


	const GITHUB_BASE_URL = "https://api.github.com/repos/";

	/**
	* When the service is created, inject the http client and the config objects, set the github credentials and the default settings
	*/
	public function __construct(Client $http_client, $config_defaults, $config_credentials) {
		$this->httpClient = $http_client;
		$this->config_defaults = $config_defaults;
		$this->config_credentials = $config_credentials;

		//Github credentials have to be set in the admin interface: /admin/config/system/githubviewer-admin
		$this->github_user = $this->config_credentials->get('github_credentials_user');
		$this->github_password = $this->config_credentials->get('github_credentials_password');
	}

	public function getGithubCommitsByUser($repository_owner=null, $repository_name=null, $repository_user=null) {
		
		$this->_setDefaults($repository_owner, $repository_name, $repository_user);
		
		$query = GithubViewerService::GITHUB_BASE_URL . $this->repository_owner . '/'. $this->repository_name . '/commits?author=' . $this->repository_user;

		$request = $this->httpClient->request('GET',   $query, ['auth' => [$this->github_user, $this->github_password]]);	
		
		return  $request->getBody();
	}

	//use the default settings from githubviewer.settings.yml if none are provided
	private function _setDefaults($repository_owner, $repository_name, $repository_user) {

		$this->repository_owner = !empty($repository_owner) ? $repository_owner : $this->config_defaults->get('githubviewer.repository_owner');
		$this->repository_name = !empty($repository_name) ? $repository_name : $this->config_defaults->get('githubviewer.repository_name');
		$this->repository_user = !empty($repository_user) ? $repository_user : $this->config_defaults->get('githubviewer.repository_user');
	}
}



