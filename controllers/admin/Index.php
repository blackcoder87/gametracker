<?php
/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Gametracker\Controllers\Admin;

use Modules\Gametracker\Mappers\Gametracker as GametrackerMapper;
use Modules\Gametracker\Models\Gametracker as GametrackerModel;
use Modules\Admin\Mappers\Notifications as NotificationsMapper;
use Ilch\Validation;

class Index extends \Ilch\Controller\Admin
{
    public function init()
    {
        $items = [
            [
                'name' => 'manage',
                'active' => false,
                'icon' => 'fa-solid fa-table-list',
                'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'index']),
                [
                    'name' => 'add',
                    'active' => false,
                    'icon' => 'fa-solid fa-circle-plus',
                    'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'treat'])
                ]
            ],
            [
                'name' => 'settings',
                'active' => false,
                'icon' => 'fa-solid fa-gears',
                'url' => $this->getLayout()->getUrl(['controller' => 'settings', 'action' => 'index'])
            ]
        ];

        if ($this->getRequest()->getActionName() === 'treat') {
            $items[0][0]['active'] = true;
        } else {
            $items[0]['active'] = true;
        }

        $this->getLayout()->addMenu(
            'menuGametracker',
            $items
        );
    }

    public function indexAction()
    {
        $gametrackerMapper = new GametrackerMapper();

        $this->getLayout()->getAdminHmenu()
            ->add($this->getTranslator()->trans('menuGametracker'), ['action' => 'index']);

        if ($this->getRequest()->getPost('check_entries')) {
            if ($this->getRequest()->getPost('action') === 'delete') {
                foreach ($this->getRequest()->getPost('check_entries') as $gametrackerId) {
                    $gametrackerMapper->delete($gametrackerId);
                }
            }

            if ($this->getRequest()->getPost('action') === 'setfree') {
                foreach ($this->getRequest()->getPost('check_entries') as $entryId) {
                    $model = new GametrackerModel();
                    $model->setId($entryId)
                        ->setFree(1);
                    $gametrackerMapper->save($model);
                }

                $badge = count($gametrackerMapper->getEntries(['setfree' => 0]));
                if ($badge > 0) {
                    $this->redirect(['action' => 'index', 'showsetfree' => 1]);
                } else {
                    $this->redirect(['action' => 'index']);
                }
            }
        } elseif ($this->getRequest()->getPost('save') && $this->getRequest()->getPost('positions')) {
            $postData = $this->getRequest()->getPost('positions');
            $positions = explode(',', $postData);

            foreach ($positions as $x => $xValue) {
                $gametrackerMapper->updatePositionById($xValue, $x);
            }

            $this->addMessage('saveSuccess');
            $this->redirect(['action' => 'index']);
        }

        if ($this->getRequest()->getParam('showsetfree')) {
            $entries = $gametrackerMapper->getEntries(['setfree' => 0]);
        } else {
            $entries = $gametrackerMapper->getGametrackersBy(['setfree' => 1], ['pos' => 'ASC', 'id' => 'ASC']);
        }

        $badge = count($gametrackerMapper->getEntries(['setfree' => 0]));

        if ($badge == 0) {
            $notificationsMapper = new NotificationsMapper();
            $notificationsMapper->deleteNotificationsByType('gametrackerEntryAwaitingApproval');
        }

        $this->getView()->set('entries', $entries)
            ->set('badge', $badge);
    }

    public function delAction()
    {
        if ($this->getRequest()->isSecure()) {
            $gametrackerMapper = new GametrackerMapper();
            $gametrackerMapper->delete($this->getRequest()->getParam('id'));

            $this->addMessage('deleteSuccess');
        }

        if ($this->getRequest()->getParam('showsetfree')) {
            $this->redirect(['action' => 'index', 'showsetfree' => 1]);
        } else {
            $this->redirect(['action' => 'index']);
        }
    }

    public function setfreeAction()
    {
        if ($this->getRequest()->isSecure()) {
            $gametrackerMapper = new GametrackerMapper();

            $model = new GametrackerModel();
            $model->setId($this->getRequest()->getParam('id'))
                ->setFree(1);
            $gametrackerMapper->save($model);

            $this->addMessage('freeSuccess');
        }

        if ($this->getRequest()->getParam('showsetfree')) {
            $this->redirect(['action' => 'index', 'showsetfree' => 1]);
        } else {
            $this->redirect(['action' => 'index']);
        }
    }

    public function treatAction()
    {
        $gametrackerMapper = new GametrackerMapper();

        if ($this->getRequest()->getParam('id')) {
            $this->getLayout()->getAdminHmenu()
                ->add($this->getTranslator()->trans('menuGametracker'), ['action' => 'index'])
                ->add($this->getTranslator()->trans('edit'), ['action' => 'treat']);

            $this->getView()->set('gametracker', $gametrackerMapper->getGametrackerById($this->getRequest()->getParam('id')));
        } else {
            $this->getLayout()->getAdminHmenu()
                ->add($this->getTranslator()->trans('menuGametracker'), ['action' => 'index'])
                ->add($this->getTranslator()->trans('add'), ['action' => 'treat']);
        }

        if ($this->getRequest()->isPost()) {
            $banner = trim($this->getRequest()->getPost('banner'));
            if (!empty($banner) && strncmp($banner, 'application', 11) === 0) {
                $banner = BASE_URL.'/'.$banner;
            }

            $post = [
                'name' => trim($this->getRequest()->getPost('name')),
                'link' => trim($this->getRequest()->getPost('link')),
                'target' => $this->getRequest()->getPost('target'),
                'banner' => $banner
            ];

            $validation = Validation::create($post, [
                'name' => 'required',
                'link' => 'required|url',
                'target' => 'numeric|min:0|max:1',
                'banner' => 'required|url'
            ]);

            $post['banner'] = trim($this->getRequest()->getPost('banner'));

            if ($validation->isValid()) {
                $model = new GametrackerModel();
                if ($this->getRequest()->getParam('id')) {
                    $model->setId($this->getRequest()->getParam('id'));
                } else {
                    $model->setFree(1);
                }
                $model->setName($post['name'])
                    ->setLink($post['link'])
                    ->setTarget($post['target'])
                    ->setBanner($post['banner']);
                $gametrackerMapper->save($model);

                $this->redirect()
                    ->withMessage('saveSuccess')
                    ->to(['action' => 'index']);
            } else {
                $this->addMessage($validation->getErrorBag()->getErrorMessages(), 'danger', true);
                if ($this->getRequest()->getParam('id')) {
                    $this->redirect()
                        ->withInput()
                        ->withErrors($validation->getErrorBag())
                        ->to(['action' => 'treat', 'id' => $this->getRequest()->getParam('id')]);
                } else {
                    $this->redirect()
                        ->withInput()
                        ->withErrors($validation->getErrorBag())
                        ->to(['action' => 'treat']);
                }
            }
        }
    }
}
