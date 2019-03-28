<?php
/**
 * User class file
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
     * @Id @Column(type="string") @GeneratedValue
     */
    protected $route;

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
     * @var DateTime $postDateModified the content of the post
     *
     * @Column(type="DateTime")
     */
    protected $postDateModified;





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
        return $this->route;
    }

    /**
     * Sets the route of the post
     *
     * @param string $route
     */
    public function setRoute($route): void
    {
        $this->route = $route;
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
     * @return DateTime the date of the last modification of the post
     */
    public function getPostDateModified(): DateTime
    {
        return $this->postDateModified;
    }

    /**
     * Sets the date of the last modification of the post
     *
     * @param DateTime $postDateModified
     */
    public function setPostDateModified(DateTime $postDateModified): void
    {
        $this->postDateModified = $postDateModified;
    }
}
