<?php

namespace Purjus\SearchBundle\Entity;

/**
 * Base class for any type of result,
 * because every result should more or less act the same...
 *
 * @author Purjus Communication
 * @author Tom
 */
class Entry
{
    /**
     * @var string name
     */
    protected $name;

    /**
     * @var string link
     */
    protected $link;

    /**
     * @var string description
     */
    protected $description;

    /**
     * @var string image
     */
    protected $image;

    /**
     * @var array options
     */
    protected $options = [];

    /**
     * Constructor.
     *
     * @param string $name        name
     * @param string $link        link
     * @param string $description description
     * @param string $image       image
     * @param array  $options     options
     */
    public function __construct($name, $link, $description = null, $image = null, array $options = [])
    {
        $this->name = $name;
        $this->link = $link;
        $this->image = $image;
        $this->description = $description;
        $this->options = $options;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Group
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get link.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set link.
     *
     * @param string $link
     *
     * @return Group
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Group
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image.
     *
     * @param string $image
     *
     * @return Group
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set options.
     *
     * @param array $options
     *
     * @return Group
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }
}
