<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackupDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database {--path= : Path to save the SQL dump}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a SQL dump of the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->option('path') ?: storage_path('app/database_backup.sql');
        
        try {
            $this->info('Creating database backup...');
            
            $sql = $this->generateSqlDump();
            
            file_put_contents($path, $sql);
            
            $this->info("Database backup saved to: {$path}");
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Database backup failed: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Generate SQL dump
     */
    private function generateSqlDump()
    {
        $sql = "-- SJ Fashion Hub Database Backup\n";
        $sql .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

        // Get all tables
        $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");

        foreach ($tables as $table) {
            $tableName = $table->name;
            
            // Get table schema
            $sql .= $this->getTableSchema($tableName);
            
            // Get table data
            $sql .= $this->getTableData($tableName);
        }

        $sql .= "\nSET FOREIGN_KEY_CHECKS = 1;\n";
        
        return $sql;
    }

    /**
     * Get table schema
     */
    private function getTableSchema($tableName)
    {
        $schema = DB::select("SELECT sql FROM sqlite_master WHERE type='table' AND name=?", [$tableName]);
        
        if (empty($schema)) {
            return "";
        }

        $createStatement = $schema[0]->sql;
        
        return "\n-- Table structure for table `{$tableName}`\n"
             . "DROP TABLE IF EXISTS `{$tableName}`;\n"
             . $createStatement . ";\n\n";
    }

    /**
     * Get table data
     */
    private function getTableData($tableName)
    {
        $sql = "\n-- Dumping data for table `{$tableName}`\n";
        
        $rows = DB::table($tableName)->get();
        
        if ($rows->isEmpty()) {
            return $sql . "-- No data to dump\n\n";
        }

        $columns = Schema::getColumnListing($tableName);
        $columnList = '`' . implode('`, `', $columns) . '`';
        
        $sql .= "INSERT INTO `{$tableName}` ({$columnList}) VALUES\n";
        
        $values = [];
        foreach ($rows as $row) {
            $rowData = [];
            foreach ($columns as $column) {
                $value = $row->$column;
                if (is_null($value)) {
                    $rowData[] = 'NULL';
                } elseif (is_string($value)) {
                    $rowData[] = "'" . addslashes($value) . "'";
                } elseif (is_bool($value)) {
                    $rowData[] = $value ? '1' : '0';
                } else {
                    $rowData[] = $value;
                }
            }
            $values[] = '(' . implode(', ', $rowData) . ')';
        }
        
        $sql .= implode(",\n", $values) . ";\n\n";
        
        return $sql;
    }
}
