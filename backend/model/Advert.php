<?php


class Advert
{
    private int $id,$price;
    private string $title, $description;
    private DateTime $createdAt;
    private User $user;
    private DB $db;

    public function __construct(int $id,  string $title, int $price, User $user, DateTime $createdAt, string $description)
    {
        $this->db = new DB();
        $this->id = $id;
        $this->user = $user;
        $this->title = $title;
        $this->price = $price;
        $this->description = $description;
        $this->createdAt = $createdAt;

    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
        /**
     * @return User
     */

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }  
    
    /**
    * @return string
    */
   public function getTitle(): string
   {
       return $this->title;
   }

   /**
    * @param string $title
    */
   public function setTitle(string $title): void
   {
       $this->title = $title;
   } 
      
   /**
   * @return int
   */
  public function getPrice(): int
  {
      return $this->price;
  }

  /**
   * @param int $price
   */
  public function setPrice(int $price): void
  {
      $this->price = $price;
  }

   /**
   * @return string
   */
  public function getDescription(): string
  {
      return $this->description;
  }

  /**
   * @param string $description
   */
  public function setDescription(string $description): void
  {
      $this->description = $description;
  }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt->format("Y-m-d H:m:s");
    }

    
}