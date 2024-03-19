<?php
/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Gametracker\Models;

class Gametracker extends \Ilch\Model
{
    /**
     * The id of the gametracker.
     *
     * @var int
     */
    protected $id;

    /**
     * The name of the gametracker.
     *
     * @var string
     */
    protected $name;

    /**
     * The link of the gametracker.
     *
     * @var string
     */
    protected $link;

    /**
     * The banner of the gametracker.
     *
     * @var string
     */
    protected $banner;

    /**
     * The link target of the entry.
     *
     * @var int
     */
    protected $target;

    /**
     * The free of the entry.
     *
     * @var int
     */
    protected $free;

    /**
     * Gets the id of the gametracker.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the id of the gametracker.
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (int)$id;

        return $this;
    }

    /**
     * Gets the name of the gametracker.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the gametracker.
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = (string)$name;

        return $this;
    }

    /**
     * Gets the link of the gametracker.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets the link of the gametracker.
     *
     * @param string $link
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = (string)$link;

        return $this;
    }

    /**
     * Gets the banner of the gametracker.
     *
     * @return string
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Sets the banner of the gametracker.
     *
     * @param string $banner
     * @return $this
     */
    public function setBanner($banner)
    {
        $this->banner = (string)$banner;

        return $this;
    }

    /**
     * Gets the link target of the entry.
     *
     * @return int
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set the link target of the entry.
     *
     * @param int $target
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = (int)$target;

        return $this;
    }

    /**
     * Gets the free of the entry.
     *
     * @return int
     */
    public function getFree()
    {
        return $this->free;
    }

    /**
     * Set the free of the entry.
     *
     * @param int $free
     * @return $this
     */
    public function setFree($free)
    {
        $this->free = (int)$free;

        return $this;
    }
}
