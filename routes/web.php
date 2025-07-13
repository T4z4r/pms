<?php

use App\Models\Module;
use App\Models\Feature;
use App\Models\Submodule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RemarkController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\TestPlanController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectTagController;
use App\Http\Controllers\TaskReviewController;
use App\Http\Controllers\TaskUpdateController;
use App\Http\Controllers\ProjectRoleController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\SecurityGapController;
use App\Http\Controllers\TraceMetricController;
use App\Http\Controllers\BrandSettingController;
use App\Http\Controllers\SystemDesignController;
use App\Http\Controllers\SystemManualController;
use App\Http\Controllers\ProjectPriorityController;
use App\Http\Controllers\SecurityGapTemplateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    // Users Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}/update', [UserController::class, 'update'])->name('users.update');
    Route::any('/users/delete/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // start of Roles Routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // start of Permission Routes
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');

    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/permissions/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/destroy/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');



    // Departments
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/{id}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

    // Positions
    Route::get('/positions', [PositionController::class, 'index'])->name('positions.index');
    Route::post('/positions', [PositionController::class, 'store'])->name('positions.store');
    Route::get('/positions/{id}/edit', [PositionController::class, 'edit'])->name('positions.edit');
    Route::put('/positions/{id}', [PositionController::class, 'update'])->name('positions.update');
    Route::delete('/positions/{id}', [PositionController::class, 'destroy'])->name('positions.destroy');


    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');


    // Project Types
    Route::get('/project-types', [ProjectTypeController::class, 'index'])->name('project_types.index');
    Route::post('/project-types', [ProjectTypeController::class, 'store'])->name('project_types.store');
    Route::put('/project-types/{projectType}', [ProjectTypeController::class, 'update'])->name('project_types.update');
    Route::delete('/project-types/{projectType}', [ProjectTypeController::class, 'destroy'])->name('project_types.destroy');

    // Project Priorities
    Route::get('/project-priorities', [ProjectPriorityController::class, 'index'])->name('project_priorities.index');
    Route::post('/project-priorities', [ProjectPriorityController::class, 'store'])->name('project_priorities.store');
    Route::put('/project-priorities/{projectPriority}', [ProjectPriorityController::class, 'update'])->name('project_priorities.update');
    Route::delete('/project-priorities/{projectPriority}', [ProjectPriorityController::class, 'destroy'])->name('project_priorities.destroy');

    // Project Roles
    Route::get('/project-roles', [ProjectRoleController::class, 'index'])->name('project_roles.index');
    Route::post('/project-roles', [ProjectRoleController::class, 'store'])->name('project_roles.store');
    Route::put('/project-roles/{projectRole}', [ProjectRoleController::class, 'update'])->name('project_roles.update');
    Route::delete('/project-roles/{projectRole}', [ProjectRoleController::class, 'destroy'])->name('project_roles.destroy');

    // Project Tags
    Route::get('/project-tags', [ProjectTagController::class, 'index'])->name('project_tags.index');
    Route::post('/project-tags', [ProjectTagController::class, 'store'])->name('project_tags.store');
    Route::put('/project-tags/{projectTag}', [ProjectTagController::class, 'update'])->name('project_tags.update');
    Route::delete('/project-tags/{projectTag}', [ProjectTagController::class, 'destroy'])->name('project_tags.destroy');

    // Ratings
    Route::get('/ratings', [RatingController::class, 'index'])->name('ratings.index');
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::put('/ratings/{rating}', [RatingController::class, 'update'])->name('ratings.update');
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');


    // Trace Metrics
    Route::get('/trace-metrics', [TraceMetricController::class, 'index'])->name('trace_metrics.index');
    Route::post('/trace-metrics', [TraceMetricController::class, 'store'])->name('trace_metrics.store');
    Route::put('/trace-metrics/{traceMetric}', [TraceMetricController::class, 'update'])->name('trace_metrics.update');
    Route::delete('/trace-metrics/{traceMetric}', [TraceMetricController::class, 'destroy'])->name('trace_metrics.destroy');

    // Projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}/view', [ProjectController::class, 'view'])->name('projects.view');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Issue Routes
    Route::post('/projects/{project}/issues', [ProjectController::class, 'storeIssue'])->name('issues.store');
    Route::put('/issues/{issue}', [ProjectController::class, 'updateIssue'])->name('issues.update');
    Route::delete('/issues/{issue}', [ProjectController::class, 'destroyIssue'])->name('issues.destroy');

    Route::post('/projects/{project}/issues', [IssueController::class, 'store'])->name('issues.store');
    Route::put('/issues/{issue}', [IssueController::class, 'update'])->name('issues.update');
    Route::delete('/issues/{issue}', [IssueController::class, 'destroy'])->name('issues.destroy');
    Route::get('/issues', [IssueController::class, 'index'])->name('issues.index');
    // Tasks
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{task}/view', [TaskController::class, 'view'])->name('tasks.view');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/mark-completed', [TaskController::class, 'markCompleted'])->name('tasks.mark_completed');
    Route::get('/tasks/export-template', [TaskController::class, 'exportTemplate'])->name('tasks.export_template');
    Route::post('/tasks/import', [TaskController::class, 'import'])->name('tasks.import');
    Route::post('/tasks/export', [TaskController::class, 'exportTasks'])->name('tasks.export');
    // Subtasks
    Route::post('/tasks/{task}/subtasks', [SubtaskController::class, 'store'])->name('subtasks.store');
    Route::put('/subtasks/{subtask}', [SubtaskController::class, 'update'])->name('subtasks.update');
    Route::delete('/subtasks/{subtask}', [SubtaskController::class, 'destroy'])->name('subtasks.destroy');
    Route::post('/subtasks/{subtask}/mark-completed', [SubtaskController::class, 'markCompleted'])->name('subtasks.mark_completed');

    // Comments
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Attachments
    Route::post('/attachments', [AttachmentController::class, 'store'])->name('attachments.store');
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');

    // Remarks
    Route::post('/remarks', [RemarkController::class, 'store'])->name('remarks.store');
    Route::delete('/remarks/{remark}', [RemarkController::class, 'destroy'])->name('remarks.destroy');

    // Task Reviews
    Route::post('/tasks/{task}/reviews', [TaskReviewController::class, 'store'])->name('task_reviews.store');


    // Task Updates
    Route::post('/task-updates', [TaskUpdateController::class, 'store'])->name('task_updates.store');


    // Activities
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/data', [ActivityController::class, 'getActivities'])->name('activities.data');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::post('/activities/assign-user', [ActivityController::class, 'storeForUser'])->name('activities.storeForUser');
    Route::post('/activities/assign-all', [ActivityController::class, 'storeForAll'])->name('activities.storeForAll');
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');



    // Documentation
    //     Route::get('/documentations', [DocumentationController::class, 'index'])->name('documentations.index');
    // Route::get('/documentations/create', [DocumentationController::class, 'create'])->name('documentations.create');
    // Route::post('/documentations', [DocumentationController::class, 'store'])->name('documentations.store');
    // Route::get('/documentations/{documentation}', [DocumentationController::class, 'show'])->name('documentations.show');
    // Route::get('/documentations/{documentation}/edit', [DocumentationController::class, 'edit'])->name('documentations.edit');
    // Route::put('/documentations/{documentation}', [DocumentationController::class, 'update'])->name('documentations.update');
    // Route::delete('/documentations/{documentation}', [DocumentationController::class, 'destroy'])->name('documentations.destroy');
    // Route::get('/documentations/{documentation}/download', [DocumentationController::class, 'download'])->name('documentations.download');


    Route::get('brand-settings', [BrandSettingController::class, 'index'])->name('brand_settings.index');
    Route::post('brand-settings', [BrandSettingController::class, 'store'])->name('brand_settings.store');
    Route::post('brand-settings/{id}', [BrandSettingController::class, 'update'])->name('brand_settings.update');
    Route::delete('brand-settings/{id}', [BrandSettingController::class, 'destroy'])->name('brand_settings.destroy');


    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::post('/documents/assign-user', [DocumentController::class, 'storeForUser'])->name('documents.storeForUser');
    Route::get('/documents/data', [DocumentController::class, 'data'])->name('documents.data');
    Route::get('/documents/{document}/versions', [DocumentController::class, 'showVersions'])->name('documents.versions');

    Route::get('/tests', [TestPlanController::class, 'index'])->name('tests.index');
    Route::get('/tests/{testPlan}', [TestPlanController::class, 'show'])->name('tests.show');

    Route::post('/tests', [TestPlanController::class, 'store'])->name('tests.store');
    Route::put('/tests/{testPlan}', [TestPlanController::class, 'update'])->name('tests.update');
    Route::delete('/tests/{testPlan}', [TestPlanController::class, 'destroy'])->name('tests.destroy');
    Route::post('/tests/assign-user', [TestPlanController::class, 'storeForUser'])->name('tests.storeForUser');
    Route::post('/tests/{testPlan}/test-cases', [TestPlanController::class, 'storeTestCase'])->name('tests.storeTestCase');
    Route::put('/test-cases/{testCase}', [TestPlanController::class, 'updateTestCase'])->name('tests.updateTestCase');
    Route::delete('/test-cases/{testCase}', [TestPlanController::class, 'destroyTestCase'])->name('tests.destroyTestCase');
    Route::get('/tests/{testPlan}/export-excel', [TestPlanController::class, 'exportExcel'])->name('tests.exportExcel');
    Route::get('/tests/{testPlan}/export-pdf', [TestPlanController::class, 'exportPdf'])->name('tests.exportPdf');

    Route::get('/security-gaps', [SecurityGapController::class, 'index'])->name('security-gaps.index');
    Route::post('/security-gaps', [SecurityGapController::class, 'store'])->name('security-gaps.store');
    Route::put('/security-gaps/{securityGap}', [SecurityGapController::class, 'update'])->name('security-gaps.update');
    Route::delete('/security-gaps/{securityGap}', [SecurityGapController::class, 'destroy'])->name('security-gaps.destroy');
    Route::post('/security-gaps/assign-user', [SecurityGapController::class, 'storeForUser'])->name('security-gaps.storeForUser');
    Route::get('/security-gaps/data', [SecurityGapController::class, 'data'])->name('security-gaps.data');

    Route::get('/security-gap-templates', [SecurityGapTemplateController::class, 'index'])->name('security-gap-templates.index');
    Route::post('/security-gap-templates', [SecurityGapTemplateController::class, 'store'])->name('security-gap-templates.store');
    Route::put('/security-gap-templates/{template}', [SecurityGapTemplateController::class, 'update'])->name('security-gap-templates.update');
    Route::delete('/security-gap-templates/{template}', [SecurityGapTemplateController::class, 'destroy'])->name('security-gap-templates.destroy');

    Route::get('/systems', [SystemController::class, 'index'])->name('systems.index');
    Route::get('/systems/{system}', [SystemController::class, 'show'])->name('systems.show');
    Route::post('/systems', [SystemController::class, 'store'])->name('systems.store');
    Route::put('/systems/{system}', [SystemController::class, 'update'])->name('systems.update');
    Route::delete('/systems/{system}', [SystemController::class, 'destroy'])->name('systems.destroy');
    Route::post('/systems/assign-user', [SystemController::class, 'storeForUser'])->name('systems.storeForUser');
    Route::post('/systems/assign-all', [SystemController::class, 'storeForAll'])->name('systems.storeForAll');
    Route::post('/systems/{system}/features', [SystemController::class, 'storeFeature'])->name('systems.storeFeature');
    Route::put('/systems/{system}/features/{feature}', [SystemController::class, 'updateFeature'])->name('systems.updateFeature');
    Route::delete('/systems/{system}/features/{feature}', [SystemController::class, 'destroyFeature'])->name('systems.destroyFeature');
    Route::post('/systems/{system}/requirements', [SystemController::class, 'storeRequirement'])->name('systems.storeRequirement');
    Route::put('/systems/{system}/requirements/{requirement}', [SystemController::class, 'updateRequirement'])->name('systems.updateRequirement');
    Route::delete('/systems/{system}/requirements/{requirement}', [SystemController::class, 'destroyRequirement'])->name('systems.destroyRequirement');
    Route::get('/systems/{system}/export-excel', [SystemController::class, 'exportExcel'])->name('systems.exportExcel');
    Route::get('/systems/{system}/export-pdf', [SystemController::class, 'exportPdf'])->name('systems.exportPdf');
    // Routes for dynamic dropdowns
    Route::get('/modules/by-system', function (Request $request) {
        return Module::where('system_id', $request->system_id)->get(['id', 'name']);
    })->name('modules.bySystem');

    Route::get('/submodules/by-module', function (Request $request) {
        return Submodule::where('module_id', $request->module_id)->get(['id', 'name']);
    })->name('submodules.byModule');

    Route::get('/features/by-system', function (Request $request) {
        $query = Feature::where('system_id', $request->system_id);
        if ($request->module_id) {
            $query->where(function ($q) use ($request) {
                $q->where('module_id', $request->module_id)->orWhereNull('module_id');
            });
        }
        if ($request->submodule_id) {
            $query->where(function ($q) use ($request) {
                $q->where('submodule_id', $request->submodule_id)->orWhereNull('submodule_id');
            });
        }
        return $query->get(['id', 'title']);
    })->name('features.bySystem');

    // Module routes
    Route::post('/systems/{system}/modules', [SystemController::class, 'storeModule'])->name('systems.storeModule'); // Module creation
    Route::put('/systems/{system}/modules/{module}', [SystemController::class, 'updateModule'])->name('systems.updateModule');
    Route::delete('/systems/{system}/modules/{module}', [SystemController::class, 'destroyModule'])->name('systems.destroyModule');
    // Submodule routes
    Route::post('/systems/{system}/submodules', [SystemController::class, 'storeSubmodule'])->name('systems.storeSubmodule'); // Submodule creation
    Route::put('/systems/{system}/submodules/{submodule}', [SystemController::class, 'updateSubmodule'])->name('systems.updateSubmodule');
    Route::delete('/systems/{system}/submodules/{submodule}', [SystemController::class, 'destroySubmodule'])->name('systems.destroySubmodule');

    Route::get('/systems/{system}/export-features-excel', [SystemController::class, 'exportFeaturesExcel'])->name('systems.exportFeaturesExcel');
    Route::get('/systems/{system}/export-requirements-excel', [SystemController::class, 'exportRequirementsExcel'])->name('systems.exportRequirementsExcel');
    Route::get('/systems/{system}/export-features-pdf', [SystemController::class, 'exportFeaturesPdf'])->name('systems.exportFeaturesPdf');
    Route::get('/systems/{system}/export-requirements-pdf', [SystemController::class, 'exportRequirementsPdf'])->name('systems.exportRequirementsPdf');

    Route::prefix('systems/{system}')->group(function () {
        Route::get('/projects', [SystemController::class, 'showProjects'])->name('systems.projects');
        Route::get('/modules', [SystemController::class, 'showModules'])->name('systems.modules');
        Route::get('/submodules', [SystemController::class, 'showSubmodules'])->name('systems.submodules');
        Route::get('/features', [SystemController::class, 'showFeatures'])->name('systems.features');
        Route::get('/requirements', [SystemController::class, 'showRequirements'])->name('systems.requirements');
    });
    // Route::get('/system-designs', [SystemDesignController::class, 'index'])->name('system-designs.index');
    // Route::post('/system-designs', [SystemDesignController::class, 'store'])->name('system-designs.store');
    // Route::put('/system-designs/{systemDesign}', [SystemDesignController::class, 'update'])->name('system-designs.update');
    // Route::delete('/system-designs/{systemDesign}', [SystemDesignController::class, 'destroy'])->name('system-designs.destroy');
    // Route::get('/system-designs/{systemDesign}/export', [SystemDesignController::class, 'export'])->name('system-designs.export');
    // Route::get('/system-designs/{systemDesign}/versions', [SystemDesignController::class, 'versions'])->name('system-designs.versions');

    Route::get('/system-designs', [SystemDesignController::class, 'index'])->name('system-designs.index');
    Route::post('/system-designs', [SystemDesignController::class, 'store'])->name('system-designs.store');
    Route::put('/system-designs/{systemDesign}', [SystemDesignController::class, 'update'])->name('system-designs.update');
    Route::delete('/system-designs/{systemDesign}', [SystemDesignController::class, 'destroy'])->name('system-designs.destroy');

    Route::get('/drawio-editor', function () {
        return view('drawio.editor');
    })->name('drawio.editor');

    Route::get('/system-manuals', [SystemManualController::class, 'index'])->name('system-manuals.index');
    Route::post('/system-manuals', [SystemManualController::class, 'store'])->name('system-manuals.store');
    Route::put('/system-manuals/{systemManual}', [SystemManualController::class, 'update'])->name('system-manuals.update');
    Route::delete('/system-manuals/{systemManual}', [SystemManualController::class, 'destroy'])->name('system-manuals.destroy');

    Route::get('/standards', [StandardController::class, 'index'])->name('standards.index');
    Route::post('/standards', [StandardController::class, 'store'])->name('standards.store');
    Route::put('/standards/{standard}', [StandardController::class, 'update'])->name('standards.update');
    Route::delete('/standards/{standard}', [StandardController::class, 'destroy'])->name('standards.destroy');
    Route::get('standards/{standard}/download', [StandardController::class, 'download'])->name('standards.download');



    // Users Routes
    Route::get('/users-roles', [UserRoleController::class, 'index'])->name('users-roles.index');
    Route::get('/users-roles/create', [UserRoleController::class, 'create'])->name('users-roles.create');
    Route::post('/users-roles/store', [UserRoleController::class, 'store'])->name('users-roles.store');
    Route::get('/users-roles/{id}/show', [UserRoleController::class, 'show'])->name('users-roles.show');
    Route::get('/users-roles/{id}/edit', [UserRoleController::class, 'edit'])->name('users-roles.edit');
    Route::put('/users-roles/update/{id}', [UserRoleController::class, 'update'])->name('users-roles.update');
    Route::delete('/users-roles/destroy/{id}', [UserRoleController::class, 'destroy'])->name('users-roles.destroy');
});



require __DIR__ . '/auth.php';
