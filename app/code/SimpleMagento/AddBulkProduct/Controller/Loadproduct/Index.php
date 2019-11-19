<?php


namespace SimpleMagento\AddBulkProduct\Controller\Loadproduct;



use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Controller\Result\JsonFactory;
//use Magento\Catalog\Model\Product;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;
//    /**
//     * @var Product
//     */
//    protected $product;

    public function __construct(Context $context,
                                PageFactory $pageFactory,
                                ProductRepositoryInterface $productRepository,
                                JsonFactory $jsonFactory //Product $product
        )
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->jsonFactory = $jsonFactory;
//        $this->product = $product;
        $this->productRepository = $productRepository;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        if ($this->getRequest()->isAjax()) {
            $getProduct = $this->getRequest()->getParam('get_product');
            $productDetail = $this->productRepository->get($getProduct);
            $data = $productDetail->getTypeInstance()->getConfigurableOptions($productDetail);

            $options = array();

            foreach($data as $attr) {
                foreach ($attr as $p) {
                    $options[$p['attribute_code']][$p['option_title']] = $p['sku'];
                }
            }

            $result = $this->jsonFactory->create();
            $result->setData(['pr'=>$productDetail->getData(), 'cf' => $options]);

            return $result;
        }

        return  $this->pageFactory->create();



    }
}



//        if($getProduct!=0){
//            if($this->product->getIdBySku($getProduct)) {
//                echo 'product exist';
//            }else{
//                echo "not found";
//            }
//        }else{
//            return $this->pageFactory->create();
//        }

//         $productDetail = $this->productRepository->get($getProduct);
//        $layout = $this->getLayout();
//        $block = $layout->getBlock('Index');
//        $block->setFeedback($getProduct);


//return $this->pageFactory->create();