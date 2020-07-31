<?php

namespace App\Console\Commands;

use App\Models\Feed\CsvFeed;
use App\Models\Feed\FeedConverter;
use App\Models\Feed\FeedProcessor;
use App\Models\Feed\FeedRowEntity;
use App\Models\Feed\FeedValidator;
use Illuminate\Console\Command;

/**
 * Update clients info in a Harvard university
 * Class CheckFeedsStatuses
 * @package App\Console\Commands
 */
class HarvardClientsUpdater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'harvard:clients-updater';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update clients info in a Harvard university';

    /**
     * @return mixed
     */
    public function handle()
    {
        $filePath = 'somepath/example.csv';

        $feed = new CsvFeed($filePath);
        $validator = new FeedValidator(
            [
                'Identifier' => 'integer|required',
                'First Name' => 'string|required',
                'User email' => 'email|required',
                // etc...
            ],
            [
                'Identifier' => 'client_id',
                'First Name' => 'first_name',
                'Last Name' => 'last_name',
                // etc..
            ]
        );
        $feedConverter = new FeedConverter($validator);
        // function for post processing each row, for manual changing
        $feedConverter->addEntityCallable(function (FeedRowEntity $entity, array $data) {
            $entity->firstName = $data['1234'] . ' ' . $data['5678'];
        });
        // run
        $processor = new FeedProcessor($feed, $feedConverter);
        $processor->loadFeedData();

    }
}
