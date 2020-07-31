<?php


namespace App\Models\Feed;


interface FeedValidatorInterface
{
    /**
     * Set standard laravel validation rules
     * @param array $rules
     */
    public function setRules(array $rules);

    /**
     * Unique columns
     * @param array $columns
     */
    public function setUniqueColumns(array $columns);

    /**
     * Return true if row successfully proceess validation rules
     * @param array $row
     * @return bool
     */
    public function validate(array $row): bool;
}
