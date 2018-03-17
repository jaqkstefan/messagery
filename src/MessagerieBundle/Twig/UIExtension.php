<?php
namespace MessagerieBundle\Twig;

class UIExtension extends \Twig_Extension
{

    public function __construct() {
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('photo', array($this, 'imageProfileFilter')),
        );
    }

    public function imageProfileFilter($image, $format = 'normal') {
        if($image instanceof \MessagerieBundle\Entity\Image) {
            if($format == 'small'){
                return $image->getWebSmallThumbPath();
            }else if($format == 'thumb'){
                return $image->getWebThumbPath();
            }

            return $image->getWebPath();
        }else{
            return 'assets/img/default-avatar.png';
        }
    }

    public function getName()
    {
        return 'ui_extension';
    }
}