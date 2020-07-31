<?php


namespace App\Models\Feed;


class FeedValidator implements FeedValidatorInterface
{
    /**
     * @var array
     */
    protected $rules = [];
    /**
     * @var array
     */
    protected $uniqueColumns = [];

    public function __construct(array $rules = [], array $uniqueColumns = [])
    {
        $this->setRules($rules);
        $this->setUniqueColumns($uniqueColumns);
    }

    /**
     * Set new laravel rules for each row in the feed
     * @param array $rules
     * @return self
     */
    public function setRules(array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @param array $uniqueColumns
     * @return self
     */
    public function setUniqueColumns(array $uniqueColumns): self
    {
        $this->uniqueColumns = $uniqueColumns;

        return $this;
    }

    /**
     * @param array $row
     * @return bool
     */
    public function validate(array $row): bool
    {
        // TODO: Implement validate() method.
    }
}
