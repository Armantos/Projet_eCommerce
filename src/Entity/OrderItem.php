<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orderItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $buyer;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, inversedBy="orderItems")
     */
    private $purchase;

    /**
     * @ORM\ManyToMany(targetEntity=Order::class, mappedBy="orderItem")
     */
    private $orders;

    public function __construct()
    {
        $this->purchase = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function setBuyer(?User $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getPurchase(): Collection
    {
        return $this->purchase;
    }

    public function addPurchase(Article $purchase): self
    {
        if (!$this->purchase->contains($purchase)) {
            $this->purchase[] = $purchase;
        }

        return $this;
    }

    public function removePurchase(Article $purchase): self
    {
        $this->purchase->removeElement($purchase);

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->addOrderItem($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            $order->removeOrderItem($this);
        }

        return $this;
    }
}
