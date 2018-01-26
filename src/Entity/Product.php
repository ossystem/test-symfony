<?php

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product implements JsonSerializable
{
    const TYPE_1 = 1;
    const TYPE_2 = 2;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $name;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="integer")
     */
    protected $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $color;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $texture;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $height;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $width;

    /**
     * Get the value of Id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param mixed name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Created At
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of Created At
     *
     * @param \DateTime createdAt
     *
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of Type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of Type
     *
     * @param integer type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of Color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of Color
     *
     * @param string color
     *
     * @return self
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get the value of Texture
     *
     * @return string
     */
    public function getTexture()
    {
        return $this->texture;
    }

    /**
     * Set the value of Texture
     *
     * @param string texture
     *
     * @return self
     */
    public function setTexture($texture)
    {
        $this->texture = $texture;

        return $this;
    }

    /**
     * Get the value of Height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set the value of Height
     *
     * @param integer height
     *
     * @return self
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get the value of Width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set the value of Width
     *
     * @param integer width
     *
     * @return self
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }

    public function jsonSerialize()
    {
        $obj = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'type' => $this->getType(),
        ];

        switch ($this->getType()) {
          case self::TYPE_1:
            $obj['color'] = $this->getColor();
            $obj['texture'] = $this->getTexture();
            break;
          case self::TYPE_2:
            $obj['height'] = $this->getHeight();
            $obj['width'] = $this->getWidth();
            break;
        }

        return $obj;
    }
}
