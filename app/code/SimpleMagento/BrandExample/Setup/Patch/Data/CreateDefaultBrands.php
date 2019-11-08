<?php


namespace SimpleMagento\BrandExample\Setup\Patch\Data;


use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;

class CreateDefaultBrands implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    protected $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * Get array of patches that have to be executed prior to this.
     *
     * Example of implementation:
     *
     * [
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch1::class,
     *      \Vendor_Name\Module_Name\Setup\Patch\Patch2::class
     * ]
     *
     * @return string[]
     */
    public static function getDependencies()
    {
        // TODO: Implement getDependencies() method.
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return string[]
     */
    public function getAliases()
    {
        // TODO: Implement getAliases() method.
    }

    /**
     * Run code inside patch
     * If code fails, patch must be reverted, in case when we are speaking about schema - than under revert
     * means run PatchInterface::revert()
     *
     * If we speak about data, under revert means: $transaction->rollback()
     *
     * @return $this
     */
    public function apply()
    {
        $brands = [
            ['name' => 'Sike', 'description' => 'Something cool'],
            ['name' => 'Mike', 'description' => 'Something is not cool']
        ];
        $records = array_map(function ($brand){
            return array_merge($brand, ['is_enabled' => 1, 'website_id' => 1]);
        }, $brands);

        $this->moduleDataSetup->getConnection()->insertMultiple('mage2tv_brand_example', $records);

        return $this;
    }
}