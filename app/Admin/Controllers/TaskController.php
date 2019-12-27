<?php

namespace App\Admin\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class TaskController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header(trans('admin.index'))
            ->description(trans('admin.description'))
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header(trans('admin.detail'))
            ->description(trans('admin.description'))
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header(trans('admin.edit'))
            ->description(trans('admin.description'))
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header(trans('admin.create'))
            ->description(trans('admin.description'))
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Task);

        $grid->id('ID');
        $grid->name(__('name'));
        $grid->type(__('type'))->display(function ($type) {
            return Task::$task_type_arr[$type];
        });
        $grid->status(__('status'))->display(function ($status) {
            return Task::$task_status_arr[$status];
        });
        $grid->column('project_id', '项目名称')->display(function ($project_id) {
            return Project::find($project_id)->name;
        });
//        $grid->description(__('description'));
        $grid->created_at(trans('admin.created_at'));
        $grid->updated_at(trans('admin.updated_at'));


        //增加筛选
        $grid->filter(function ($filter) {
            // 在这里添加字段过滤器
            $filter->like('name', __('name'));
            $filter->equal('type', __('type'))->select(Task::$task_type_arr);
            $filter->equal('status', __('status'))->select(Task::$task_status_arr);
            $filter->equal('project_id', '项目名称')->select(Project::all()->pluck('name', 'id'));
        });

        //数据操作
        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉查看
            $actions->disableView();
        });

        //增加快捷键
        $grid->enableHotKeys();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Task::findOrFail($id));

        $show->id('ID');
        $show->name(__('name'));
        $show->type(__('type'));
        $show->status(__('status'));
        $show->project_id('project_id');
        $show->description(__('description'));
        $show->created_at(__('admin.created_at'));
        $show->updated_at(__('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Task);

        $form->display('id', 'ID');
        $form->text('name', __('name'))->rules('required');
        $form->select('type', __('type'))->options(Task::$task_type_arr)->rules('required');
        $form->select('status', __('status'))->options(Task::$task_status_arr)->rules('required');
        $form->select('project_id', '所属项目')->options(Project::all()->pluck('name', 'id'))->rules('required');
        $form->editor('description', __('description'))->rules('required');

        $form->cropper('image',__('image'));

        $form->display('created_at', __('admin.created_at'));
        $form->display('updated_at', __('admin.updated_at'));

        return $form;
    }
}
