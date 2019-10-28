<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

// itemOperations={"get","put"} - to defined wihci api will be enable and accessible Ex : remove Delete
// shortName="chees" - to change the API name alias
//  *     "get"={"path"="deen/{id}"}, - to only change URL of Put mathod on item operation
// *     "put"},


/**
 * @ApiResource (
 *     collectionOperations={"get","post"},
 *     itemOperations={
 *     "get"={"path"="deen/{id}"},
 *     "put"},
 *     normalizationContext={"groups"={"chees_listing:read"}},
 *     denormalizationContext={"groups"={"chees_listing:write"}},
 *     shortName="chees"
 *     )
 *
 * @ORM\Entity(repositoryClass="App\Repository\CheeseListingRepository")
 *
 *
 *
 */
class CheeseListing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"chees_listing:read","chees_listing:write"})
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"chees_listing:read","chees_listing:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"chees_listing:read","chees_listing:write"})
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    // making false will disable the field 
    private $isPublish=false;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
// custome funtion for remove break lines from description ex : set called when insertaion happening


    /**
     * @param string|null $description
     * @Groups({"chees_listing:write"})
     * @return \App\Entity\CheeseListing
     */

    public function setTextDescription(?string $description): self
    {
        $this->description = nl2br($description);

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    // custome function to get created as string to show min ago

    /**
     * allowing create ago only for read
     * @Groups({"chees_listing:read"})
     */

    public function getCreatedAtago(): string {

        return Carbon::instance($this->getCreatedAt())->diffForHumans();

    }


    public function getIsPublish(): ?bool
    {
        return $this->isPublish;
    }

    public function setIsPublish(bool $isPublish): self
    {
        $this->isPublish = $isPublish;

        return $this;
    }
}
