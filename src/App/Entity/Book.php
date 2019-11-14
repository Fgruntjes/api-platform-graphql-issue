<?php
/**
 * @author Emico <info@emico.nl>
 * @copyright (c) Emico B.V. 2019
 */
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Selectable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    /**
     * @var int|null
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var Page[]|Selectable|Collection
     * @ORM\OneToMany(targetEntity="Page", mappedBy="book", cascade={"all"})
     */
    private $pages;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Page[]|Collection|Selectable
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param Page[]|Collection|Selectable $pages
     */
    public function setPages($pages): void
    {
        $this->pages = new ArrayCollection();
        foreach ($pages as $page) {
            $this->addPage($page);
        }
    }

    /**
     * @param Page $page
     */
    public function addPage(Page $page): void
    {
        if ($this->pages->contains($page)) {
            return;
        }

        $this->pages->add($page);
        $page->setBook($this);
    }

    /**
     * @param Page $page
     */
    public function removePage(Page $page): void
    {
        if (!$this->pages->contains($page)) {
            return;
        }

        $this->pages->removeElement($page);
    }
}