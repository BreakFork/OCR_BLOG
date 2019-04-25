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
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $commentId;

    /**
     * The route of the post tied to the comment
     *
     * @var string $tiedPost the route of the post tied to the comment
     *
     * @Column(type="string")
     *
     * @ManyToOne(targetEntity="Post")
     * @JoinColumn(name="tiedPost", referencedColumnName="postRoute")
     */
    protected $tiedPost;

    /**
     * The author of the comment
     *
     * @var string $commentAuthor the author of the comment
     *
     * @Column(type="string")
     */
    protected $commentAuthor;

    /**
     * The email adress of the comment's author
     *
     * @var string $emailAuthor the email of the comment's author
     *
     * @Column(type="string")
     */
    protected $emailAuthor;

    /**
     * The content of the comment
     *
     * @var string $commentContent the content of the comment
     *
     * @Column(type="text")
     */
    protected $commentContent;

    /**
     * The date of the last modification of the comment
     *
     * @var integer $commentLastUpdateTimestamp the date of the last modification of the comment
     *
     * @Column(type="integer")
     */
    protected $commentLastUpdateTimestamp;

    /**
     * The state of the comment publishing
     *
     * @var bool $commentPublished the state of the comment publishing (false : unpublished - true : published)
     *
     * @Column(type="boolean")
     */
    protected $commentPublished = false;

/*//////////////////////////////////////////////////////////////////////////////////////////////////////*/

    /**
     * Returns a comment created into the database
     *
     * @return void
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function persist()
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
    public function getCommentId()
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
     * Returns the route of the post whom the comment is attached to
     *
     * @return string the route of the comment
     */
    public function getTiedPost(): string
    {
        return $this->tiedPost;
    }

    /**
     * Sets the route of the comment
     *
     * @param string $tiedPost
     */
    public function setTiedPost(string $tiedPost): void
    {
        $this->tiedPost = $tiedPost;
    }

    /**
     * Returns the author of the comment
     *
     * @return string The author of the comment
     */
    public function getCommentAuthor(): string
    {
        return $this->commentAuthor;
    }

    /**
     * Sets the author of the comment
     *
     * @param string $commentAuthor
     */
    public function setCommentAuthor(string $commentAuthor): void
    {
        $this->commentAuthor = $commentAuthor;
    }

    /**
     * Returns the email of the author's comment
     *
     * @return string The email of the comment
     */
    public function getEmailAuthor(): string
    {
        return $this->emailAuthor;
    }

    /**
     * Sets the email of the comment
     *
     * @param string $emailAuthor
     */
    public function setEmailAuthor(string $emailAuthor): void
    {
        $this->emailAuthor = $emailAuthor;
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
    public function getCommentPublished(): bool
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
}
