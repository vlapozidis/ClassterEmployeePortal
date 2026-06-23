<?php

namespace App\Console\Commands;

use App\Services\EntraIDUserService;
use Illuminate\Console\Command;

class SyncEntraIDUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'entra:sync-users
                            {--force : Force sync even if recently synced}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync users from Microsoft Entra ID to the database';

    /**
     * Execute the console command.
     */
    public function handle(EntraIDUserService $entraIDUserService): int
    {
        $this->info('Starting Entra ID user sync...');

        $results = $entraIDUserService->syncUsersFromEntraID();

        $this->info('Sync completed with the following results:');
        $this->line("✓ Created: {$results['created']}");
        $this->line("✓ Updated: {$results['updated']}");
        $this->line("✗ Failed: {$results['failed']}");

        if (!empty($results['errors'])) {
            $this->error('Errors encountered:');
            foreach ($results['errors'] as $error) {
                $this->line("  - {$error}");
            }
        }

        return $results['failed'] > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
