<?php
namespace Drupal\githubviewer\Service;

use Drupal\githubviewer\Service\GithubViewerService as GithubViewerService;


class GithubViewerServiceFactory {
  
  static function create($client, $config) {
  
    return new GithubViewerService($client, $config->get('githubviewer.settings'), $config->get('config.githubviewer'));
  }
}