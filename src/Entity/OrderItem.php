<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=OrderItemRepository::class)
 */
class OrderItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Article::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

  

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderItem")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderDone; //Le mot "order" est deja reserve par le systeme

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
    
    
    
    public function getOrderDone(): ?Order
    {
        return $this->orderDone;
    }

    public function setOrderDone(?Order $orderDone): self
    {
        $this->orderDone = $orderDone;

        return $this;
    }

}
