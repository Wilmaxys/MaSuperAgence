<?php

namespace App\Service;

class CompressionService {
    /**
     * Write a thumbnail image using the LiipImagineBundle
     *
     * @param Document $fullSizeImgWebPath path where full size upload is stored e.g. uploads/attachments
     * @param string $thumbAbsPath full absolute path to attachment directory e.g. /var/www/project1/images/thumbs/
     * @param string $filter filter defined in config e.g. my_thumb
     * @param Object $diContainer Dependency Injection Object, if calling from controller just pass $this
     */
    public function compressImage($fullSizeImgWebPath, $thumbAbsPath, $filter, $diContainer) {
        $container = $diContainer; // the DI container, if keeping this function in controller just use $container = $this
        $dataManager = $container->get('liip_imagine.data.manager');    // the data manager service
        $filterManager = $container->get('liip_imagine.filter.manager'); // the filter manager service
        $image = $dataManager->find($filter, $fullSizeImgWebPath);                    // find the image and determine its type
        $response = $filterManager->applyFilter($image, $filter);

        $thumb = $response->getContent();                               // get the image from the response

        $f = fopen($thumbAbsPath, 'w');                                        // create thumbnail file
        fwrite($f, $thumb);                                             // write the thumbnail
        fclose($f);                                                     // close the file
    }


    public function CompressPdf() : string
    {
        return "test2";
    }
}