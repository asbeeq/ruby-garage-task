<?php
/**
 *  Main Controller class
 */
namespace Controller;

use Core\Controller;
use Model\Project;
use Model\User;
use Model\Task;

class MainController extends Controller
{

    /**
     * Generate home page
     */
    public function actionIndex()
    {
        $userModel = new User();
        $projectsModel = new Project();
        $taskModel = new Task();

        if ($userModel->getCurrentUser()) {
            $projects = [];
            if ($userProjects = $projectsModel->getUserProjects($userModel->id)) {
                foreach ($userProjects as $project) {
                    $projects[] = [
                        'id' => $project['id'],
                        'name' => $project['name'],
                        'tasks' => $taskModel->getTasks($project['id']),
                    ];
                }

                $this->view->setPageTitle('Task List')->render('main', [
                    'projects' => $projects,
                ]);
            } else {
                $this->view->setPageTitle('Task List')->render('main');
            }
        } else {
            $this->view->setPageTitle('Task List')->render('main');
        }
    }
}