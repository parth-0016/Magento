<?php

class Ccc_Promotions_Model_Observer
{
    public function updateSpecialPrice($observer)
    {
        $product = $observer->getEvent()->getProduct();
        $activeTagOptionId = $product->getData('active_tag');

        if ($activeTagOptionId) {
            $activeTag = $this->getAttributeOptionValue('active_tag', $activeTagOptionId);
            if ($activeTag) {
                $tagPercentage = $this->getTagPercentage($activeTag);
                if ($tagPercentage !== false) {
                    $price = $product->getPrice();
                    $specialPrice = $price + ($price * $tagPercentage / 100);
                    $product->setData('special_price', $specialPrice);
                }
            }
        }
    }

    protected function getAttributeOptionValue($attributeCode, $optionId)
    {
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);
        foreach ($attribute->getSource()->getAllOptions(false) as $option) {
            if ($option['value'] == $optionId) {
                return $option['label'];
            }
        }
        return false;
    }

    protected function getTagPercentage($tag)
    {
        $promotions = Mage::getModel('promotions/promotions')->getCollection()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('tag_name', $tag);

        $promotionsData = $promotions->getData();

        if (!empty($promotionsData)) {
            return $promotionsData[0]['percentage'];
        } else {
            Mage::log('No active promotion found for tag: ' . $tag, null, 'promotions.log');
            return false;
        }
    }
}