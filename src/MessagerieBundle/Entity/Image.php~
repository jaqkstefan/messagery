<?php

namespace MessagerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="MessagerieBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image extends File
{

    /**
     * @var string
     *
     * @ORM\Column(name="smallThumbPath", type="string", length=255, nullable=true)
     */
    private $smallThumbPath;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbPath", type="string", length=255, nullable=true)
     */
    private $thumbPath;

    /**
     * @var string
     *
     * @ORM\Column(name="width", type="string", length=255, nullable=true)
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(name="height", type="string", length=255, nullable=true)
     */
    private $height;


    /**
     * Set smallThumbPath
     *
     * @param string $smallThumbPath
     *
     * @return Image
     */
    public function setSmallThumbPath($smallThumbPath)
    {
        $this->smallThumbPath = $smallThumbPath;

        return $this;
    }

    /**
     * Get smallThumbPath
     *
     * @return string
     */
    public function getSmallThumbPath()
    {
        return $this->smallThumbPath;
    }

    /**
     * Set thumbPath
     *
     * @param string $thumbPath
     *
     * @return Image
     */
    public function setThumbPath($thumbPath)
    {
        $this->thumbPath = $thumbPath;

        return $this;
    }

    /**
     * Get thumbPath
     *
     * @return string
     */
    public function getThumbPath()
    {
        return $this->thumbPath;
    }

    /**
     * Set width
     *
     * @param string $width
     *
     * @return Image
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param string $height
     *
     * @return Image
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUploadThumbs()
    {
        if (null !== $this->file && $this->file instanceof UploadedFile) {
            // faites ce que vous voulez pour générer un nom unique
            $this->smallThumbPath = time().'_small_'.sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
            $this->thumbPath = time().'_thumb_'.sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
        }else if(null !== $this->path && $this->path instanceof UploadedFile){
            $this->file = clone $this->path;
            $this->smallThumbPath = time().'_small_'.sha1(uniqid(mt_rand(), true)).'.'.$this->path->guessExtension();
            $this->thumbPath = time().'_thumb_'.sha1(uniqid(mt_rand(), true)).'.'.$this->path->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function uploadThumbs()
    {
        if(null === $this->file)
        {
            return;
        }
        // utilisez le nom de fichier original ici mais
        // vous devriez « l'assainir » pour au moins éviter
        // quelconques problèmes de sécurité

        // la méthode « move » prend comme arguments le répertoire cible et
        // le nom de fichier cible où le fichier doit être déplacé
        $thumb = $this->createThumbnail((string)$this->getAbsolutePath());
        $small = $this->createThumbnail((string)$this->getAbsolutePath(), 124, 124);
        if($this->getExtension() == 'jpg' || $this->getExtension() == 'jpeg'){
            imagejpeg($thumb, $this->getAbsoluteThumbPath());
            imagejpeg($small, $this->getAbsoluteSmallThumbPath());
        }else{
            imagepng($thumb, $this->getAbsoluteThumbPath());
            imagepng($small, $this->getAbsoluteSmallThumbPath());
        }
        
    }

    
    /**
     * @ORM\PostRemove()
     */
    public function removeUploadThumbs()
    {
        if(file_exists($file = $this->getAbsoluteThumbPath()))
        {
            if($file = $this->getAbsoluteThumbPath()) {
                unlink($file);
            }
        }
        if(file_exists($file = $this->getAbsoluteSmallThumbPath()))
        {
            if($file = $this->getAbsoluteSmallThumbPath()) {
                unlink($file);
            }
        }
    }


    public function getAbsoluteThumbPath()
    {
        return $this->getAbsolutePath($this->thumbPath);
    }

    public function getWebThumbPath()
    {
        return $this->getWebPath($this->thumbPath);
    }

    public function getAbsoluteSmallThumbPath()
    {
        return $this->getAbsolutePath($this->smallThumbPath);
    }

    public function getWebSmallThumbPath()
    {
        return $this->getWebPath($this->smallThumbPath);
    }

    protected function getUploadDir()
    {
        return 'uploads/images';
    }
    

    public function createThumbnail($filename, $width = null, $height = null) {
        if(!$width){
            $width = 240;
        }
        if(!$height) {
            $height = 240;
        }

        // Cacul des nouvelles dimensions
        list($width_orig, $height_orig) = getimagesize($filename);

        $ratio_orig = $width_orig/$height_orig;

        if ($width/$height > $ratio_orig) {
        $width = $height*$ratio_orig;
        } else {
        $height = $width/$ratio_orig;
        }

        // Redimensionnement
        $image_p = imagecreatetruecolor($width, $height);
        if($this->getExtension() == 'jpg' || $this->getExtension() == 'jpeg'){
            $image = imagecreatefromjpeg($filename);
        }else{
            $image = imagecreatefrompng($filename);
        }
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        return $image_p;
    }

    public function getObjectVars() {
        return get_object_vars($this);
    }
}
