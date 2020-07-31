<?php


namespace App\Models\Feed;


/**
 * Entity for temporary DB table
 * Class FeedRowEntity
 * @package App\Models\Feed
 */
class FeedRowEntity
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $firstName;
    /**
     * @var string
     */
    public $lastName;
    /**
     * @var int
     */
    public $cardNumber;
    /**
     * @var string
     */
    public $email;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'card_number' => $this->cardNumber,
            'email' => $this->email,
        ];
    }

}
