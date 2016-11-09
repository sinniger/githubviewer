<?php

namespace Drupal\githubviewer\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Drupal\githubviewer\Service\GithubViewerService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GithubViewerController.
 *
 * @package Drupal\githubviewer\Controller
 */
class GithubViewerController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function __construct(GithubViewerService $githubViewerService) {
    $this->githubViewerService = $githubViewerService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('githubviewer.githubviewerservice')
    );
  }

  /**
   * githubCommitsByUser.
   *
   * @return string
   *   Return github commits by user as JSON.
   */

  public function getGithubCommitsByUser($repository_owner, $repository_name, $repository_user) {
    $response = $this->githubViewerService->getGithubCommitsByUser($repository_owner, $repository_name, $repository_user);
    return new JsonResponse((string) $response);
  }


}
