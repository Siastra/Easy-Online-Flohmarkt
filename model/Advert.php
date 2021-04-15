<?php


class Advert
{
    private int $id, $user_id,$price;
    private string $title, $description;

    public function __construct($id, $user_id, $title, $price, $description)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->price = $price;
        $this->description = $description;
       
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
     * @return int
     */

    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
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

    
}