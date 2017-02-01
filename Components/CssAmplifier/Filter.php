<?php

namespace HeptacomAmp\Components\CssAmplifier;

class Filter
{
    /**
     * @var bool
     */
    protected $keyframe = false;

    /**
     * @var bool
     */
    protected $media = false;

    /**
     * @var bool
     */
    protected $paths = false;

    /**
     * @var bool
     */
    protected $important = false;

    /**
     * @return bool
     */
    public function isKeyframe()
    {
        return $this->keyframe;
    }

    /**
     * @param bool $keyframe
     * @return Filter
     */
    public function setKeyframe($keyframe)
    {
        $this->keyframe = $keyframe;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMedia()
    {
        return $this->media;
    }

    /**
     * @param bool $media
     * @return Filter
     */
    public function setMedia($media)
    {
        $this->media = $media;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPaths()
    {
        return $this->paths;
    }

    /**
     * @param bool $paths
     * @return Filter
     */
    public function setPaths($paths)
    {
        $this->paths = $paths;
        return $this;
    }

    /**
     * @return bool
     */
    public function isImportant()
    {
        return $this->important;
    }

    /**
     * @param bool $important
     * @return Filter
     */
    public function setImportant($important)
    {
        $this->important = $important;
        return $this;
    }
}
