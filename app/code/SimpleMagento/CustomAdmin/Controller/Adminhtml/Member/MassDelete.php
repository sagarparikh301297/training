<?php


namespace SimpleMagento\CustomAdmin\Controller\Adminhtml\Member;




use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Ui\Component\MassAction\Filter;
use SimpleMagento\Database\Model\ResourceModel\Member\CollectionFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;

class MassDelete extends Action
{


    protected $filter;
    protected $collectionFactory;
    protected $redirectFactory;

    public function __construct(Action\Context $context,
                                Filter $filter,
                                CollectionFactory $collectionFactory,
                                RedirectFactory $redirectFactory)
    {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->redirectFactory = $redirectFactory;
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $size = $collection->getSize();
        foreach ($collection as $item){
            $item->delete();
        }
        $this->messageManager->addSuccessMessage(__('A Total of '.$size.' have been deleted'));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index');
    }
}