<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ColecaoRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ColecaoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ColecaoCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Colecao::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/colecao');
        CRUD::setEntityNameStrings('colecão', 'colecões');

        $this->crud->addColumn([  // Select
            'label'     => "Produtos",
            'type'      => 'select_multiple',
            'name'      => 'produtos', // the db column for the foreign key
            
            // optional
            // 'entity' should point to the method that defines the relationship in your Model
            // defining entity will make Backpack guess 'model' and 'attribute'
            'entity'    => 'produtos',
            
            // optional - manually specify the related model and attribute
            'model'     => "App\Models\Produto", // related model
            'attribute' => 'nome', // foreign key attribute that is shown to user
            
            // optional - force the related options to be a custom query, instead of all();
            // 'options'   => (function ($query) {
            //         return $query->orderBy('nome', 'ASC')->get();
            //     }), //  you can use this to filter the results show in the select
        ]);

        CRUD::field([   // Upload
            'name'      => 'img',
            'label'     => 'Imagem',
            'type'      => 'upload'
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'img', // The db column name
            'label' => "Imagem", // Table column heading
            'type' => 'image',
        
            // OPTIONALS
            // 'prefix' => 'folder/subfolder/',
            // image from a different disk (like s3 bucket)
            // 'disk' => 'disk-name', 
        
            // optional width/height if 25px is not ok with you
            'height' => '2.5rem',
            'width' => '2.5rem',
        ]);

        CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        // CRUD::setValidation(ColecaoRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
