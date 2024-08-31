<?php
namespace Modules\Site\Http\Traits;

use Modules\Site\Entities\Department;
use Modules\Site\Entities\Division;
use Modules\Site\Entities\Ptj;
use Modules\Site\Entities\Section;
use Modules\Site\Entities\Unit;
use Modules\Site\Entities\UserContext;
use Spatie\Permission\Models\Role;

trait OrgStructureTrait
{
    public function treeview(Role $role, $levelUp = true) {
        $user = auth()->user();

        $facultyIds = [];
        $departmentIds = [];
        $divisionIds = [];
        $sectionIds = [];
        $unitIds = [];
        $ownAuthorizeIds = [];

        if ($user->hasAnyRole(config('constants.role_top'))) {
            
            $faculties = Ptj::with('departments', 'departments.divisions', 'departments.divisions.sections', 'departments.divisions.sections.units')->active()->get();
            // $faculties = Ptj::active()->get();
            $facultyIds = $faculties->pluck('id')->toArray();
            
            foreach ($faculties as $faculty) {
                foreach ($faculty->departments as $department) {
                    $departmentIds = array_merge($departmentIds, [$department->id]);
                    foreach ($department->divisions as $division) {
                        $divisionIds = array_merge($divisionIds, [$division->id]);
                        foreach ($division->sections as $section) {
                            $sectionIds = array_merge($sectionIds, [$section->id]);
                            foreach ($section->units as $unit) {
                                $unitIds = array_merge($unitIds, [$unit->id]);
                            }
                        }
                    }
                }
            }

            $ownAuthorizeIds = array_merge($ownAuthorizeIds, $facultyIds);
            $ownAuthorizeIds = array_merge($ownAuthorizeIds, $departmentIds);
            $ownAuthorizeIds = array_merge($ownAuthorizeIds, $divisionIds);
            $ownAuthorizeIds = array_merge($ownAuthorizeIds, $sectionIds);
            $ownAuthorizeIds = array_merge($ownAuthorizeIds, $unitIds);
        }
        else {
            $userAssignments = UserContext::where([
                'user_id' => $user->id, 
                'role_id' => $role->id,
            ])->get();

            $ownAuthorizeIds = array_merge($ownAuthorizeIds, $userAssignments->pluck('model_id')->toArray());
    
            foreach ($userAssignments as $userAssignment) {
                #############
                ## FACULTY ##
                #############
                if ($userAssignment->model_type == config('constants.model_type.faculty.model')) {
                    $facAssignments = UserContext::where([
                        'user_id' => $user->id, 
                        'role_id' => $role->id,
                        'model_type' => config('constants.model_type.faculty.model'),
                    ])->get();
                    
                    if (count($facAssignments) > 0) {
                        foreach ($facAssignments as $item){
                            $facultyIds = array_merge($facultyIds, [$item->model_id]);
                            $model = strval($item->model_type)::find($item->model_id);
    
                            ## get down level ID
                            $departmentIds = array_merge($departmentIds, Department::where('faculty_id', $model->id)->get()->pluck('id')->toArray());
                            $divisionIds = array_merge($divisionIds, Division::where('faculty_id', $model->id)->get()->pluck('id')->toArray());
                            $sectionIds = array_merge($sectionIds, Section::where('faculty_id', $model->id)->get()->pluck('id')->toArray());
                            $unitIds = array_merge($unitIds, Unit::where('faculty_id', $model->id)->get()->pluck('id')->toArray());
                        }
                    }
                }
    
                ################
                ## DEPARTMENT ##
                ################
                if ($userAssignment->model_type == config('constants.model_type.department.model')) {

                    $depAssignments = UserContext::where([
                        'user_id' => $user->id, 
                        'role_id' => $role->id,
                        'model_type' => config('constants.model_type.department.model'),
                    ])->get();
        
                    if (count($depAssignments) > 0) {
                        foreach ($depAssignments as $item) {
                            $departmentIds = array_merge($departmentIds, [$item->model_id]);
                            $model = strval($item->model_type)::find($item->model_id);
                            
                            ## get up level ID
                            if ($levelUp) {
                                $facultyIds = array_merge($facultyIds, [$model->faculty_id]);
                            }
            
                            ## get down level ID
                            $divisionIds = array_merge($divisionIds, Division::where('department_id', $model->id)->get()->pluck('id')->toArray());
                            $sectionIds = array_merge($sectionIds, Section::where('department_id', $model->id)->get()->pluck('id')->toArray());
                            $unitIds = array_merge($unitIds, Unit::where('department_id', $model->id)->get()->pluck('id')->toArray());
                        }
                    }
                }
                ##############
                ## DIVISION ##
                ##############
                if ($userAssignment->model_type == config('constants.model_type.division.model')) {
                    
                    $divAssignments = UserContext::where([
                        'user_id' => $user->id, 
                        'role_id' => $role->id,
                        'model_type' => config('constants.model_type.division.model'),
                    ])->get();
        
                    if (count($divAssignments) > 0) {
                        foreach ($divAssignments as $item) {
    
                            $divisionIds = array_merge($divisionIds, [$item->model_id]);
                            $model = strval($item->model_type)::find($item->model_id);
                        
                            ## get up level ID
                            if ($levelUp) {
                                $facultyIds = array_merge($facultyIds, [$model->faculty_id]);
                                $departmentIds = array_merge($departmentIds, [$model->department_id]);
                            }
                            
                            ## get down level ID
                            $sectionIds = array_merge($sectionIds, Section::where('division_id', $model->id)->get()->pluck('id')->toArray());
                            $unitIds = array_merge($unitIds, Unit::where('division_id', $model->id)->get()->pluck('id')->toArray());
                        }
                    }
                }
                ##############
                ## SECTION ##
                ##############
                if ($userAssignment->model_type == config('constants.model_type.section.model')) {
                    
                    $secAssignments = UserContext::where([
                        'user_id' => $user->id, 
                        'role_id' => $role->id,
                        'model_type' => config('constants.model_type.section.model'),
                    ])->get();
        
                    if (count($secAssignments) > 0) {
                        foreach ($secAssignments as $item) {
    
                            $sectionIds = array_merge($sectionIds, [$item->model_id]);
                            $model = strval($item->model_type)::find($item->model_id);
                        
                            ## get up level ID
                            if ($levelUp) {
                                $facultyIds = array_merge($facultyIds, [$model->faculty_id]);
                                $departmentIds = array_merge($departmentIds, [$model->department_id]);
                                $divisionIds = array_merge($divisionIds, [$model->division_id]);
                            }
                            
                            ## get down level ID
                            $unitIds = array_merge($unitIds, Unit::where('section_id', $model->id)->get()->pluck('id')->toArray());
                        }
                    }
                }
                ##########
                ## UNIT ##
                ##########
                if ($userAssignment->model_type == config('constants.model_type.unit.model')) {
                    
                    $unitAssignments = UserContext::where([
                        'user_id' => $user->id, 
                        'role_id' => $role->id,
                        'model_type' => config('constants.model_type.unit.model'),
                    ])->get();
        
                    if (count($unitAssignments) > 0) {
                        foreach ($unitAssignments as $item) {
                            $unitIds = array_merge($unitIds, [$item->model_id]);
                            $model = strval($item->model_type)::find($item->model_id);
                        
                            ## get up level ID
                            if ($levelUp) {
                                $facultyIds = array_merge($facultyIds, [$model->faculty_id]);
                                $departmentIds = array_merge($departmentIds, [$model->department_id]);
                                $divisionIds = array_merge($divisionIds, [$model->division_id]);
                                $sectionIds = array_merge($sectionIds, [$model->section_id]);
                            }
                            
                        }
                    }
                }            
            }
        }

        $allAuthorizeIds = array_merge([], $facultyIds);
        $allAuthorizeIds = array_merge($allAuthorizeIds, $departmentIds);
        $allAuthorizeIds = array_merge($allAuthorizeIds, $divisionIds);
        $allAuthorizeIds = array_merge($allAuthorizeIds, $sectionIds);
        $allAuthorizeIds = array_merge($allAuthorizeIds, $unitIds);
        
        return [
            'facultyIds' => $facultyIds, 
            'departmentIds' => $departmentIds, 
            'divisionIds' => $divisionIds, 
            'sectionIds' => $sectionIds, 
            'unitIds' => $unitIds,
            'ownAuthorizeIds' => $ownAuthorizeIds,
            'allAuthorizeIds' => $allAuthorizeIds,
        ];
    }

    public function authorizeStructure(Role $role) {
        $allowIds = [];
        $treeview = $this->treeview($role, false);
        foreach ($treeview as $val) {
            $allowIds = array_merge($allowIds, $val);
        }
        return $allowIds;
    }

    /**
     * Find the array from value (multidimension)
     */
    protected function searchModelType($index, $name) {
        $array = config('constants.model_type');
        foreach ($array as $key => $val) {
            if ($val[$index] === $name) {
                return $val;
            }
        }
        return null;
     }

     protected function getNextLevel($level) {
        $array = config('constants.model_type');
        $modelType = $this->searchModelType('name', $level);

        if ($modelType != null) {
            $nextLevel = $modelType['level'] + 1;
            $nextModelType = $this->searchModelType('level', $nextLevel);
            return $nextModelType;
        }
        return false;
     }
}