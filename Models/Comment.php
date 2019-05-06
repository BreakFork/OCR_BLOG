<?php
/**
 * Comment class file
 *
 * PHP Version 7.2
 *
 * @category Models
 * @package  Models
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */

namespace Models;

use System\Database;

/**
 * Model for comment
 *
 * @category Models
 * @package  Models
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 *
 * @Entity @Table(name="Comment")
 */
class Comment
{
    /**
     * Comment's id into comment table
     *
     * @var int The id of the comment
     *
     * @Id @Column(type="integer") @GeneratedValue
     */
    private $commentId;

    /**
     * The id of the post whom the comments are attached to
     *
     * @var int
     *
     * @ManyToOne(targetEntity="Models\Post", inversedBy="comments")
     * @JoinColumn(name="linkedPost_id", referencedColumnName="id")
     */
    private $linkedPost;

    /**
     * The name of author of the comment
     *
     * @var string $commentAuthor the author of the comment
     *
     * @Column(type="string")
     */
    private $commentAuthorName;

    /**
     * The email adress of the comment's author
     *
     * @var string $emailAuthor the email of the comment's author
     *
     * @Column(type="string")
     */
    private $commentAuthorEmail;

    /**
     * The content of the comment
     *
     * @var string $commentContent the content of the comment
     *
     * @Column(type="text")
     */
    private $commentContent;

    /**
     * The timestamp when the comment has been lastly modified
     *
     * @var integer $commentLastUpdateTimestamp The timestamp when the comment has been lastly modified
     *
     * @Column(type="integer")
     */
    private $commentLastUpdateTimestamp;

    /**
     * Whether the comment is shown on public post or not
     *
     * @var boolean $commentPublished Whether the comment is shown on public post or not
     *
     * @Column(type="boolean")
     */
    private $commentPublished = false;

/*//////////////////////////////////////////////////////////////////////////////////////////////////////*/

    /**
     * Returns a comment created into the database
     *
     * @return void
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function commentPersist()
    {
        $entityManager = Database::getEntityManager();
        $entityManager->persist($this);
        $entityManager->flush();
    }

/*//////////////////////////////////////////////////////////////////////////////////////////////////////*/

    /**
     * Returns the comment's id for DB
     *
     * @return integer The id of the comment
     */
    public function getCommentId(): int
    {
        return $this->commentId;
    }

    /**
     * Set the id of the comment
     *
     * @param integer $commentId
     */
    public function setCommentId($commentId): void
    {
        $this->commentId = $commentId;
    }

    /**
     * Returns the id of the post
     *
     * @return int
     */
    public function getLinkedPost(): int
    {
        return $this->linkedPost;
    }

    /**
     * Sets the id of the post
     *
     * @param int $linkedPost
     */
    public function setLinkedPost(int $linkedPost): void
    {
        $this->linkedPost = $linkedPost;
    }

    /**
     * Returns the author of the comment
     *
     * @return string The author of the comment
     */
    public function getCommentAuthorName(): string
    {
        return $this->commentAuthorName;
    }

    /**
     * Sets the author of the comment
     *
     * @param string $commentAuthorName
     */
    public function setCommentAuthorName(string $commentAuthorName): void
    {
        $this->commentAuthorName = $commentAuthorName;
    }

    /**
     * Returns the email of the author's comment
     *
     * @return string The email of the comment
     */
    public function getCommentAuthorEmail(): string
    {
        return $this->commentAuthorEmail;
    }

    /**
     * Sets the email of the comment
     *
     * @param string $commentAuthorEmail
     */
    public function setCommentAuthorEmail(string $commentAuthorEmail): void
    {
        $this->commentAuthorEmail = $commentAuthorEmail;
    }

    /**
     * Returns the content of the comment
     *
     * @return string The content of the comment
     */
    public function getCommentContent(): string
    {
        return $this->commentContent;
    }

    /**
     * Sets the content of the comment
     *
     * @param string $commentContent
     */
    public function setCommentContent(string $commentContent): void
    {
        $this->commentContent = $commentContent;
    }

    /**
     * Returns the date of the last modification of the comment
     *
     * @return int The date of the last modification of the comment
     */
    public function getCommentLastUpdateTimestamp(): int
    {
        return $this->commentLastUpdateTimestamp;
    }

    /**
     * Sets the date of the last modification of the comment
     *
     * @param int $commentLastUpdateTimestamp
     */
    public function setCommentLastUpdateTimestamp(int $commentLastUpdateTimestamp): void
    {
        $this->commentLastUpdateTimestamp = $commentLastUpdateTimestamp;
    }

    /**
     * Returns the state of the comment publication
     *
     * @return bool The state of the comment publication
     */
    public function isCommentPublished(): bool
    {
        return $this->commentPublished;
    }

    /**
     * Sets the state of the comment publication
     *
     * @param bool $commentPublished
     */
    public function setCommentPublished(bool $commentPublished): void
    {
        $this->commentPublished = $commentPublished;
    }

/*//////////////////////////////////////////////////////////////////////////////////////////////////////*/


}
