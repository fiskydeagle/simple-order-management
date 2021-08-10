<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    private ?string $order_number;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Choice({"pending", "failed", "success"})
     */
    private ?string $position;

    /**
     * @ORM\ManyToMany(targetEntity=Note::class)
     */
    private ?Collection $notes;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class)
     * @Assert\NotBlank()
     */
    private ?Collection $products;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private ?Country $billing_address_country;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private ?string $billing_address_address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private ?string $billing_address_zip_code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private ?string $billing_address_email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private ?string $billing_address_phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private ?Country $shipping_address_country;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private ?string $shipping_address_address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private ?string $shipping_address_zip_code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private ?string $shipping_address_email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private ?string $shipping_address_phone;

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

    public function setOrderNumber(?string $order_number): self
    {
        $this->order_number = $order_number;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
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
    public function getNotes(): ?Collection
    {
        return $this->notes;
    }

    public function addNote(?Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
        }

        return $this;
    }

    public function removeNote(?Note $note): self
    {
        $this->notes->removeElement($note);

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): ?Collection
    {
        return $this->products;
    }

    public function addProduct(?Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(?Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }
    public function getBillingAddressCountry(): ?Country
    {
        return $this->billing_address_country;
    }

    public function setBillingAddressCountry(?Country $billing_address_country): self
    {
        $this->billing_address_country = $billing_address_country;

        return $this;
    }

    public function getBillingAddressAddress(): ?string
    {
        return $this->billing_address_address;
    }

    public function setBillingAddressAddress(?string $billing_address_address): self
    {
        $this->billing_address_address = $billing_address_address;

        return $this;
    }

    public function getBillingAddressZipCode(): ?string
    {
        return $this->billing_address_zip_code;
    }

    public function setBillingAddressZipCode(?string $billing_address_zip_code): self
    {
        $this->billing_address_zip_code = $billing_address_zip_code;

        return $this;
    }

    public function getBillingAddressEmail(): ?string
    {
        return $this->billing_address_email;
    }

    public function setBillingAddressEmail(?string $billing_address_email): self
    {
        $this->billing_address_email = $billing_address_email;

        return $this;
    }

    public function getBillingAddressPhone(): ?string
    {
        return $this->billing_address_phone;
    }

    public function setBillingAddressPhone(?string $billing_address_phone): self
    {
        $this->billing_address_phone = $billing_address_phone;

        return $this;
    }

    public function getShippingAddressCountry(): ?Country
    {
        return $this->shipping_address_country;
    }

    public function setShippingAddressCountry(?Country $shipping_address_country): self
    {
        $this->shipping_address_country = $shipping_address_country;

        return $this;
    }

    public function getShippingAddressAddress(): ?string
    {
        return $this->shipping_address_address;
    }

    public function setShippingAddressAddress(?string $shipping_address_address): self
    {
        $this->shipping_address_address = $shipping_address_address;

        return $this;
    }

    public function getShippingAddressZipCode(): ?string
    {
        return $this->shipping_address_zip_code;
    }

    public function setShippingAddressZipCode(?string $shipping_address_zip_code): self
    {
        $this->shipping_address_zip_code = $shipping_address_zip_code;

        return $this;
    }

    public function getShippingAddressEmail(): ?string
    {
        return $this->shipping_address_email;
    }

    public function setShippingAddressEmail(?string $shipping_address_email): self
    {
        $this->shipping_address_email = $shipping_address_email;

        return $this;
    }

    public function getShippingAddressPhone(): ?string
    {
        return $this->shipping_address_phone;
    }

    public function setShippingAddressPhone(?string $shipping_address_phone): self
    {
        $this->shipping_address_phone = $shipping_address_phone;

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
