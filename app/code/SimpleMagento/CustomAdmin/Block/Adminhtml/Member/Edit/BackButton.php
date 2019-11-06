<?php


namespace SimpleMagento\CustomAdmin\Block\Adminhtml\Member\Edit;


use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class BackButton extends Generic implements ButtonProviderInterface
{

    /**
     * Retrieve button-specified settings
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'class' =>'back',
            'on_click' =>sprintf("location.href = '%s';", $this->getBackUrl()),
            'sort_order' => 10
        ];
    }

    public function getBackUrl(){
        return $this->getUrl('*/*');
    }
}