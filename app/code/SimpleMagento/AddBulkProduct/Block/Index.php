<?php


namespace SimpleMagento\AddBulkProduct\Block;


use Magento\Framework\View\Element\Template;
use Magento\Catalog\Api\ProductRepositoryInterface;



    class Index extends Template
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    public function __construct(Template\Context $context, ProductRepositoryInterface $productRepository)
    {
        parent::__construct($context);
        $this->productRepository = $productRepository;
    }

    public function getProductBySku($sku)
    {
        return $this->productRepository->get($sku);
    }

}