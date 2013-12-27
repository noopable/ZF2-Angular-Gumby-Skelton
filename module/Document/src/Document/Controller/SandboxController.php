<?php
/**
 * トップページ用の暫定的実装である。
 * ページリソースを呼び出せるようにリファクタリングしていく。
 * ページリソースとしての動作と、コントローラーとしての動作の両方を実装する。
 */

namespace Document\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class SandboxController extends AbstractActionController
{
    public function sidenavAction()
    {
        return new ViewModel;
    }
    
    public function createAction()
    {
        //暫定的に、配列を返す
        //これをサービス化する。
        $sl = $this->getServiceLocator();
        if (! $sl->has('Document_Repositories')) {
            $message = "Document_Repositories not found";
            if (isset($this->logger)) {
                $this->logger->log($message);
            }
            else {
                trigger_error($message, E_USER_WARNING);
            }
            return array('error' => ['message' => $message]);
        }
        
        $repositoryManager = $sl->get('Document_Repositories');
        /* @var $repository \Document\Model\Repository\Sandbox   */
        $repository = $repositoryManager->byName('Sandbox');
        
        $sandbox = $repository->create();
        
        $sandbox->fullname = 'foo';
        $result = $repository->save($sandbox);

        return array('item' => $sandbox);
    }

}