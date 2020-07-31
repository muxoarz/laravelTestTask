<?php


namespace App\Models\Feed;


use Illuminate\Support\Facades\DB;

class FeedProcessor
{
    protected $temporaryTableName = 't_clients';
    protected $temporaryTableBatchSize = 10000;
    /**
     * Array for batch insert to mysql
     * @var array
     */
    private $temporaryTableBatch = [];
    /**
     * @var AbstractFeed
     */
    protected $feed;
    /**
     * @var FeedConverterInterface
     */
    protected $converter;

    public function __construct(AbstractFeed $feed, FeedConverterInterface $converter)
    {
        $this->feed = $feed;
        $this->converter = $converter;
        $this->initDB();
    }

    public function loadFeedData()
    {
        $this->feed->getColumnNames();
        foreach ($this->feed->getNextRow() as $row) {
            $entity = $this->converter->convertDataToEntity($row);
            if ($entity !== null) {
                $this->saveToDB($entity);
            } else {
                //TODO: save an error to the report
            }
        }
        // insert last iteration
        $this->insertBatchDataToTmpTable();

        $this->runReports();

        $this->saveTmpToRealTable();
    }

    /**
     * Create temporary table for future using
     */
    protected function initDB()
    {
        DB::statement("DROP TEMPORARY TABLE IF EXISTS {$this->temporaryTableName};");
        DB::statement("CREATE TEMPORARY TABLE {$this->temporaryTableName}
            (
            `client_id` varchar(50),
            `first_name` varchar(50),
            `last_name` varchar(50),
            `card_number` bigint,
            `email` varchar(50),
            `is_unique` boolean default true
            )
        ");
    }

    /**
     * @param FeedRowEntity $entity
     */
    protected function saveToDB(FeedRowEntity $entity)
    {
        $this->temporaryTableBatch[] = [
            'client_id' => $entity->id,
            'first_name' => $entity->firstName,
            // etc..
        ];
        if (count($this->temporaryTableBatch) >= $this->temporaryTableBatchSize) {
            $this->insertBatchDataToTmpTable();
        }
    }

    /**
     * Insert and Clear batch data for next iteration
     */
    protected function insertBatchDataToTmpTable()
    {
        if (count($this->temporaryTableBatch) > 0) {
            DB::table($this->temporaryTableName)->insert($this->temporaryTableBatch);
        }
        $this->temporaryTableBatch = [];
    }

    /**
     * Run reports before we update real table
     */
    protected function runReports()
    {
        // mark non unique rows by ID (TODO: add other columns from validator)
        DB::statement("DROP TEMPORARY TABLE IF EXISTS t_non_unique_ids;");
        DB::statement("CREATE TEMPORARY TABLE t_non_unique_ids
            SELECT client_id, count(*) AS cnt FROM t_clients HAVING cnt > 1
        ");
        $nonUniqueRowsCount = DB::update("UPDATE t_clients JOIN t_non_unique_ids USING(client_id)
            SET t_clients.is_unique = false
        ");
        // TODO: remove non unique rows after non uniq report

        // Report query example (we can use cursor here for memory saving)
        $deletedClients = DB::select("SELECT clients.* FROM clients
            LEFT JOIN t_clients ON clients.id = t_clients.client_id
            WHERE t_clients.client_id IS NULL AND clients.deleted_at IS NULL
        ");
        // TODO: add reports
    }

    /**
     * Save all data
     */
    protected function saveTmpToRealTable()
    {
        // TODO: add other fields
        DB::insert("INSERT INTO clients (id, first_name)
            SELECT client_id, first_name
            FROM {$this->temporaryTableName}
            ON DUPLICATE KEY UPDATE first_name=VALUES(first_name)
        ");
        // set deleted_at for deleted clients
        DB::update("UPDATE clients LEFT JOIN t_clients ON clients.id = t_clients.client_id
            SET clients.deleted_at = NOW()
            WHERE clients.deleted_at IS NULL AND t_clients.client_id IS NULL
        ");
    }
}
