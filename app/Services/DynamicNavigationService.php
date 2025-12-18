<?php

namespace App\Services;

use App\Models\Navigation;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\Facades\Auth;

class DynamicNavigationService
{
    /**
     * Get navigation items from the database for a specific handle
     */
    public static function getNavigationItems(string $handle): array
    {
        $navigation = Navigation::where('handle', $handle)->first();

        if (!$navigation || empty($navigation->items)) {
            return [];
        }

        return static::buildNavigationItems($navigation->items);
    }

    /**
     * Build navigation items from the stored JSON data
     */
    protected static function buildNavigationItems(array $items): array
    {
        $navigationItems = [];
        $user = Auth::user();

        foreach ($items as $index => $item) {
            // Check role permission
            if (!static::canViewItem($item, $user)) {
                continue;
            }

            $navItem = NavigationItem::make($item['label'] ?? 'Untitled')
                ->url($item['url'] ?? '#')
                ->sort($index)
                ->openUrlInNewTab(($item['target'] ?? '_self') === '_blank');

            // Add to collection
            $navigationItems[] = $navItem;
        }

        return $navigationItems;
    }

    /**
     * Check if user can view the menu item based on roles
     */
    protected static function canViewItem(array $item, $user): bool
    {
        // If no roles specified, everyone can see it
        if (empty($item['roles'])) {
            return true;
        }

        // If user is not logged in, hide role-restricted items
        if (!$user) {
            return false;
        }

        // Check if user has any of the required roles
        return $user->hasAnyRole($item['roles']);
    }

    /**
     * Get all navigations as groups
     */
    public static function getAllNavigationGroups(): array
    {
        $navigations = Navigation::all();
        $groups = [];

        foreach ($navigations as $navigation) {
            if (empty($navigation->items)) {
                continue;
            }

            $items = static::buildNavigationItems($navigation->items);
            
            if (!empty($items)) {
                $groups[] = NavigationGroup::make($navigation->name)
                    ->items($items);
            }
        }

        return $groups;
    }
}
