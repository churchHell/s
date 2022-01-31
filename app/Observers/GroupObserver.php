<?php

namespace App\Observers;

use App\Models\Group;

class GroupObserver
{
    /**
     * Handle the group "creating" event.
     *
     * @param  \App\Models\Group  $group
     * @return void
     */
    public function creating(Group $group)
    {
        if(!$group->created_user_id){
            $group->created_user_id = auth()->id();
        }
    }

    public function retrieved(Group $group)
    {

    }

    /**
     * Handle the group "updated" event.
     *
     * @param  \App\Models\Group  $group
     * @return void
     */
    public function updating(Group $group)
    {
        
    }

    /**
     * Handle the group "deleted" event.
     *
     * @param  \App\Models\Group  $group
     * @return void
     */
    public function deleting(Group $group)
    {
        throw_if($group->orders->count() > 0, \Exception::class, __('group-not-empty'));
    }

    /**
     * Handle the group "restored" event.
     *
     * @param  \App\Models\Group  $group
     * @return void
     */
    public function restored(Group $group)
    {
        //
    }

    /**
     * Handle the group "force deleted" event.
     *
     * @param  \App\Models\Group  $group
     * @return void
     */
    public function forceDeleted(Group $group)
    {
        //
    }
}
