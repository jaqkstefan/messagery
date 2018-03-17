<?php

namespace MessagerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * File
 *
 * @ORM\Table(name="files")
 * @ORM\MappedSuperclass()
 * @ORM\Entity(repositoryClass="MessagerieBundle\Repository\FileRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\HasLifecycleCallbacks
 */
class File implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255, nullable=true)
     */
    protected $size;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=16, nullable=true)
     */
    protected $extension;

    protected $file;

    public function __construct(UploadedFile $file = null) {

        if(!is_null($file)){
            $this->file = $file;
        }
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return File
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return File
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return File
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return File
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }


    public function getAbsolutePath($path = null)
    {
        if($path == null){
            $path = $this->path;
        }
        return null === $path ? null : $this->getUploadRootDir().'/'.$path;
    }

    public function getWebPath($path = null)
    {
        if($path == null){
            $path = $this->path;
        }
        return null === $path ? null : $this->getUploadDir().'/'.$path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads';
    }


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // faites ce que vous voulez pour générer un nom unique
            $this->path = time().'_'.sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
            $this->type = $this->file->getMimeType();
            $this->size = $this->file->getClientSize();
            $this->extension = $this->file->guessExtension();
            $this->name = $this->file->getClientOriginalName();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
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
        try{
            $file = $this->file->move($this->getUploadRootDir(), $this->path);  
        }catch(\FileException $e){
            die($e->getMessage());
        }
        
    }

    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if(file_exists($file = $this->getAbsolutePath()))
        {
            if($file = $this->getAbsolutePath()) {
                unlink($file);
            }
        }
    }
    
	public function sizeFormalize(){
		$size = $this->size;
		$result = $size.' Octets';
		if($size > 1000000000){
			$size = round($size / 1000000000, 2);
			$result = $size.' Go';
		}else if($size > 1000000){
			$size = round($size / 1000000, 2);
			$result = $size.' Mo';
		}else if($size > 1000){
			$size = round($size / 1000, 2);
			$result = $size.' Ko';
		}
		
		return $result;
	}

	public function isImage() {
		return preg_match('#image#', $this->type);
	}

	public function editeur() {
		switch ($this->getExtension()) {
			case 'pdf':
				return 'pdf';
				break;
			case 'docx':
			case 'doc':
				return 'word';
				break;
			case 'xlsx':
			case 'xls':
				return 'excel';
				break;
			case 'pptx':
			case 'ppt':
				return 'powerpoint';
				break;
			case 'rar':
			case 'gz':
			case 'gzip':
			case 'tar':
			case 'zip':
				return 'zip';
			case 'jpg':
			case 'jpeg':
			case 'png':
			case 'gif':
				return 'image';
				break;
			case 'mp4':
			case 'ogg':
			case '3gp':
			case 'avi':
				return 'video';
				break;
			
			default:
				return 'text';
				break;
		}
    }

    public function getObjectVars() {
        return get_object_vars($this);
    }

    public function __toString() {
        if(null === $this->file){
            return $this->getAbsolutePath();
        }else{
            return $this->file->__toString();
        }
    }

    public function jsonSerialize() {
        $obj = [];
        $obj['id'] = $this->getId();
        $obj['path'] = $this->getWebPath();
        $obj['size'] = $this->getSize();
        $obj['name'] = $this->getName();
        $obj['type'] = $this->editeur();
        
        return $obj;
    }
}
