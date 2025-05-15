<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $displayName = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    /**
     * @var Collection<int, Post>
     */
    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'author')]
    private Collection $posts;

    /**
     * @var Collection<int, Friendship>
     */
    #[ORM\OneToMany(targetEntity: Friendship::class, mappedBy: 'personA')]
    private Collection $friendAsPersonA;

    /**
     * @var Collection<int, Friendship>
     */
    #[ORM\OneToMany(targetEntity: Friendship::class, mappedBy: 'personB')]
    private Collection $friendAsPersonB;

    /**
     * @var Collection<int, FriendRequest>
     */
    #[ORM\OneToMany(targetEntity: FriendRequest::class, mappedBy: 'sender')]
    private Collection $sentFriendRequests;

    /**
     * @var Collection<int, FriendRequest>
     */
    #[ORM\OneToMany(targetEntity: FriendRequest::class, mappedBy: 'recipient')]
    private Collection $receivedFriendRequests;

    /**
     * @var Collection<int, Conversation>
     */
    #[ORM\ManyToMany(targetEntity: Conversation::class, mappedBy: 'participants')]
    private Collection $conversations;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'author')]
    private Collection $messages;

    /**
     * @var Collection<int, Share>
     */
    #[ORM\OneToMany(targetEntity: Share::class, mappedBy: 'sender')]
    private Collection $sentShares;

    /**
     * @var Collection<int, Share>
     */
    #[ORM\OneToMany(targetEntity: Share::class, mappedBy: 'recipient')]
    private Collection $receivedShares;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->friendAsPersonA = new ArrayCollection();
        $this->friendAsPersonB = new ArrayCollection();
        $this->sentFriendRequests = new ArrayCollection();
        $this->receivedFriendRequests = new ArrayCollection();
        $this->conversations = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->sentShares = new ArrayCollection();
        $this->receivedShares = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(?string $displayName): static
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendAsPersonA(): Collection
    {
        return $this->friendAsPersonA;
    }

    public function addFriendAsPersonA(Friendship $friendAsPersonA): static
    {
        if (!$this->friendAsPersonA->contains($friendAsPersonA)) {
            $this->friendAsPersonA->add($friendAsPersonA);
            $friendAsPersonA->setPersonA($this);
        }

        return $this;
    }

    public function removeFriendAsPersonA(Friendship $friendAsPersonA): static
    {
        if ($this->friendAsPersonA->removeElement($friendAsPersonA)) {
            // set the owning side to null (unless already changed)
            if ($friendAsPersonA->getPersonA() === $this) {
                $friendAsPersonA->setPersonA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendAsPersonB(): Collection
    {
        return $this->friendAsPersonB;
    }

    public function addFriendAsPersonB(Friendship $friendAsPersonB): static
    {
        if (!$this->friendAsPersonB->contains($friendAsPersonB)) {
            $this->friendAsPersonB->add($friendAsPersonB);
            $friendAsPersonB->setPersonB($this);
        }

        return $this;
    }

    public function removeFriendAsPersonB(Friendship $friendAsPersonB): static
    {
        if ($this->friendAsPersonB->removeElement($friendAsPersonB)) {
            // set the owning side to null (unless already changed)
            if ($friendAsPersonB->getPersonB() === $this) {
                $friendAsPersonB->setPersonB(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FriendRequest>
     */
    public function getSentFriendRequests(): Collection
    {
        return $this->sentFriendRequests;
    }

    public function addSentFriendRequest(FriendRequest $sentFriendRequest): static
    {
        if (!$this->sentFriendRequests->contains($sentFriendRequest)) {
            $this->sentFriendRequests->add($sentFriendRequest);
            $sentFriendRequest->setSender($this);
        }

        return $this;
    }

    public function removeSentFriendRequest(FriendRequest $sentFriendRequest): static
    {
        if ($this->sentFriendRequests->removeElement($sentFriendRequest)) {
            // set the owning side to null (unless already changed)
            if ($sentFriendRequest->getSender() === $this) {
                $sentFriendRequest->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FriendRequest>
     */
    public function getReceivedFriendRequests(): Collection
    {
        return $this->receivedFriendRequests;
    }

    public function addReceivedFriendRequest(FriendRequest $receivedFriendRequest): static
    {
        if (!$this->receivedFriendRequests->contains($receivedFriendRequest)) {
            $this->receivedFriendRequests->add($receivedFriendRequest);
            $receivedFriendRequest->setRecipient($this);
        }

        return $this;
    }

    public function removeReceivedFriendRequest(FriendRequest $receivedFriendRequest): static
    {
        if ($this->receivedFriendRequests->removeElement($receivedFriendRequest)) {
            // set the owning side to null (unless already changed)
            if ($receivedFriendRequest->getRecipient() === $this) {
                $receivedFriendRequest->setRecipient(null);
            }
        }

        return $this;
    }

    public function isPendingFriendRequest(Profile $profile): bool
    {
        foreach ($this->receivedFriendRequests as $friendRequest) {
            if ($friendRequest->getSender() === $profile) {
                return true;
            }
        }
        foreach ($this->sentFriendRequests as $friendRequest) {
                if ($friendRequest->getRecipient() === $profile) {
                    return true;
                }
        }
        return false;
    }

    public function isFriendsWith(Profile $profile): bool
    {
        foreach ($this->friendAsPersonA as $friendShip) {
            if ($friendShip->getPersonB() === $profile) {
                return true;
            }
        }

        foreach ($this->friendAsPersonB as $friendShip) {
            if ($friendShip->getPersonA() === $profile) {
                return true;
            }
        }
        return false;
    }

    public function getFriends() : array
    {
        $friends = [];
        foreach ($this->friendAsPersonA as $friendShip) {
               $friends[] =$friendShip->getPersonB();
        }
        foreach ($this->friendAsPersonB as $friendShip) {
            $friends[] =$friendShip->getPersonA();
        }
        return $friends;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): static
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations->add($conversation);
            $conversation->addParticipant($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): static
    {
        if ($this->conversations->removeElement($conversation)) {
            $conversation->removeParticipant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setAuthor($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getAuthor() === $this) {
                $message->setAuthor(null);
            }
        }

        return $this;
    }

    public function isChattingWith(Profile $profile):Conversation | bool
    {
        foreach ($this->conversations as $conversation) {
            if($conversation->getParticipants()->contains($profile)){
                return $conversation;
            }
        }
        return false;
    }

    /**
     * @return Collection<int, Share>
     */
    public function getSentShares(): Collection
    {
        return $this->sentShares;
    }

    public function addSentShare(Share $sentShare): static
    {
        if (!$this->sentShares->contains($sentShare)) {
            $this->sentShares->add($sentShare);
            $sentShare->setSender($this);
        }

        return $this;
    }

    public function removeSentShare(Share $sentShare): static
    {
        if ($this->sentShares->removeElement($sentShare)) {
            // set the owning side to null (unless already changed)
            if ($sentShare->getSender() === $this) {
                $sentShare->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Share>
     */
    public function getReceivedShares(): Collection
    {
        return $this->receivedShares;
    }

    public function addReceivedShare(Share $receivedShare): static
    {
        if (!$this->receivedShares->contains($receivedShare)) {
            $this->receivedShares->add($receivedShare);
            $receivedShare->setRecipient($this);
        }

        return $this;
    }

    public function removeReceivedShare(Share $receivedShare): static
    {
        if ($this->receivedShares->removeElement($receivedShare)) {
            // set the owning side to null (unless already changed)
            if ($receivedShare->getRecipient() === $this) {
                $receivedShare->setRecipient(null);
            }
        }

        return $this;
    }
}
