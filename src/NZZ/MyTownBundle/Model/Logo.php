<?php

namespace NZZ\MyTownBundle\Model;

use NZZ\MyTownBundle\Model\om\BaseLogo;

class Logo extends BaseLogo
{
    /**
     * main image upload - image content
     *
     * @var mixed
     */
    protected $contentUploaded;

    protected $path;

    public function setContentUploaded($value)
    {
        $this->contentUploaded = $value;
    }

    public function getContentUploaded()
    {
        return $this->contentUploaded;
    }

    public function getWebPath()
    {
        return $this->getUploadRootDir().'/';
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }
}
