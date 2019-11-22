<?php


namespace SimpleMagento\AddBulkProduct\Controller\Loadproduct;



use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Catalog\Model\Product;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;


class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;
    /**
     * @var ProductRepository
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
    /**
     * @var Configurable
     */
    protected $configurable;
//    /**
//     * @var ProductRepositoryInterface
//     */
//    protected $productRepositoryinterface;


    public function __construct(Context $context,
                                PageFactory $pageFactory,
                                ProductRepository $productRepository,
//                                ProductRepositoryInterface $productRepositoryinterface,
                                JsonFactory $jsonFactory,
//                                Product $product
                                Configurable $configurable
        )
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->jsonFactory = $jsonFactory;
        $this->productRepository = $productRepository;
//        $this->product = $product;
        $this->configurable = $configurable;
//        $this->productRepositoryinterface = $productRepositoryinterface;
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
//            $productDetail = $this->productRepositoryinterface->get($getProduct);
//           try{
               $productDetail = $this->productRepository->get($getProduct);
               $data['name'] = $productDetail->getName();
               $data['id'] = $productDetail->getId();
               $data['sku'] = $productDetail->getSku();
               $data['price'] = $productDetail->getFinalPrice();
               $data['stock'] = $productDetail->getQuantityAndStockStatus();
               $data['config']= $this->configurable->getConfigurableAttributesAsArray($productDetail);

               $result = $this->jsonFactory->create();
               $result->setData($data);
               return $result;
//           }catch (\Exception $e){
//               echo $e->getMessage();
//           }


//            $productType = $productDetail->getTypeId();
//            if( $productType == 'configurable') {

//                $data = $productDetail->getTypeInstance()->getConfigurableOptions($productDetail);
//
//                $options = array();
//
//                foreach ($data as $attr) {
//                    foreach ($attr as $p) {
//                        $options[$p['attribute_code']][$p['option_title']] = $p['sku'];
//                    }
//                }
//
//                $result = $this->jsonFactory->create();
//                $result->setData(['pr' => $productDetail->getData(), 'cf' => $options]);
//
//                return $result;
//            } else{
//                exit();
//                }
        }

        return  $this->pageFactory->create();



    }
}

