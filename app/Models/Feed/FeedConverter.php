<?php


namespace App\Models\Feed;


class FeedConverter implements FeedConverterInterface
{
    /**
     * @var array
     */
    protected $rules = [];
    /**
     * @var array
     */
    protected $map = [];
    /**
     * @var FeedValidatorInterface
     */
    private $validator;
    /**
     * @var \Closure
     */
    private $postEntityCreationFunc;

    /**
     * FeedConverter constructor.
     * @param FeedValidatorInterface $validator
     */
    public function __construct(FeedValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $map
     * @return $this
     */
    public function mapColumns(array $map): self
    {
        $this->map = $map;

        return $this;
    }

    /**
     * @param array $row
     * @return FeedRowEntity
     */
    public function convertDataToEntity(array $row): ?FeedRowEntity
    {
        // TODO: add mapping and validation
        if (!$this->validator->validate([])) {
            return null;
        }
        $entity = new FeedRowEntity();
        $entity->id = '123';
        // ...
        if ($this->postEntityCreationFunc) {
            $this->postEntityCreationFunc($entity, $data);
        }

        return $entity;
    }

    public function addEntityCallable(\Closure $func)
    {
        $this->postEntityCreationFunc = $func;
    }
}
