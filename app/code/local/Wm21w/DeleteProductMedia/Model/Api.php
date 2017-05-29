<?php

class Wm21w_DeleteProductMedia_Model_Api extends Mage_Api_Model_Resource_Abstract
{
    /**
     * Usuwa wszystkie zdjęcia wybranego produktu przez SKU
     * @param $sku
     */
    public function DeleteAllProductMedia($sku)
    {
        $product = Mage::getModel('catalog/product');
        $product_id = $product->getIdBySku($sku);
        $product->load($product_id);

        $attributes = $product->getTypeInstance()->getSetAttributes();
        if (isset ($attributes ['media_gallery'])) {
            $gallery = $attributes ['media_gallery'];
            $galleryData = $product->getMediaGallery();
            foreach ($galleryData ['images'] as $image) {
                if ($gallery->getBackend()->getImage($product, $image ['file'])) {
                    $gallery->getBackend()->removeImage($product, $image ['file']);
                }
            }
            $product->save();
        }
    }
}