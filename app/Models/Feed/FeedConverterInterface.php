<?php


namespace App\Models\Feed;


interface FeedConverterInterface
{
    public function __construct(FeedValidatorInterface $validator);

    /**
     * Rows map
     * @param array $map
     */
    public function mapColumns(array $map);

    /**
     * @param array $row
     * @return FeedRowEntity
     */
    public function convertDataToEntity(array $row): ?FeedRowEntity;
}
