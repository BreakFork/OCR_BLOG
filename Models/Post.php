<?php
/**
 * Post class file
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
 * Model for post
 *
 * @category Models
 * @package  Models
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 *
 * @Entity @Table(name="Post")
 */
class Post
{
    /**
     * Post's id into Post table
     *
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * The route of the post
     *
     * @var string $route the route of the post
     *
     * @Column(type="string")
     */
    protected $postRoute;

    /**
     * The title of the post
     *
     * @var string $postTitle the title of the post
     *
     * @Column(type="string")
     */
    protected $postTitle;

    /**
     * The author of the post
     *
     * @var string $postAuthor the author of the post
     *
     * @Column(type="string")
     */
    protected $postAuthor;

    /**
     * The content of the post
     *
     * @var string $postContent the content of the post
     *
     * @Column(type="string")
     */
    protected $postContent;

    /**
     * The date of the last modification of the post
     *
     * @var int $lastUpdateTimestamp the date of the last modification of the post
     *
     * @Column(type="int")
     */
    protected $lastUpdateTimestamp;

    /**
     * Instantiates a new post
     *
     * @param string   $postRoute           the route of the post to set
     * @param string   $postTitle           the title of the post to set
     * @param string   $postAuthor          the author of the post to set
     * @param string   $postContent         the content of the post to set
     * @param int      $lastUpdateTimestamp the date of the last modification of the post to set
     */
    public function __construct(string $postRoute, string $postTitle, string $postAuthor, string $postContent, int $lastUpdateTimestamp)
    {
        $this->setPostRoute($postRoute);
        $this->setPostTitle($postTitle);
        $this->setPostAuthor($postAuthor);
        $this->setPostContent($postContent);
        $this->setLastUpdateTimestamp($lastUpdateTimestamp);
    }

    /**
     * Returns a post created into the database
     *
     * @return Post
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function persist(): ?Post
    {
        $post = null;

        $postRepository = Database::getEntityManager();

        $postRepository->persist($this);
        $postRepository->flush();

        return $post;
    }

    /**
     * Returns the post's id for the database
     *
     * @return integer the id of the post
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the id of the post
     *
     * @param integer $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Returns the route of the post
     *
     * @return string the route of the post
     */
    public function getRoute()
    {
        return $this->postRoute;
    }

    /**
     * Sets the route of the post
     *
     * @param string $route
     */
    public function setPostRoute($postRoute): void
    {
        $this->postRoute = $postRoute;
    }

    /**
     * Returns the title of the post
     *
     * @return string the title of the post
     */
    public function getPostTitle(): string
    {
        return $this->postTitle;
    }

    /**
     * Sets the title of the post
     *
     * @param string $postTitle
     */
    public function setPostTitle(string $postTitle): void
    {
        $this->postTitle = $postTitle;
    }

    /**
     * Returns the author of the post
     *
     * @return string the author of the post
     */
    public function getPostAuthor(): string
    {
        return $this->postAuthor;
    }

    /**
     * Sets the author of the post
     *
     * @param string $postAuthor
     */
    public function setPostAuthor(string $postAuthor): void
    {
        $this->postAuthor = $postAuthor;
    }

    /**
     * Returns the content of the post
     *
     * @return string the content of the post
     */
    public function getPostContent(): string
    {
        return $this->postContent;
    }

    /**
     * Sets the content of the post
     *
     * @param string $postContent
     */
    public function setPostContent(string $postContent): void
    {
        $this->postContent = $postContent;
    }

    /**
     * Returns the date of the last modification of the post
     *
     * @return int the date of the last modification of the post
     */
    public function getLastUpdateTimestamp(): int
    {
        return $this->lastUpdateTimestamp;
    }

    /**
     * Sets the date of the last modification of the post
     *
     * @param int $lastUpdateTimestamp
     */
    public function setLastUpdateTimestamp(int $lastUpdateTimestamp): void
    {
        $this->lastUpdateTimestamp = $lastUpdateTimestamp;
    }
}
