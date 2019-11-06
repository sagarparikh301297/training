<?php
namespace SimpleMagento\CustomAdmin\Controller\Adminhtml\Member;



use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\App\ResponseInterface;

use Magento\Framework\View\Result\PageFactory;
use SimpleMagento\Database\Model\AffiliateMember;



class Save extends Action
{


    /**
     * @var AffiliateMember
     */
    protected $model;
    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;
    /**
     * @var PageFactory
     */
    private $pageFactory;


    public function __construct(
        AffiliateMember $affiliateMember,
        PageFactory $pageFactory,

        RedirectFactory $redirectFactory,
         Action\Context $context)
    {
        parent::__construct($context);

        $this->model = $affiliateMember;
        $this->resultRedirectFactory = $redirectFactory;
        $this->pageFactory = $pageFactory;

    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed("SimpleMagento_CustomAdmin::parent");
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();

        if($data) {
            $member = $this->getRequest()->getParam('id');
            //var_dump($data); exit();
            //var_dump($member = $this->getRequest()->getParam('member'));  exit();
            if(array_key_exists('entity_end', $data)){
                $id = $data['entity_end'];
                $model = $this->model->load($id);
            }

            $model = $this->model->setData($data);
        }
        try{
                $model->save();
                $this->messageManager->addSuccessMessage(__('Affiliate Member Saved Succesfully'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')){
                    return $resultRedirect->setPath('*/*/edit', ['id' =>$model->getId(), '_current' => true]);
                }
            return $resultRedirect->setPath('*/*/index');

        }catch (\Exception $e){
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect->setPath('*/*/index');
    }
}