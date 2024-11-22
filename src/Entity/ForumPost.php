<?php

namespace App\Entity;

use App\Repository\ForumPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForumPostRepository::class)]
class ForumPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'forumPosts')]
    private ?User $author = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $post_date = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $body = null;

    /**
     * @var Collection<int, ForumComment>
     */
    #[ORM\OneToMany(targetEntity: ForumComment::class, mappedBy: 'post')]
    private Collection $forumComments;

    /**
     * @var Collection<int, ForumTopics>
     */
    #[ORM\ManyToMany(targetEntity: ForumTopics::class, inversedBy: 'forumPosts')]
    private Collection $topics;

    public function __construct()
    {
        $this->forumComments = new ArrayCollection();
        $this->topics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getPostDate(): ?\DateTimeInterface
    {
        return $this->post_date;
    }

    public function setPostDate(\DateTimeInterface $post_date): static
    {
        $this->post_date = $post_date;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return Collection<int, ForumComment>
     */
    public function getForumComments(): Collection
    {
        return $this->forumComments;
    }

    public function addForumComment(ForumComment $forumComment): static
    {
        if (!$this->forumComments->contains($forumComment)) {
            $this->forumComments->add($forumComment);
            $forumComment->setPost($this);
        }

        return $this;
    }

    public function removeForumComment(ForumComment $forumComment): static
    {
        if ($this->forumComments->removeElement($forumComment)) {
            // set the owning side to null (unless already changed)
            if ($forumComment->getPost() === $this) {
                $forumComment->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ForumTopics>
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(ForumTopics $topic): static
    {
        if (!$this->topics->contains($topic)) {
            $this->topics->add($topic);
        }

        return $this;
    }

    public function removeTopic(ForumTopics $topic): static
    {
        $this->topics->removeElement($topic);

        return $this;
    }
}
