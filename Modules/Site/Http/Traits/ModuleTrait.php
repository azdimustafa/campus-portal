<?php
namespace Modules\Site\Http\Traits;

use Modules\Site\Entities\Module;

trait ModuleTrait
{
    public function getModuleListUserTypes($code) {
        $moduleFleet = Module::with('bookingAvailableFor')->where('code', $code)->first();
        $listBookingRestriction = $moduleFleet->bookingAvailableFor;
        return $listBookingRestriction;
    }
}