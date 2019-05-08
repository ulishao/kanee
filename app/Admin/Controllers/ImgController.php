<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Img;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use phpDocumentor\Reflection\Types\Context;

class ImgController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index( Content $content )
    {
        return $content->header( 'Index' )->description( 'description' )->body( $this->grid() );
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show( $id , Content $content )
    {
        return $content->header( 'Detail' )->description( 'description' )->body( $this->detail( $id ) );
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit( $id , Content $content )
    {
        return $content->header( 'Edit' )->description( 'description' )->body( $this->form()->edit( $id ) );
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create( Content $content )
    {
        return $content->header( 'Create' )->description( 'description' )->body( $this->form() );
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid( new Img);

        $grid->id( 'ID' )->sortable();
        $grid->title();
        $grid->imgs();

        $grid->img()->display(function($img) {
            return '<img src="'.$img.'" width=90px height=90px>';
        });
        $grid->source_url();
        $grid->created_at( 'Created at' );
        $grid->updated_at( 'Updated at' );

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail( $id )
    {
        $show = new Show( Img::findOrFail( $id ) );

        $show->id( 'ID' );
        $show->img();
        $show->source_url();
        $show->created_at( 'Created at' );
        $show->updated_at( 'Updated at' );

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form( new Img );

        $form->display( 'id' , 'ID' );
        $form->display( 'img' , 'img' );
        $form->display( 'imgs' , 'imgs' );
        $form->display( 'created_at' , 'Created At' );
        $form->display( 'updated_at' , 'Updated At' );

        return $form;
    }
}
