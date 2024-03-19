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
    protected $id = 0;

    /**
     * The name of the gametracker.
     *
     * @var string
     */
    protected $name = '';

    /**
     * The link of the gametracker.
     *
     * @var string
     */
    protected $link = '';

    /**
     * The banner of the gametracker.
     *
     * @var string
     */
    protected $banner = '';

    /**
     * The link target of the entry.
     *
     * @var int
     */
    protected $target = 0;

    /**
     * The free of the entry.
     *
     * @var integer
     */
    protected $free = 0;

    /**
     * Gets the id of the gametracker.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets the id of the gametracker.
     *
     * @param int $id
     * @return $this
     */
    public function setId(int $id): Gametracker
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the name of the gametracker.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the name of the gametracker.
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): Gametracker
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the link of the gametracker.
     *
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * Sets the link of the gametracker.
     *
     * @param string $link
     * @return $this
     */
    public function setLink(string $link): Gametracker
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Gets the banner of the gametracker.
     *
     * @return string
     */
    public function getBanner(): string
    {
        return $this->banner;
    }

    /**
     * Sets the banner of the gametracker.
     *
     * @param string $banner
     * @return $this
     */
    public function setBanner(string $banner): Gametracker
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Gets the link target of the entry.
     *
     * @return int
     */
    public function getTarget(): int
    {
        return $this->target;
    }

    /**
     * Set the link target of the entry.
     *
     * @param int $target
     * @return $this
     */
    public function setTarget(int $target): Gametracker
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Gets the free of the entry.
     *
     * @return int
     */
    public function getFree(): int
    {
        return $this->free;
    }

    /**
     * Set the free of the entry.
     *
     * @param int $free
     * @return $this
     */
    public function setFree(int $free): Gametracker
    {
        $this->free = $free;

        return $this;
    }
}
