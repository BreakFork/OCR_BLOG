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
     * @var boolean $commentPending Whether the comment is shown on public post or not
     *
     * @Column(type="boolean")
     */
    private $commentPending = true;

    /**
     * Whether the comment is activated or not.
     * Mainly to display the comment or not, according to whether it is useful or not in the admin pages
     *
     * @var bool $commentUnabled Whether the comment is activated or not.
     *
     * @Column(type="boolean")
     */
    private $commentEnable = true;

    //__METHODS_________________________________________________________________________________________

    //_____________________________________________________________________PERSIST & FLUSH

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

    //_____________________________________________________________________SELECT COMMENTS (PUBLISHED, ACTIVATED)

    /**
     * Returns a list of the published comments attached to a specific post from DB
     *
     * @param integer $linkedPost The id of the post whom the comments are attached to
     *
     * @return array $commentsList The list of the published comments
     */
    public static function getPublishedCommentsList($linkedPost)
    {
        $commentRepository = Database::getEntityManager()->getRepository("Models\\Comment");
        $commentsList = $commentRepository->findBy(
            array(
                "linkedPost"     => $linkedPost,
                "commentEnable"  => true,
                "commentPending" => false
            )
        );

        return $commentsList;
    }

    //______________________________________________________________________SELECT COMMENTS (UNPUBLISHED, DESACTIVATED)

    /**
     * Returns a list of the unpublished and disactivated comments from DB
     *
     * @return array|null $commentsList The list of the unpublished and disactivated comments
     */
    public static function getCommentsPendingList()
    {
        $commentRepository = Database::getEntityManager()->getRepository("Models\\Comment");
        $commentsList = $commentRepository->findBy(
            array(
                "commentPending" => true
            )
        );

        $scanCommentTable = Database::getEntityManager()
                            ->getRepository("Models\\Comment")
                            ->findOneBy(array('commentPending' => true));

        if ($scanCommentTable !== null) {
            $scanResult = $commentsList;
        } else {
            $scanResult = null;
        }

        return $scanResult;
    }

    //_______________________________________________________________________UPDATE COMMENT

    /**
     * Controller method to modify the status of the comment (activated and published)
     * Returns a comment from DB selected by id
     *
     * @param int|null $commentId The id of the comment or null if the comment doesn't exist in DB
     *
     * @return Comment|null A comment object from DB, selected by id or null if $commentId is null
     */
    public static function updateComment($commentId): ?Comment
    {
        $commentRepository = Database::getEntityManager()->getRepository("Models\\Comment");
        $comment = $commentRepository->findOneBy(
            array(
                "commentId" => $commentId
            )
        );

        $comment->setCommentEnable(true);
        $comment->setCommentPending(false);

        if ($commentId != null) {
            /**
             * @noinspection PhpIncompatibleReturnTypeInspection
             * Safe because $comment has been generated by Doctrine
             */
            return $comment;
        }
        return null;
    }

    //_______________________________________________________________________DELETE COMMENT

    /**
     * Removes a comment object from DB selected by id
     *
     * @param $commentId
     *
     * @return void
     */
    public static function removeComment($commentId): void
    {
        $commentRepository = Database::getEntityManager()->getRepository("Models\\Comment");
        $comment = $commentRepository->findOneBy(
            array(
                "commentId" => $commentId)
        );
        try {
            $entityManager = Database::getEntityManager();
            $entityManager->persist($comment);
            $entityManager->remove($comment);
            $entityManager->flush();
        } catch (\Exception $e) {
            //TODO: 404
            echo 'ERROR 404';
        }
   }

//__GETTERS & SETTERS__________________________________________________________________________________

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
     * @param  $linkedPost
     */
    public function setLinkedPost(Post $linkedPost)
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
    public function getCommentPending(): bool
    {
        return $this->commentPending;
    }

    /**
     * Sets the state of the comment publication
     *
     * @param bool $commentPending
     */
    public function setCommentPending(bool $commentPending): void
    {
        $this->commentPending = $commentPending;
    }

    /**
     * Returns the state of the comment activation in admin's pages
     *
     * @return bool The state of the comment's activation
     */
    public function isCommentEnable(): bool
    {
        return $this->commentEnable;
    }

    /**
     * Sets the state of the comment activation in admin's pages
     *
     * @param bool $commentEnable
     */
    public function setCommentEnable(bool $commentEnable): void
    {
        $this->commentEnable = $commentEnable;
    }
}
