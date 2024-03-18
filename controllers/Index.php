<?php
/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Gametracker\Controllers;

use Modules\Gametracker\Mappers\Gametracker as GametrackerMapper;
use Modules\Gametracker\Models\Gametracker as GametrackerModel;
use Modules\Admin\Mappers\Notifications as NotificationsMapper;
use Modules\Admin\Models\Notification as NotificationModel;
use Ilch\Validation;

class Index extends \Ilch\Controller\Frontend
{
    public function indexAction()
    {
        $gametrackerMapper = new GametrackerMapper();
        $captchaNeeded = captchaNeeded();

        $this->getLayout()->getTitle()
            ->add($this->getTranslator()->trans('menuGametrackerAdd'));
        $this->getLayout()->getHmenu()
            ->add($this->getTranslator()->trans('menuGametrackerAdd'), ['action' => 'index']);

        if ($this->getRequest()->isPost() && $this->getRequest()->getPost('bot') === '') {
            Validation::setCustomFieldAliases([
                'grecaptcha' => 'token',
            ]);

            $validationRules = [
                'name' => 'required',
                'link' => 'required|url',
                'banner' => 'required|url'
            ];

            if ($captchaNeeded) {
                if (in_array((int)$this->getConfig()->get('captcha'), [2, 3])) {
                    $validationRules['token'] = 'required|grecaptcha:saveGametracker';
                } else {
                    $validationRules['captcha'] = 'required|captcha';
                }
            }

            $validation = Validation::create($this->getRequest()->getPost(), $validationRules);
            if ($validation->isValid()) {
                $model = new GametrackerModel();
                $model->setName($this->getRequest()->getPost('name'))
                    ->setLink($this->getRequest()->getPost('link'))
                    ->setBanner($this->getRequest()->getPost('banner'))
                    ->setFree(0);
                $gametrackerMapper->save($model);

                $notificationsMapper = new NotificationsMapper();
                $notificationModel = new NotificationModel();
                $notificationModel->setModule('gametracker');
                $notificationModel->setMessage($this->getTranslator()->trans('entryAwaitingApproval'));
                $notificationModel->setURL($this->getLayout()->getUrl(['module' => 'gametracker', 'controller' => 'index', 'action' => 'index', 'showsetfree' => 1], 'admin'));
                $notificationModel->setType('gametrackerEntryAwaitingApproval');
                $notificationsMapper->addNotification($notificationModel);

                $this->redirect()
                    ->withMessage('saveSuccess')
                    ->to(['action' => 'index']);
            } else {
                $this->addMessage($validation->getErrorBag()->getErrorMessages(), 'danger', true);
                $this->redirect()
                    ->withInput()
                    ->withErrors($validation->getErrorBag())
                    ->to(['action' => 'index']);
            }
        }

        if ($captchaNeeded) {
            if (in_array((int)$this->getConfig()->get('captcha'), [2, 3])) {
                $googlecaptcha = new \Captcha\GoogleCaptcha($this->getConfig()->get('captcha_apikey'), null, (int)$this->getConfig()->get('captcha'));
                $this->getView()->set('googlecaptcha', $googlecaptcha);
            } else {
                $defaultcaptcha = new \Captcha\DefaultCaptcha();
                $this->getView()->set('defaultcaptcha', $defaultcaptcha);
            }
        }
        $this->getView()->set('captchaNeeded', $captchaNeeded);
    }
}
