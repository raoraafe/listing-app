<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserRole;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Log;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup(): void
    {
        CRUD::setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation(): void
    {
        CRUD::column('name');
        CRUD::column('email');

        CRUD::addColumn([
            'label'     => 'Role',
            'type'      => 'select',
            'name'      => 'userRole', // Change this to the actual relationship method in your User model
            'entity'    => 'userRole', // Change this to the name of the relationship method in your User model
            'attribute' => 'title', //
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(UserRequest::class);

        CRUD::field('name');
        CRUD::field('email');

        $selectedRole = null;
        if (CRUD::getCurrentEntryId() !== null) {
            // Get selected role by current user id.
            $selectedRole = User::find(CRUD::getCurrentEntryId())->userRole->pluck('id')->first();
        }

        CRUD::addField([
            'label'     => 'Role',
            'type'      => 'select',
            'name'      => 'userRole', // Change this to the actual relationship method in your User model
            'entity'    => 'userRole', // Change this to the name of the relationship method in your User model
            'attribute' => 'title', // Change this to the attribute you want to display from the Role model
            'model'     => 'App\Models\UserRole', // Change this to the namespace of your Role model
            'pivot'     => true, // Set this to true if your relationship uses a pivot table
            'value'   => $selectedRole, // For default, used value and assign role id of current user.
            'options'   => (function ($query) {
                // Return UserRole model object with data.
                return $query->orderBy('title', 'ASC')->get();
            })
        ]);

        CRUD::field('password');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
