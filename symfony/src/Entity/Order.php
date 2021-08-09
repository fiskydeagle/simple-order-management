<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="`order`")
 */
class Order
{
    const POSITON_PENDING = 'pending';
    const POSITON_FAILED = 'failed';
    const POSITON_SUCCESS = 'success';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $order_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $position;

    /**
     * @ORM\ManyToMany(targetEntity=Note::class)
     */
    private Collection $notes;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class)
     */
    private Collection $products;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Address $billing_address;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Address $shippig_address;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderNumber(): ?string
    {
        return $this->order_number;
    }

    public function setOrderNumber(string $order_number): self
    {
        $this->order_number = $order_number;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        if (
            $position == self::POSITON_PENDING ||
            $position == self::POSITON_FAILED ||
            $position == self::POSITON_SUCCESS
        ) {
            $this->position = $position;
        }

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        $this->notes->removeElement($note);

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }

    public function getBillingAddress(): ?Address
    {
        return $this->billing_address;
    }

    public function setBillingAddress(?Address $billing_address): self
    {
        $this->billing_address = $billing_address;

        return $this;
    }

    public function getShippigAddress(): ?Address
    {
        return $this->shippig_address;
    }

    public function setShippigAddress(?Address $shippig_address): self
    {
        $this->shippig_address = $shippig_address;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function generateOrderNumber(): void
    {
        $this->order_number = md5(uniqid());
    }
}
