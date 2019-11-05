<?php


namespace SimpleMagento\Attribute\Model\Plugin;
use SimpleMagento\Database\Api\Data\AffiliateMemberExtensionFactory;
use SimpleMagento\Database\Model\AffiliateMemberRepository;

class CodeAttributeExtension
{
    protected $affiliateMemberExtensionFactory;
    public function __construct(AffiliateMemberExtensionFactory $affiliateMemberExtensionFactory)
    {
        $this->affiliateMemberExtensionFactory = $affiliateMemberExtensionFactory;
    }

    public function aroundGetAffiliateMemberById(AffiliateMemberRepository $affiliateMemberRepository, \Closure $proceed, $id){
        $model = $proceed($id);
        $extensionAttributes = $model->getExtensionAttributes();
        if($extensionAttributes == null){
            $extensionAttributes = $this->extensionFactory->create();
        }
        $extensionAttributes->setCode("Code #".$id);
        $model->setExtensionAttributes($extensionAttributes);
        return $model;
    }
}