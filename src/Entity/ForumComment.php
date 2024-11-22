<?php

namespace App\Entity;

use App\Repository\ForumCommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForumCommentRepository::class)]
class ForumComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $body = null;

    #[ORM\ManyToOne(inversedBy: 'forumComments')]
    private ?User $author = null;

    #[ORM\ManyToOne(inversedBy: 'forumComments')]
    private ?ForumPost $post = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getPost(): ?ForumPost
    {
        return $this->post;
    }

    public function setPost(?ForumPost $post): static
    {
        $this->post = $post;

        return $this;
    }
}
