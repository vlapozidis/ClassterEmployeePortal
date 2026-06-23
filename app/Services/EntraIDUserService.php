<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Two\User as SocialiteUser;

class EntraIDUserService
{
    /**
     * Find existing user or create new user from Entra ID profile.
     */
    public function findOrCreateUser(SocialiteUser $entraUser): ?User
    {
        try {
            // Try to find by entra_id first
            $user = User::where('entra_id', $entraUser->getId())->first();

            if ($user) {
                // Update existing user with latest Entra ID data
                return $this->updateUserFromEntraID($user, $entraUser);
            }

            // Try to find by email
            $user = User::where('email', $entraUser->getEmail())->first();

            if ($user) {
                // Link existing user to Entra ID
                return $this->linkUserToEntraID($user, $entraUser);
            }

            // Create new user
            return $this->createUserFromEntraID($entraUser);
        } catch (\Exception $e) {
            Log::error('EntraID user sync failed', [
                'error' => $e->getMessage(),
                'entra_id' => $entraUser->getId(),
                'email' => $entraUser->getEmail(),
            ]);

            return null;
        }
    }

    /**
     * Create new user from Entra ID profile.
     */
    private function createUserFromEntraID(SocialiteUser $entraUser): User
    {
        $name = $entraUser->getName() ?? explode('@', $entraUser->getEmail())[0];

        $user = User::create([
            'name' => $name,
            'email' => $entraUser->getEmail(),
            'entra_id' => $entraUser->getId(),
            'azure_tenant_id' => $entraUser->user['tid'] ?? null,
            'entra_email' => $entraUser->getEmail(),
            'entra_profile' => $entraUser->user,
            'auth_provider' => 'entra',
            'entra_synced_at' => now(),
            'email_verified_at' => now(),
            'password' => bcrypt(uniqid()), // Random password, not used for Entra auth
        ]);

        Log::info('New user created from Entra ID', [
            'user_id' => $user->id,
            'entra_id' => $user->entra_id,
            'email' => $user->email,
        ]);

        return $user;
    }

    /**
     * Link existing user to Entra ID.
     */
    private function linkUserToEntraID(User $user, SocialiteUser $entraUser): User
    {
        $user->update([
            'entra_id' => $entraUser->getId(),
            'azure_tenant_id' => $entraUser->user['tid'] ?? null,
            'entra_email' => $entraUser->getEmail(),
            'entra_profile' => $entraUser->user,
            'auth_provider' => 'entra',
            'entra_synced_at' => now(),
            'email_verified_at' => now(),
        ]);

        Log::info('Existing user linked to Entra ID', [
            'user_id' => $user->id,
            'entra_id' => $user->entra_id,
            'email' => $user->email,
        ]);

        return $user;
    }

    /**
     * Update user from Entra ID profile.
     */
    private function updateUserFromEntraID(User $user, SocialiteUser $entraUser): User
    {
        $updates = [
            'entra_email' => $entraUser->getEmail(),
            'entra_profile' => $entraUser->user,
            'entra_synced_at' => now(),
        ];

        // Update name if different
        if ($entraUser->getName() && $user->name !== $entraUser->getName()) {
            $updates['name'] = $entraUser->getName();
        }

        // Update email if different
        if ($user->email !== $entraUser->getEmail()) {
            $updates['email'] = $entraUser->getEmail();
        }

        $user->update($updates);

        return $user;
    }

    /**
     * Sync users from Entra ID directory.
     * Note: Requires Graph API access with appropriate permissions.
     */
    public function syncUsersFromEntraID(): array
    {
        $results = [
            'created' => 0,
            'updated' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        try {
            // This would require Graph API implementation
            // Placeholder for future implementation
            Log::info('Entra ID user sync started');

            // TODO: Implement Graph API user sync when credentials are available
            // This would fetch users from Azure AD and sync them

            Log::info('Entra ID user sync completed', $results);

            return $results;
        } catch (\Exception $e) {
            Log::error('Entra ID sync failed', ['error' => $e->getMessage()]);
            $results['failed']++;
            $results['errors'][] = $e->getMessage();

            return $results;
        }
    }
}
